<?php

namespace App\Services\EmailMarketing;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EmailBlasterUKService implements EmailMarketingService
{
    protected string $apiKey;
    protected string $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.emailblaster.api_key');
        $this->baseUrl = config('services.emailblaster.base_url');
    }

    public function addToList(array $data, string $listId): string
    {
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'api_key' => $this->apiKey,
            ])->post("{$this->baseUrl}/subscriber/subscribe", [
                'list' => $listId,
                'email' => $data['email'],
                'first_name' => $data['first_name'] ?? '',
                'surname' => $data['last_name'] ?? '',
                'salutation' => $data['title'] ?? '',
            ]);

            if ($response->successful()) {
                $body = $response->json();
                $subscriber_id = $body['subscriber_id'] ?? null;

                Log::info('EmailBlaster: Subscriber added', [
                    'email' => $data['email'],
                    'subscriber_id' => $subscriber_id,
                    'list_id' => $listId,
                ]);

                return $subscriber_id;
            }

            Log::warning('EmailBlaster: Failed to add subscriber', [
                'response' => $response->body(),
                'status' => $response->status(),
            ]);

            return false;

        } catch (\Throwable $e) {
            Log::error('EmailBlaster Exception', [
                'error' => $e->getMessage(),
                'data' => $data,
                'list_id' => $listId,
            ]);

            return false;
        }
    }


    public function removeFromList(string $subscriber_id): bool
    {
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'api_key' => $this->apiKey,
            ])->delete("{$this->baseUrl}/subscriber/delete/{$subscriber_id}");

            if ($response->successful()) {
                Log::info('EmailBlaster: Subscriber removed by id');
                return true;
            }

            Log::warning('EmailBlaster: Failed to remove by id', [
                'response' => $response->body(),
                'status' => $response->status()
            ]);

            return false;
        } catch (\Throwable $e) {
            Log::error('EmailBlaster Exception on email delete', [
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    public function updateSubscriber(string $subscriber_id, array $data): bool
    {
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'api_key' => $this->apiKey,
            ])->patch("{$this->baseUrl}/subscriber/update/{$subscriber_id}",[
                'email' => $data['email'],
                'first_name' => $data['first_name'] ?? '',
                'surname' => $data['last_name'] ?? '',
                'salutation' => $data['title'] ?? '',
            ]);

            if ($response->successful()) {
                Log::info('EmailBlaster: Subscriber updated');
                return true;
            }

            Log::warning('EmailBlaster: Failed to update subscriber', [
                'response' => $response->body(),
                'status' => $response->status()
            ]);

            return false;
        } catch (\Throwable $e) {
            Log::error('EmailBlaster Failed to update subscriber', [
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    public function fetchFolders(): array|string
    {
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'api_key' => $this->apiKey,
            ])->get("{$this->baseUrl}/lists/folderview");

            if ($response->successful()) {
                $data = $response->json();
                return $data['folders'] ?? [];
            }

            Log::warning('EmailBlaster: Failed to fetch folders', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return "Failed to fetch folder data.";
        } catch (\Throwable $e) {
            Log::error('EmailBlaster: Exception while fetching folders', [
                'error' => $e->getMessage()
            ]);
            return "Failed to fetch folder data.";
        }
    }

    public function createMailingListInFolder(string $folder_id, string $list_name): ?string
    {
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'api_key' => $this->apiKey,
            ])->post("{$this->baseUrl}/lists/create", [
                'folder_id'    => $folder_id,
                'name'         => $list_name,
                'type'         => 'B2C',
                'third_party'  => 'N',
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['list_id'] ?? null;
            }

            Log::warning('EmailBlaster: Failed to create mailing list', [
                'response' => $response->body(),
                'status' => $response->status(),
            ]);

            return null;

        } catch (\Throwable $e) {
            Log::error('EmailBlaster Exception in createMailingListInFolder', [
                'error' => $e->getMessage(),
                'folder_id' => $folder_id,
                'list_name' => $list_name,
            ]);

            return null;
        }
    }


}

?>
