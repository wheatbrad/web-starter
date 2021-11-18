<?php declare(strict_types=1);

namespace App\Auth;

class SessionManager
{
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            $this->initiateSession();
        }

        if (isset($_SESSION['destroyed_at'])) {
            if ($_SESSION['destroyed_at'] < time() - 300) {
                // TODO: Remove ALL auth status from session`
            }

            if (isset($_SESSION['new_session_id'])) {
                // Might be a lost cookie due to unreliable connection
                session_write_close();
                session_id($_SESSION['new_session_id']);
                $this->initiateSession();
            }
        }
    }

    /**
     * Retrieves a value from the current session.
     */
    public function get(string $key): mixed
    {
        return $_SESSION[$key] ?? false;
    }

    /**
     * Sets a value on the current session.
     */
    public function set(string $key, mixed $value) {
        $_SESSION[$key] = $value;
    }

    /**
     * Removes a value from the current session.
     */
    public function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public function regenerateID(): void
    {
        $newSessionID = session_create_id();
        $_SESSION['new_session_id'] = $newSessionID;
        $_SESSION['destroyed_at'] = time();        
        session_write_close();

        // Start new session with new session ID
        session_id($newSessionID);
        ini_set('session.use_strict_mode', '0');
        $this->initiateSession();
        ini_set('session.use_strict_mode', '1');
        
        unset($_SESSION['destroyed_at']);
        unset($_SESSION['new_session_id']);
    }

    /**
     * Removes session data and destroys the current session.
     */
    public function destroy(): void
    {
        if (session_id() !== '') {
            if (ini_get('session.use_cookies')) {
                $params = session_get_cookie_params();
                setcookie(
                    session_name(),
                    '',
                    [
                        'expires' => time() - 86400,
                        'path' => $params['path'],
                        'domain' => $params['domain'],
                        'secure' => $params['secure'],
                        'httponly' => $params['httponly'],
                        'samesite' => $params['samesite']
                    ]
                );
            }

            session_unset();
            session_destroy();
        }
    }

    private function initiateSession(): void
    {
        /**
         * TODO: pass array in from config
         *       possibly include session_cache_limiter
         *       and session_cache_expire
         */
        session_start([
            'name' => 'fbpc_sess',
            'save_handler' => 'files',
            // 'cookie_lifetime' => 0,
            'cookie_path' => '/',
            'cookie_domain' => $_SERVER['SERVER_NAME'],
            'cookie_secure' => false,
            'cookie_httponly' => true,
            'cookie_samesite' => 'lax',
            'sid_length' => 128,
            'sid_bits_per_character' => 5
        ]);
    }
}