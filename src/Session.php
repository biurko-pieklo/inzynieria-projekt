<?php

declare(strict_types=1);

class Session {
    /**
     * Check if user is logged to session
     */
    public static function isLogged(): bool {
        if (isset($_SESSION['logged'])) {
            return $_SESSION['logged'];
        } else {
            return false;
        }
    }
}
