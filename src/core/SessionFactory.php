<?php
class SessionFactory {
    public static function createSession(string $type) {
        error_log('Creating session of type: ' . $type);
        try {
            $session = match ($type) {
                'account' => new AccountSession(),
                'blog' => new BlogSession(),
                'shop' => new ShopSession(),
                default => throw new InvalidArgumentException("Unknown session type: $type"),
            };
            error_log('Session created successfully: ' . $type);
            return $session;
        } catch (Exception $e) {
            error_log('Error creating session: ' . $e->getMessage());
            throw $e;
        }
    }
}