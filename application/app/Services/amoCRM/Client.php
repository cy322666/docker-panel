<?php

namespace App\Services\amoCRM;

use App\Models\Access;
use Ufee\Amo\Oauthapi;

class Client
{
    public Access $storage;
    public Oauthapi $service;

    public function init($model): Client
    {
        $this->storage = $model;

        \Ufee\Amo\Oauthapi::setOauthStorage(
            new EloquentStorage([], $model)
        );

        $this->service = Oauthapi::setInstance([
            'domain'        => $this->storage->subdomain,
            'client_id'     => $this->storage->client_id,
            'client_secret' => $this->storage->client_secret,
            'redirect_uri'  => $this->storage->redirect_uri,
        ]);

        try {
            $this->service->account;

        } catch (\Exception $exception) {

            if ($this->storage->refresh_token) {

                $oauth = $this->service->refreshAccessToken($this->storage->refresh_token);

            } else {
                $oauth = $this->service->fetchAccessToken($this->storage->code);

                $this->storage->setOauth($this->storage->client_id, [
                    'token_type'    => $oauth['token_type'],
                    'expires_in'    => $oauth['expires_in'],
                    'access_token'  => $oauth['access_token'],
                    'refresh_token' => $oauth['refresh_token'],
                    'created_at'    => $oauth['created_at'] ?? time(),
                ]);
            }
        }
        return $this;
    }
}
