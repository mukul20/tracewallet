<?php

namespace App\Services\EtherscanService;

use App\Services\EtherscanService\EtherscanTransformer;
use App\Services\{
    SmartChainService,
    ApiClient
};

class EtherscanService implements SmartChainService
{
    private $apiClient; // API Client for Etherscan
    private $smartchain = 'etherscan';
    private $config;

    public function __construct()
    {
        // Get configuration details for Etherscan APIs
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
        $options = EtherscanTransformer::transformForTransactions(
            $options,
            $this->config
        );

        // Get data from API
        $transactions = $this->apiClient->callRequest(
            $options['url'],
            $options['params']
        );

        // Transform API response in required format
        return EtherscanTransformer::transformTransactionsResponse(
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
        $options = EtherscanTransformer::transformForWalletInfo(
            $walletAddress,
            $this->config
        );

        // Get data from API
        $walletInfo = $this->apiClient->callRequest(
            $options['url'],
            $options['params']
        );

        // Transform API response in required format
        return EtherscanTransformer::transformWalletResponse(
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
        $options = EtherscanTransformer::transformForBalance(
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