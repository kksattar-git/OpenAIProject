<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class OpenAiService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('OPENAI_API_KEY');
    }

    public function summarizeLogs($logData)
    {
        try {
            $response = $this->client->post('https://api.openai.com/v1/completions', [
                'json' => [
                    'model' => 'text-davinci-003',
                    'prompt' => "Summarize the following logs:\n" . $logData,
                    'max_tokens' => 150
                ],
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey
                ]
            ]);

            $body = json_decode($response->getBody(), true);
            return $body['choices'][0]['text'] ?? 'No summary generated.';
        } catch (\Exception $e) {
            Log::error('OpenAI API Error: ' . $e->getMessage());
            return 'Error in generating summary.';
        }
    }
}
