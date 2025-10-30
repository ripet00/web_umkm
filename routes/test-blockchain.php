<?php

use Illuminate\Support\Facades\Route;
use App\Services\EQBRBlockchainService;

Route::get('/test-blockchain', function () {
    try {
        $blockchainService = new EQBRBlockchainService();
        
        echo "<h1>Testing EQBR Blockchain Connection</h1>";
        echo "<hr>";
        
        // Test connection
        echo "<h2>1. Testing Basic Connection</h2>";
        $result = $blockchainService->testConnection();
        
        if ($result['success']) {
            echo "<p style='color: green;'>✅ Connected to EQBR successfully!</p>";
            echo "<p>Status Code: " . $result['status_code'] . "</p>";
            if (isset($result['data'])) {
                echo "<pre>" . json_encode($result['data'], JSON_PRETTY_PRINT) . "</pre>";
            }
        } else {
            echo "<p style='color: red;'>❌ Failed to connect to EQBR</p>";
            echo "<p>Error: " . $result['error'] . "</p>";
        }
        
        echo "<hr>";
        
        // Test get networks
        echo "<h2>2. Getting Available Networks</h2>";
        $networks = $blockchainService->getNetworks();
        
        if ($networks['success']) {
            echo "<p style='color: green;'>✅ Networks retrieved successfully</p>";
            echo "<pre>" . json_encode($networks['networks'], JSON_PRETTY_PRINT) . "</pre>";
        } else {
            echo "<p style='color: red;'>❌ Failed to get networks</p>";
            echo "<p>Error: " . $networks['error'] . "</p>";
        }
        
        echo "<hr>";
        
        // Test transaction hashing (simulation)
        echo "<h2>3. Testing Transaction Hash (Simulation)</h2>";
        
        // Create a mock order for testing
        $testOrder = new \App\Models\Order();
        $testOrder->id = 999; // Test ID
        $testOrder->total_amount = 150000;
        $testOrder->payment_method = 'midtrans';
        $testOrder->user_id = 1;
        $testOrder->created_at = now();
        
        echo "<p>Test order data:</p>";
        echo "<pre>Order ID: " . $testOrder->id . "\n";
        echo "Amount: " . $testOrder->total_amount . "\n";
        echo "Payment Method: " . $testOrder->payment_method . "\n";
        echo "User ID: " . $testOrder->user_id . "\n";
        echo "Created At: " . $testOrder->created_at . "</pre>";
        
        $hashResult = $blockchainService->hashTransaction($testOrder);
        
        if ($hashResult['success']) {
            echo "<p style='color: green;'>✅ Transaction hashed successfully!</p>";
            echo "<p>Hash: " . $hashResult['hash'] . "</p>";
            if (isset($hashResult['transaction_id'])) {
                echo "<p>Transaction ID: " . $hashResult['transaction_id'] . "</p>";
            }
            if (isset($hashResult['block_number'])) {
                echo "<p>Block Number: " . $hashResult['block_number'] . "</p>";
            }
        } else {
            echo "<p style='color: red;'>❌ Failed to hash transaction</p>";
            echo "<p>Error: " . $hashResult['error'] . "</p>";
        }
        
    } catch (Exception $e) {
        echo "<p style='color: red;'>Exception: " . $e->getMessage() . "</p>";
        echo "<pre>" . $e->getTraceAsString() . "</pre>";
    }
});