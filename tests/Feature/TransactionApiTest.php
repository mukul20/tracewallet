<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionApiTest extends TestCase
{
    private $testWalletAddress = '0xd374893F994F81E0AA555b21CF703fF6d8b51B03';
    private $transactionStructure = [
        'blockNumber',
        'hash',
        'nonce',
        'blockHash',
        'from',
        'to',
        'value'
    ];

    /**
     * Test for get transactions for all smartchains.
     *
     * @return void
     */
    public function test_can_get_transactions()
    {
        // Get all smartchains from smartchain config
        $smartchains = array_keys(config('smartchain'));

        // Test for all smartchains
        foreach ($smartchains as $smartchain) {
            $this->checkTransactionsForSmartchain($smartchain);
        }
    }

    /**
     * Test for get transactions for a specific smartchain.
     * 
     * @param string $smartchain
     *
     * @return void
     */
    public function checkTransactionsForSmartchain(string $smartchain)
    {
        $params = [
            'walletAddress' => $this->testWalletAddress,
            'smartchain'    => $smartchain,
            'startblock'    => 0,
        ];

        $response = $this->getJson(route('transactions.index', $params));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'message',
            'result' => ['*' => $this->transactionStructure]
        ]);
    }

    /**
     * Test for get transactions request validations.
     *
     * @return void
     */
    public function test_for_transaction_request_validation()
    {
        // Test with no params
        $response = $this->getJson(route('transactions.index', []));
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message',
            'errors' => ['walletAddress', 'smartchain']
        ]);

        // Test with a missing param
        $params = [
            'walletAddress' => $this->testWalletAddress
        ];
        $response = $this->getJson(route('transactions.index', $params));
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message',
            'errors' => ['smartchain']
        ]);

        // Test with wrong wallet address param
        $params = [
            'walletAddress' => 'abcd',
            'smartchain'    => 'smart'
        ];
        $response = $this->getJson(route('transactions.index', $params));
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message',
            'errors' => ['walletAddress', 'smartchain']
        ]);
    }
}
