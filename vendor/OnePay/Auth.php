<?php

namespace OnePay;

/**
 * Authentication type
 *
 * @category Class
 */
class Auth
{
    /**
     * Configuration
     *
     * @var Configuration
     */
    protected $accessCredential = [];

    /**
     * Sets instance Auth
     *
     * @return Auth
     */
    public static function BasicAuth()
    {
        return new Auth();
    }

    /**
     * Sets the access token for OAuth
     *
     * @param string $accessToken Token for OAuth
     *
     * @return Configuration
     */
    public function setToken($prefix = 'Authorization', $token = null)
    {
        if ($prefix != null || $token != null) {
            $this->accessCredential[$prefix] = 'Bearer ' . $token;
        }

        return $this;
    }

    /**
     * Gets the access token for OAuth
     *
     * @return string Access token for OAuth
     */
    public function getToken($key = null)
    {
        if (isset($key)) {
            return $this->accessCredential[$key];
        }

        return $this->accessCredential;
    }
}
