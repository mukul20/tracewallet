<?php

namespace App\Services\PolygonscanService;

use App\Services\PolygonscanService\PolygonscanTransformer;
use App\Services\{
    SmartChainService,
    ApiClient
};

class PolygonscanService implements SmartChainService
{
    private $apiClient; // API Client for Polygonscan
    private $smartchain = 'polygonscan';
    private $config;

    public function __construct()
    {
        // Get configuration details for Polygonscan APIs
        $this->config = config('smartchain.' . $this->smartchain);
        $this->apiClient = new ApiClient($this->config);
    }

    /**
    * Get Transactions
    *
    * @param array $options  Options for API
    * 
    * @return array
    */
    public function getTransactions(array $options): array
    {
        // Transform options as required by API
        $options = PolygonscanTransformer::transformForTransactions(
            $options,
            $this->config
        );

        // Get data from API
        $transactions = $this->apiClient->callRequest(
            $options['url'],
            $options['params']
        );

        // Transform API response in required format
        return PolygonscanTransformer::transformTransactionsResponse(
            $transactions,
            $this->config
        );
    }

    /**
    * Get Wallet information.
    *
    * @param string $walletAddress  Hexadecimal address of wallet
    * 
    * @return array
    */
    public function getWalletInfo(string $walletAddress): array
    {
        // Transform options as required by API
        $options = PolygonscanTransformer::transformForWalletInfo(
            $walletAddress,
            $this->config
        );

        // Get data from API
        $walletInfo = $this->apiClient->callRequest(
            $options['url'],
            $options['params']
        );

        // Transform API response in required format
        return PolygonscanTransformer::transformWalletResponse(
            $walletInfo,
            $this->config
        );
    }

    /**
    * Get wallet balance at specific date.
    *
    * @param array $options  Options for API
    * 
    * @return array
    */
    public function getHistoricalBalance(array $option): array
    {
        // Transform options as required by API
        $options = PolygonscanTransformer::transformForBalance(
            $option,
            $this->config
        );

        // Get data from API
        return $this->apiClient->callRequest(
            $options['url'],
            $options['params']
        );
    }
}