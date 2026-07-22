<?php

namespace App\Services;

use GuzzleHttp\Client;

class BaseApiService
{
    protected Client $client;

    public function __construct()
    {
        $this->client = new Client([
            "base_uri"      => "http://localhost:8080/",
            "timeout"       => 10
        ]);
    }

    public function getTotalItemsInCart()
    {
        return $this->handleRequest(function() {
            return $this->client->get("cart/total", [
                "headers"   => $this->getHeaders()
            ]);
        });
    }

    protected function getHeaders()
    {
        return [
            "Authorization" => "Bearer " . session("jwt_token"),
            "Accept"        => "application/json"
        ];
    }

    protected function handleRequest(callable $callback)
    {
        try {
            $response = $callback();

            return [
                "success"       => true,
                "data"          => json_decode($response->getBody(), true)
            ];
        } catch(\GuzzleHttp\Exception\ClientException $e) {
            $status = $e->getResponse()->getStatusCode();
            if($status == 409) {
                return [
                    "success"   => false,
                    "message"   => "Payment is already processed"
                ];
            }
            
            if($status != 401) {
                return [
                    "success"   => false,
                    "message"   => $e->getMessage()
                ];
            } 

            $isRefreshed = $this->refreshJWTToken();
            if(!$isRefreshed) {
                return [
                    "success"       => false,
                    "message"       => "Unable to refresh the token"
                ];
            }

            try {
                $response = $callback();

                return [
                    "success"       => true,
                    "data"          => json_decode($response->getBody(), true)
                ];
            } catch(\Throwable $e) {
                return [
                    "success"   => false,
                    "message"   => $e->getMessage()
                ];
            }
        } catch(\Throwable $e) {
            return [
                "success"   => false,
                "message"   => $e->getMessage()
            ];
        }
    }

    private function refreshJWTToken()
    {
        try {
            $response = $this->client->post("refresh", [
                "json"      => [
                    "refresh_token"     => session("refresh_token")
                ]
            ]);

            $body = json_decode($response->getBody(), true);
            session()->set("jwt_token", $body["jwt_token"]);
            
            return true;
        } catch(\Throwable $e) {
            return false;
        }
    }
}
