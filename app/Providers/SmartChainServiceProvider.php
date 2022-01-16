<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use App\Services\SmartChainService;
use App\Services\EtherscanService\EtherscanService;
use App\Services\BscscanService\BscscanService;
use App\Services\PolygonscanService\PolygonscanService;
use App\Exceptions\SmartChainServiceNotFound;
use Request;

class SmartChainServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register Smartchain services.
     *
     * @return void
     */
    public function register()
    {
        $smartchain = Request::get('smartchain');

        // Get instance of smart chain class based on source param
        $this->app->singleton(SmartChainService::class, function ($app) use ($smartchain) {
            switch ($smartchain) {
                case 'bscscan':
                    return new BscscanService();

                case 'polygonscan':
                    return new PolygonscanService();

                default:
                    // Let's keep Etherscan service as default
                    return new EtherscanService();
            }
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            SmartChainService::class,
        ];
    }
}
