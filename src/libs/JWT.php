<?php

use BcMath\Number;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtAuth {
    private $key;
    private $algo;
    private $token_from_cookie;
    public function __construct() {
        $this->key = getenv('KEY_JWT');
        $this->algo = 'HS256';
        $this->setCookieToToken();
    }
    public function decodeTokenFromCookie($name_token) {
        $token = $this->token_from_cookie[$name_token];
        if (in_array(null, $token)) {
            return [
                'success' => false,
                'message' => 'Token is not found'
            ];
        };
        try {
            $decoded = JWT::decode($token['value'], new Key($this->key, $this->algo));
            return [
                'success' => true,
                'message' => 'Token is valid',
                'payload' => (array) $decoded
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Token is invalid. Please login again.'
            ];
        }
    }
    public function encodeDataToCookie($payload) {
        $jwt = JWT::encode($payload, $this->key, $this->algo);
        foreach ($this->token_from_cookie as $name_token => $token) {
            $expire = time() + $token['expire'];
            setcookie($name_token.'_token', $jwt, $expire, '/', '', false, true);
        }
    }
    public function getTokenFromCookie() {
        $this->setCookieToToken();
        return $this->token_from_cookie;
    }
    public function setCookieToToken() {
        $this->token_from_cookie = [
            'access' => [
                'expire' => intval(getenv('ACCESS_TOKEN_EXPIRE')),
                'value' => isset($_COOKIE['access_token']) ? $_COOKIE['access_token'] : null
            ],
            'refresh' => [
                'expire' => intval(getenv('REFRESH_TOKEN_EXPIRE')),
                'value' => isset($_COOKIE['refresh_token']) ? $_COOKIE['refresh_token'] : null
            ]
        ];
    }
    public function deleteTokenFromCookie() {
        foreach ($this->token_from_cookie as $name_token => $token) {
            setcookie($name_token.'_token', '', time() - $token['expire'], '/', '', false, true);
        }
    }
    public function generateAccessFromRefresh() {
        $refresh_token = $this->getTokenFromCookie()['refresh']['value'];
        if (isset($refresh_token)) {
            $response = $this->decodeTokenFromCookie('refresh');
            if ($response['success']) {
                $payload = (array) $response['payload'];
                $this->encodeDataToCookie($payload);
                return [
                    'success' => true,
                    'message' => 'Access token is generated.',
                    'payload' => $payload
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Refresh token is invalid.',
                ];
            }
        } else {
            return [
                'success' => false,
                'message' => 'Refresh token is not found.'
            ];
        }
    }
}