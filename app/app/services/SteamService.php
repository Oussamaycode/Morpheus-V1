<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SteamService
{
    private string $apiKey;
    private string $openIdUrl = 'https://steamcommunity.com/openid/login';

    public function __construct()
    {
        $this->apiKey = config('steam.api_key');
    }

    // Build the URL that sends the user to Steam to log in
    public function getRedirectUrl(): string
    {
        $params = [
            'openid.ns'         => 'http://specs.openid.net/auth/2.0',
            'openid.mode'       => 'checkid_setup',
            'openid.return_to'  => config('steam.redirect_uri'),
            'openid.realm'      => config('app.url'),
            'openid.identity'   => 'http://specs.openid.net/auth/2.0/identifier_select',
            'openid.claimed_id' => 'http://specs.openid.net/auth/2.0/identifier_select',
        ];

        return $this->openIdUrl . '?' . http_build_query($params);
    }

    // After Steam redirects back, verify the response and extract the Steam ID
    public function extractSteamId(array $params): ?string
    {
        if (($params['openid_mode'] ?? '') !== 'id_res') {
            return null;
        }

        // Verify the response with Steam
        $verifyParams = $params;
        $verifyParams['openid_mode'] = 'check_authentication';

        $response = Http::asForm()->post($this->openIdUrl, array_combine(
            array_map(fn($k) => str_replace('_', '.', $k), array_keys($verifyParams)),
            array_values($verifyParams)
        ));

        if (!str_contains($response->body(), 'is_valid:true')) {
            return null;
        }

        // Steam ID is at the end of the claimed_id URL
        // e.g. https://steamcommunity.com/openid/id/76561198xxxxxxxxx
        preg_match('/\/id\/(\d+)$/', $params['openid_claimed_id'] ?? '', $matches);

        return $matches[1] ?? null;
    }

    // Fetch all games owned by the user
    public function getOwnedGames(string $steamId): array
    {
        $response = Http::get('https://api.steampowered.com/IPlayerService/GetOwnedGames/v1/', [
            'key'                   => $this->apiKey,
            'steamid'               => $steamId,
            'include_appinfo'       => true,
            'include_played_free_games' => true,
        ]);

        if (!$response->successful()) {
            return [];
        }

        $games = $response->json('response.games') ?? [];

        // Sort by most recently played
        usort($games, fn($a, $b) => ($b['rtime_last_played'] ?? 0) - ($a['rtime_last_played'] ?? 0));

        return array_map(fn($game) => [
            'app_id'       => $game['appid'],
            'name'         => $game['name'],
            'playtime_hrs' => round(($game['playtime_forever'] ?? 0) / 60, 1),
            'logo'         => "https://media.steampowered.com/steamcommunity/public/images/apps/{$game['appid']}/{$game['img_logo_url']}.jpg",
            'last_played'  => $game['rtime_last_played'] ?? 0,
        ], $games);
    }
}