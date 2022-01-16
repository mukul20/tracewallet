<?php

namespace App\Http\Controllers\API\v1;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Services\SmartChainService;

class TransactionController extends Controller
{
    // Smartchain service dependency variable
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
     * Get transactions of a wallet address.
     * 
     * @param TransactionRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TransactionRequest $request): Response
    {
        $transactions = $this->smartChainService->getTransactions(
            $request->validated()
        );

        return response($transactions);
    }
}
