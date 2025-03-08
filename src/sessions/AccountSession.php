<?php
class AccountSession extends SessionRegistry {

    public function __construct() {
        parent::__construct();
        $this->keys = [
            'profile' => 'profile'
        ];
    }

    public function setProfile(array $data): void {
        $this->set($this->keys['profile'], $data);
    }
    
    public function getProfile(): ?array {
        return $this->get($this->keys['profile']);
    }
}