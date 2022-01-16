<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WalletApiTest extends TestCase
{
    private $testWalletAddress = '0xd374893F994F81E0AA555b21CF703fF6d8b51B03';

    /**
     * Test for getting wallet info for all smartchains.
     *
     * @return void
     */
    public function test_can_get_wallet_info()
    {
        // Get all smartchains from smartchain config
        $smartchains = array_keys(config('smartchain'));

        // Test for all smartchains
        foreach ($smartchains as $smartchain) {
            $this->checkWalletInfoForSmartchain($smartchain);
        }
    }

    /**
     * Test for checking wallet info for a specific smartchain.
     * 
     * @param string $smartchain
     *
     * @return void
     */
    public function checkWalletInfoForSmartchain(string $smartchain)
    {
        $params = [
            'walletAddress' => $this->testWalletAddress,
            'smartchain'    => $smartchain
        ];

        $response = $this->getJson(route('wallet.show', $params));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'message',
            'result'
        ]);
    }

    /**
     * Test for getting hostorical balance for all smartchains.
     *
     * @return void
     */
    public function test_can_get_historical_balance()
    {
        // Get all smartchains from smartchain config
        $smartchains = array_keys(config('smartchain'));

        // Test for all smartchains
        foreach ($smartchains as $smartchain) {
            $this->checkWalletBalanceForSmartchain($smartchain);
        }
    }

    /**
     * Test for checking historical balance for a specific smartchain.
     * 
     * @param string $smartchain
     *
     * @return void
     */
    public function checkWalletBalanceForSmartchain(string $smartchain)
    {
        $params = [
            'walletAddress' => $this->testWalletAddress,
            'smartchain'    => $smartchain,
            'date'          => '2022-01-13'
        ];

        $response = $this->getJson(route('wallet.balance', $params));

        $response->assertStatus(200);
        $response->assertJsonStructure(['balance']);
    }

    /**
     * Test for get transactions request validations.
     *
     * @return void
     */
    public function test_for_transaction_request_validation()
    {
        // Test with a missing param
        $params = [
            'walletAddress' => $this->testWalletAddress
        ];
        $response = $this->getJson(route('wallet.show', $params));
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message',
            'errors' => ['smartchain']
        ]);

        // Test with wrong smartchain and missing date param
        $params = [
            'walletAddress' => $this->testWalletAddress,
            'smartchain'    => 'smart'
        ];
        $response = $this->getJson(route('wallet.balance', $params));
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message',
            'errors' => ['smartchain', 'date']
        ]);
    }
}
