<?php

namespace App\Services;

interface SmartChainService
{
    /**
    * Get Transactions.
    *
    * @param array $options  Options for API
    * 
    * @return array
    */
    public function getTransactions(array $options): array;

    /**
    * Get Wallet information.
    *
    * @param string $walletAddress  Hexadecimal address of wallet
    * 
    * @return array
    */
    public function getWalletInfo(string $walletAddress): array;

    /**
    * Get wallet balance at specific date.
    *
    * @param array $options  Options for API
    * 
    * @return array
    */
    public function getHistoricalBalance(array $options): array;
}