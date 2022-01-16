<?php

namespace App\Services\BscscanService;

use App\Services\BscscanService\BscscanTransformer;
use App\Services\{
    SmartChainService,
    ApiClient
};

class BscscanService implements SmartChainService
{
    private $apiClient; // API Client for Bscscan
    private $smartchain = 'bscscan';
    private $config;

    public function __construct()
    {
        // Get configuration details for Bscscan APIs
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
        $options = BscscanTransformer::transformForTransactions(
            $options,
            $this->config
        );

        // Get data from API
        $transactions = $this->apiClient->callRequest(
            $options['url'],
            $options['params']
        );

        // Transform API response in required format
        return BscscanTransformer::transformTransactionsResponse(
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
        $options = BscscanTransformer::transformForWalletInfo(
            $walletAddress,
            $this->config
        );

        // Get data from API
        $walletInfo = $this->apiClient->callRequest(
            $options['url'],
            $options['params']
        );

        // Transform API response in required format
        return BscscanTransformer::transformWalletResponse(
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
        $options = BscscanTransformer::transformForBalance(
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