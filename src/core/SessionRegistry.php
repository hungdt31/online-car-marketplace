<?php
class SessionRegistry {
    public $keys = [];
    
    protected function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        error_log('SessionRegistry constructed. Session ID: ' . session_id());
    }

    public function set(string $key, mixed $value): void {
        $_SESSION[$key] = $value;
        error_log("Session set: {$key} = " . json_encode($value));
    }

    public function get(string $key, mixed $default = null): mixed {
        $value = $_SESSION[$key] ?? $default;
        error_log("Session get: {$key} = " . json_encode($value));
        return $value;
    }

    public function remove(string $key): void {
        unset($_SESSION[$key]);
        error_log("Session remove: {$key}");
    }

    public function destroy(): void {
        $helper = array_keys($_SESSION);
        foreach ($helper as $key){
            unset($_SESSION[$key]);
        }
        error_log("Session destroyed");
    }
    
    // Debug method to print session contents
    public function dumpSession(): void {
        error_log("SESSION DUMP: " . json_encode($_SESSION));
    }
}