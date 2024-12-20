<?php

namespace App\CallRailService;

use App\Exceptions\CallRailException;
use Illuminate\Support\Facades\Http;

class CallRail
{
    protected string $api_url;
    protected string $version;
    protected string $accountID;
    protected string $headerAuthToken;
    protected $http;
    private $paramsArr = [];
    private $route;

    /**
     * Create a new class instance.
     */
    public function __construct()
    {

        $this->api_url = config('callrail.api_url');
        $this->accountID = config('callrail.account_id');
        $this->version = config('callrail.version');
        $this->headerAuthToken = "Token token=".config('callrail.token');

        $this->http = Http::withHeaders([
            'Authorization' => "$this->headerAuthToken"
        ]);
    }

    public function url($path = '')
    {
        $root = rtrim($this->api_url, '/') . '/'. $this->version . '/a/'. $this->accountID .'/';
        return $root. ltrim($path, '/');
    }

    public function routeUrl()
    {
        if(!$this->route) {
            throw new CallRailException("Route is not defined. please add function ->calls()|->users()|->company()");
        }
        return $this->route;
    }

    public function calls()
    {
        $this->route = $this->url('/calls.json');
        return $this;
    }

    public function users()
    {
        $this->route = $this->url('/users.json');
        return $this;
    }

    public function company()
    {
        $this->route = $this->url('/companies.json');
        return $this;
    }

    public function where(array $params = [])
    {
        $this->paramsArr = $params;
        return $this;
    }

    public function get()
    {
        $this->routeUrl();

        $response = $this->http->get(
            $this->route,
            $this->paramsArr
        );

        if ($response->successful()) {
            return $response->json();
        } elseif ($response->failed()) {
            return $response->body();
        }
    }

    public function paginate($perPage, $offset = 0)
    {
        $this->routeUrl();

        $params = [...$this->paramsArr, ...[
            'relative_pagination' => 'true',
            'per_page' => $perPage,
            'offset' => $offset
        ]];

        $response = $this->http->get(
            $this->route,
            $params
        );

        if ($response->successful()) {
            return $response->json();
        } elseif ($response->failed()) {
            return $response->body();
        }
    }
}
