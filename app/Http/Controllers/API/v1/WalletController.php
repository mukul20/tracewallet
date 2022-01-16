<?php

namespace App\Http\Controllers\API\v1;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\WalletRequest;
use App\Services\SmartChainService;

class WalletController extends Controller
{
    // Smart chain service dependency variable
    private $smartChainService;

    /**
     * Constructor for dependency injection.
     * 
     * @param SmartChainService $smartChainService
     */
    public function __construct(SmartChainService $smartChainService)
    {
        $this->smartChainService = $smartChainService;
    }

    /**
     * Get details of a wallet.
     * 
     * @param string $walletAddress  Hexadecimal address of wallet
     * @param WalletRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function show(string $walletAddress, WalletRequest $request): Response
    {
        $walletInfo = $this->smartChainService->getWalletInfo($walletAddress);

        return response($walletInfo);
    }

    /**
     * Get wallet balance at specific time.
     * 
     * @param string $walletAddress  Hexadecimal address of wallet
     * @param WalletRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function getHistoricalBalance(string $walletAddress, WalletRequest $request): Response
    {
        $balance = $this->smartChainService->getHistoricalBalance(
            $request->validated()
        );

        return response($balance);
    }
}
