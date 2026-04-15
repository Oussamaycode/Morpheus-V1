<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class VastAiService
{
    private string $apiKey;
    private string $baseUrl = 'https://console.vast.ai/api/v0';

    public function __construct()
    {
        $this->apiKey = config('vastai.api_key');
    }

    /**
     * Find the first running instance on your account and return its Selkies stream URL.
     * No instance ID needed — it's picked up automatically.
     */
    public function getSelkiesStreamUrl(): string
    {
        $instance = $this->findRunningInstance();
        return $this->buildStreamUrl($instance);
    }

    /**
     * Check if any instance on your account is currently running.
     */
    public function isInstanceRunning(): bool
    {
        try {
            return $this->findRunningInstance() !== null;
        } catch (\Exception) {
            return false;
        }
    }

    /**
     * Fetch all instances and return the first one that is running.
     * Throws if none are found.
     */
    private function findRunningInstance(): array
    {
        $response = Http::withoutVerifying()
            ->withHeaders([
                'Authorization' => 'Bearer ' . env('VASTAI_API_KEY'),
            ])
            ->get("{$this->baseUrl}/instances/");

        if (!$response->successful()) {
            throw new RuntimeException(
                "Vast.ai API error: {$response->status()} - {$response->body()}"
            );
        }

        $instances = $response->json('instances') ?? [];

        if (empty($instances)) {
            throw new RuntimeException("No instances found.");
        }

        $running = collect($instances)
            ->first(fn($i) => ($i['actual_status'] ?? '') === 'running');

        if (!$running) {
            throw new RuntimeException("No running instance found.");
        }

        return $running;
    }

    /**
     * Build the Selkies HTTP stream URL from an instance array.
     */
    private function buildStreamUrl(array $instance): string
    {
        $ip = $instance['public_ipaddr'] ?? null;

        \Log::info('Vast.ai ports', ['ports' => $instance['ports'] ?? 'none']);

        if (!$ip) {
            throw new RuntimeException(
                "Running instance (ID: {$instance['id']}) has no public IP yet. Try again in a moment."
            );
        }

        $ports = $instance['ports'] ?? [];
        $mappedPort = $ports['6100/tcp'][0]['HostPort'] ?? null;

        if (!$mappedPort) {
            throw new RuntimeException(
                "Could not find mapped port for 8080 on instance {$instance['id']}. " .
                "Make sure the instance was launched with '-p 8080:8080' in the port mapping."
            );
        }

        return "http://{$ip}:{$mappedPort}";
    }
}