<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class EQBRBlockchainService
{
    protected $client;
    protected $apiUrl;
    protected $apiKey;
    protected $web3Provider;
    protected $enabled;

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 30,
            'verify' => false, // For development, enable in production
        ]);
        
        $this->apiUrl = config('blockchain.eqbr.api_url');
        $this->apiKey = config('blockchain.eqbr.api_key');
        $this->web3Provider = config('blockchain.eqbr.web3_provider');
        $this->enabled = config('blockchain.eqbr.enabled', true);
    }

    /**
     * Test koneksi ke EQBR API
     */
    public function testConnection(): array
    {
        try {
            $response = $this->client->request('GET', $this->apiUrl . '/api/v2/networks', [
                'headers' => [
                    'accept' => 'application/json',
                    'x-eq-ag-api-key' => $this->apiKey,
                ],
            ]);

            $data = json_decode($response->getBody(), true);
            
            return [
                'success' => true,
                'status_code' => $response->getStatusCode(),
                'data' => $data,
                'message' => 'Connected to EQBR successfully'
            ];

        } catch (RequestException $e) {
            Log::error('EQBR Connection failed', [
                'error' => $e->getMessage(),
                'code' => $e->getCode()
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
                'message' => 'Failed to connect to EQBR'
            ];
        }
    }

    /**
     * Hash transaksi order ke blockchain EQBR
     */
    public function hashTransaction(Order $order): array
    {
        if (!$this->enabled) {
            return [
                'success' => false,
                'message' => 'Blockchain service is disabled'
            ];
        }

        // Siapkan data transaksi untuk di-hash
        $transactionData = $this->prepareTransactionData($order);
        
        // Generate hash lokal
        $localHash = hash('sha256', json_encode($transactionData));
        
        try {
            // Log transaksi yang akan di-hash
            Log::info('Hashing transaction to EQBR', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'local_hash' => $localHash
            ]);

            // Kirim ke EQBR blockchain
            $response = $this->client->request('POST', $this->apiUrl . '/api/v2/transactions', [
                'headers' => [
                    'accept' => 'application/json',
                    'content-type' => 'application/json',
                    'x-eq-ag-api-key' => $this->apiKey,
                ],
                'json' => [
                    'transaction_data' => $transactionData,
                    'local_hash' => $localHash,
                    'metadata' => [
                        'marketplace' => 'AMPUH_UMKM',
                        'order_id' => $order->id,
                        'order_number' => $order->order_number,
                        'timestamp' => now()->toISOString(),
                    ]
                ]
            ]);

            $result = json_decode($response->getBody(), true);
            
            Log::info('Transaction hashed successfully', [
                'order_id' => $order->id,
                'blockchain_response' => $result
            ]);

            return [
                'success' => true,
                'blockchain_hash' => $result['hash'] ?? $result['transaction_hash'] ?? null,
                'transaction_id' => $result['transaction_id'] ?? $result['id'] ?? null,
                'block_number' => $result['block_number'] ?? $result['block'] ?? null,
                'local_hash' => $localHash,
                'network_id' => $result['network_id'] ?? null,
                'raw_response' => $result,
            ];

        } catch (RequestException $e) {
            Log::error('Failed to hash transaction to EQBR', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
                'response' => $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : null
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
                'local_hash' => $localHash,
            ];
        }
    }

    /**
     * Siapkan data transaksi untuk blockchain
     */
    private function prepareTransactionData(Order $order): array
    {
        return [
            'order_info' => [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'user_id' => $order->user_id,
                'seller_id' => $order->seller_id,
                'total_price' => (float) $order->total_price,
                'payment_status' => $order->payment_status,
                'status' => $order->status,
                'created_at' => $order->created_at->toISOString(),
            ],
            'items' => $order->orderItems->map(function($item) {
                return [
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->nama_produk ?? 'Unknown Product',
                    'quantity' => $item->quantity,
                    'price' => (float) $item->price,
                    'subtotal' => (float) ($item->quantity * $item->price),
                ];
            })->toArray(),
            'seller_info' => [
                'id' => $order->seller->id,
                'nama_koperasi' => $order->seller->nama_koperasi,
                'merchant_id' => $order->seller->merchant_id ?? null,
            ],
            'user_info' => [
                'id' => $order->user->id,
                'nama' => $order->user->nama,
            ],
            'payment_info' => [
                'gateway' => $order->payment_gateway,
                'snap_token' => $order->snap_token,
            ],
            'hash_metadata' => [
                'timestamp' => now()->timestamp,
                'marketplace' => 'AMPUH_UMKM',
                'version' => '1.0',
            ]
        ];
    }

    /**
     * Verifikasi hash di blockchain
     */
    public function verifyHash(string $blockchainHash, string $transactionId = null): array
    {
        try {
            $endpoint = $transactionId 
                ? "/api/v2/transactions/{$transactionId}"
                : "/api/v2/transactions/hash/{$blockchainHash}";

            $response = $this->client->request('GET', $this->apiUrl . $endpoint, [
                'headers' => [
                    'accept' => 'application/json',
                    'x-eq-ag-api-key' => $this->apiKey,
                ],
            ]);

            $result = json_decode($response->getBody(), true);

            return [
                'success' => true,
                'verified' => true,
                'transaction_data' => $result,
            ];

        } catch (RequestException $e) {
            return [
                'success' => false,
                'verified' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Get available networks
     */
    public function getNetworks(): array
    {
        try {
            $response = $this->client->request('GET', $this->apiUrl . '/api/v2/networks', [
                'headers' => [
                    'accept' => 'application/json',
                    'x-eq-ag-api-key' => $this->apiKey,
                ],
            ]);

            return [
                'success' => true,
                'networks' => json_decode($response->getBody(), true)
            ];

        } catch (RequestException $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}