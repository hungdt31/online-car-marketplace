<?php

class GitHubClient {
    private $client_id;
    private $client_secret;
    private $redirect_uri;
    private $state;

    public function __construct() {
        $this->client_id = getenv('GITHUB_CLIENT_ID');
        $this->client_secret = getenv('GITHUB_CLIENT_SECRET');
        $this->redirect_uri = _WEB_ROOT . '/auth/github-redirect';
        $this->state = bin2hex(random_bytes(16));
    }

    public function getLoginUrl() {
        $params = [
            'client_id' => $this->client_id,
            'redirect_uri' => $this->redirect_uri,
            'scope' => 'user:email',
            'state' => $this->state
        ];
        
        return 'https://github.com/login/oauth/authorize?' . http_build_query($params);
    }

    public function getAccessToken($code) {
        $params = [
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'code' => $code,
            'redirect_uri' => $this->redirect_uri
        ];

        $ch = curl_init('https://github.com/login/oauth/access_token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json']);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

    public function getUserInfo($access_token) {
        $ch = curl_init('https://api.github.com/user');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $access_token,
            'User-Agent: PHP-App'
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

    public function getUserEmail($access_token) {
        $ch = curl_init('https://api.github.com/user/emails');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $access_token,
            'User-Agent: PHP-App'
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        $emails = json_decode($response, true);
        foreach ($emails as $email) {
            if ($email['primary']) {
                return $email['email'];
            }
        }
        return null;
    }
} 