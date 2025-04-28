<?php
namespace App\Services;
use Illuminate\Support\Facades\Http;

class TripayService {
    protected $baseUrl, $apiKey, $privateKey, $merchantCode;

    public function __construct()
    {
        $this->baseUrl = config('tripay.base_url');
        $this->apiKey = config('tripay.api_key');
        $this->privateKey = config('tripay.private_key');
        $this->merchantCode = config('tripay.merchant_code');
    }

    public function getChannels()
    {
        dd($this->apiKey);
        return Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->get("{$this->baseUrl}/merchant/payment-channel")->json();
    }

    public function createTransaction(array $payload)
    {
        $signature = hash_hmac('sha256', $this->merchantCode . $payload['merchant_ref'] . $payload['amount'], $this->privateKey);

        $payload['signature'] = $signature;

        return Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->post("{$this->baseUrl}/transaction/create", $payload)->json();
    }

    public function getTransactionDetail($reference)
    {
        return Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->get("{$this->baseUrl}/transaction/detail?reference={$reference}")->json();
    }
}
