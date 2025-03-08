<?php
class SessionFactory {
    public static function createSession(string $type) {
        return match ($type) {
            'account' => new AccountSession(),
            default => throw new InvalidArgumentException("Unknown session type: $type"),
        };
    }
}