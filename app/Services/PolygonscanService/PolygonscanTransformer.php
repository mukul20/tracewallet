<?php

namespace App\Services\PolygonscanService;

class PolygonscanTransformer
{
    /**
    * Transform parameters for API call
    *
    * @param array $options API Params
    * @param array $config  API config data
    * 
    * @return array;
    */
    static function transformForTransactions(array $options, array $config): array
    {
        return [
            'url' => $config['baseUrl'],
            'params' => [
                'module'     => 'account',
                'action'     => 'txlist',
                'address'    => $options['walletAddress'],
                'startblock' => $options['startblock'] ?? 0,
                'endblock'   => $options['endblock'] ?? 99999999,
                'page'       => $options['page'] ?? 1,
                'offset'     => 20,
                'sort'       => 'asc',
            ]
        ];
    }

    /**
    * Transform parameters for API call
    *
    * @param string $walletAddress
    * @param array  $config API config data
    * 
    * @return array;
    */
    static function transformForWalletInfo(string $walletAddress, array $config): array
    {
        return [
            'url' => $config['baseUrl'],
            'params' => [
                'module'  => 'account',
                'action'  => 'balance',
                'address' => $walletAddress,
            ]
        ];
    }

    /**
    * Transform parameters for API call
    *
    * @param array $options API Params
    * @param array $config  API config data
    * 
    * @return array;
    */
    static function transformForBalance(array $options, array $config): array
    {
        return [
            'url' => $config['balanceApi'],
            'params' => [
                'smartchain'    => $options['smartchain'],
                'walletAddress' => $options['walletAddress'],
                'date'          => $options['date'],
            ]
        ];
    }

    /**
    * Transform API response
    *
    * @param array $response  Transaction API response
    * @param array $config    API config data
    * 
    * @return array;
    */
    static function transformTransactionsResponse(array $response, array $config): array
    {
        foreach ($response['result'] as $key => $transaction) {
            $response['result'][$key]['value'] = 
                self::convertToMATIC($transaction['value']) . ' ' . $config['currency'];

            $response['result'][$key]['txFees'] = 
                self::convertToMATIC($transaction['gasPrice'] * $transaction['gasUsed'])
                . ' ' . $config['currency'];
        }

        return $response;
    }

    /**
    * Transform API response
    *
    * @param array $response  Wallet info API response
    * @param array $config  API config data
    * 
    * @return array;
    */
    static function transformWalletResponse(array $response, array $config): array
    {
        $response['result'] = self::convertToMATIC($response['result'])
                                . ' ' . $config['currency'];

        return $response;
    }

    /**
    * Convert string to MATIC
    *
    * @param string $value  MATIC token value
    * 
    * @return string;
    */
    static function convertToMATIC(string $value): string
    {
        $decimalPlaces = 18;

        if (strlen($value) <= $decimalPlaces) {
            $value = '0.' . str_repeat('0', $decimalPlaces - strlen($value)) . $value;
        } else {
            $integer = substr($value, 0, -$decimalPlaces);
            $value = $integer . '.' . substr($value, strlen($integer));
        }

        if (strpos($value, '.') !== false) {
            // Remove trailing 0's and decimal
            $value = rtrim(rtrim($value, '0'), '.');
        }

        return $value;
    }
}