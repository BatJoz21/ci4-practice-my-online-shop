<?php

namespace App\Services;

class AuthApiService extends BaseApiService {
    public function signup(array $data)
    {
        $response = $this->client->post("register", [
            "json"          => $data
        ]);

        return json_decode($response->getBody(), true);
    }

    public function login(string $email, string $password)
    {
        $response = $this->client->post("login", [
            "json"          => [
                "email"     => $email,
                "password"  => $password
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    public function logout(string $refreshToken)
    {
        $response = $this->client->post("logout", [
            "json"          => [
                "refresh_token"     => $refreshToken
            ]
        ]);

        return json_decode($response->getBody(), true);
    }
}
