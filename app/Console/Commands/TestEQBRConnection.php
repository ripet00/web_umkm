<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\EQBRBlockchainService;

class TestEQBRConnection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eqbr:test-connection';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test connection to EQBR blockchain service';

    protected $blockchainService;

    public function __construct(EQBRBlockchainService $blockchainService)
    {
        parent::__construct();
        $this->blockchainService = $blockchainService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing EQBR Blockchain connection...');
        $this->newLine();

        // Test basic connection
        $result = $this->blockchainService->testConnection();
        
        if ($result['success']) {
            $this->info('✅ Connected to EQBR successfully!');
            $this->info('Status Code: ' . $result['status_code']);
            
            if (isset($result['data'])) {
                $this->info('Available networks:');
                if (is_array($result['data'])) {
                    foreach ($result['data'] as $network) {
                        if (is_array($network)) {
                            $this->line('- ' . ($network['name'] ?? $network['id'] ?? 'Unknown'));
                        } else {
                            $this->line('- ' . $network);
                        }
                    }
                } else {
                    $this->line(json_encode($result['data'], JSON_PRETTY_PRINT));
                }
            }
        } else {
            $this->error('❌ Failed to connect to EQBR');
            $this->error('Error: ' . $result['error']);
        }

        $this->newLine();

        // Test get networks
        $this->info('Getting available networks...');
        $networks = $this->blockchainService->getNetworks();
        
        if ($networks['success']) {
            $this->info('✅ Networks retrieved successfully');
            $this->line(json_encode($networks['networks'], JSON_PRETTY_PRINT));
        } else {
            $this->error('❌ Failed to get networks');
            $this->error('Error: ' . $networks['error']);
        }

        return 0;
    }
}