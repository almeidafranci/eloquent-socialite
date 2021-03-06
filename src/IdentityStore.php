<?php

namespace AlmeidaFranci\EloquentSocialite;

interface IdentityStore
{
    public function getByProvider($provider, $providerUser);
    public function flush($user, $provider);
    public function store($identity);
    public function userExists($provider, $providerUser);
}
