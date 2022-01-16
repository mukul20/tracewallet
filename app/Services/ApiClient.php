<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Cache;

class ApiClient
{
	
	private $config;			// API config data
	private $cacheTime = 900;	// 15 minutes TTL

	/**
     * Constructor.
     * 
     * @param ApiCacheService $apiCacheService
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
    * Generate cache key
    *
    * @param  string $url 	 API URL
    * @param  array  $params API Params
    * 
    * @return string
    */
	public function generateCacheKey(string $url, array $params): string
	{
		return md5($url . implode('_', $params));
	}

	/**
    * Call request. Handles API response caching as well.
    *
    * @param  string $url 	 API URL
    * @param  array  $params API Params
    * @param  bool 	 $cache  Enable/Disable cache functionality
    * 
    * @return array|mixed;
    */
	public function callRequest(string $url, array $params, bool $cache = true): mixed
	{
		$cacheKey = $this->generateCacheKey($url, $params);

		// Check if response is available in cache
		if ($cache && Cache::has($cacheKey)) {
			return Cache::get($cacheKey);
		}

		$params['apikey'] = $this->config['apiKey'];

		// If response is not available in cache, hit the API
		$response = Http::get($url, $params);

		if ($cache && $response->ok()) {
			// Cache API reponse
			Cache::put($cacheKey, $response->json(), $this->cacheTime);
		}

		return $response->json();
	}
}