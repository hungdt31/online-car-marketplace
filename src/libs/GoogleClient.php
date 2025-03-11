<?php
use Google\Client;
class GoogleClient {
    private $client;
    public function __construct() {
        $this->client = new Client();
        $this->client->setClientId(getenv("GOOGLE_CLIENT_ID"));
        $this->client->setClientSecret(getenv("GOOGLE_SECRET_ID"));
        $this->client->setRedirectUri(_WEB_ROOT."/auth/google-redirect");
    }
    public function addScope($scope = []) {
        foreach ($scope as $s) {
            $this->client->addScope($s);
        }
    }
    public function getClient () {
        return $this->client;
    }
}