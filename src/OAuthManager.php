<?php

namespace AlmeidaFranci\EloquentSocialite;

use Laravel\Socialite\Facades\Socialite;

class OAuthManager
{
    protected $redirect;
    protected $authenticator;

    public function __construct($redirect, $authenticator)
    {
        $this->redirect = $redirect;
        $this->authenticator = $authenticator;
    }

    public function authorize($providerAlias)
    {
        return Socialite::with($providerAlias)->redirect();
    }

    public function login($providerAlias, $callback = null)
    {
        $details = Socialite::with($providerAlias)->user();
        return $this->authenticator->login($providerAlias, $details, $callback, $remember = false);
    }

    public function loginForever($providerAlias, $callback = null)
    {
        $details = Socialite::with($providerAlias)->user();
        return $this->authenticator->login($providerAlias, $details, $callback, $remember = true);
    }
}
