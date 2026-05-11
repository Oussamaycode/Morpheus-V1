<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Sanctum\PersonalAccessToken;
use App\Http\Controllers\GameController;

class SteamController extends Controller
{
    public function redirect(Request $request)
    {
        $token = $request->query('token');

        // Temporarily override the redirect URL to include the token
        config(['services.steam.redirect' => env('STEAM_REDIRECT_URI') . '?token=' . $token]);

        return Socialite::driver('steam')
            ->setHttpClient(new \GuzzleHttp\Client(['verify' => false]))
            ->redirect();
    }

    public function callback(Request $request)
    {
        $openIdUrl = $request->query('openid_claimed_id');
        $steamId   = basename($openIdUrl);

        $token       = $request->query('token'); // 👈 read from URL directly
        $accessToken = PersonalAccessToken::findToken($token);
        $user        = $accessToken->tokenable;

        $user->update(['steam_id' => $steamId]);

        app(GameController::class)->fetchGames($user);

        return redirect('http://127.0.0.1:5501/index.html?steam=connected');
    }
}