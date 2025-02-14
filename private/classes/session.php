<?php

class Session
{
    public const MAX_LOGIN_TIME = 60 * 60 * 24;

    private ?int $adminID;
    public string $username;
    private ?int $lastLogin;

    public function __construct()
    {
        session_start();
        if (isset($_SESSION['admin_id'])) {
            $this->adminID = $_SESSION['admin_id'] ?? null;
            $this->username = $_SESSION['username'] ?? '';
            $this->lastLogin = $_SESSION['last_login'] ?? null;
        }
    }

    /**
     * Logs an admin in
     * @param $admin The Admin object corresponding to the admin to log in
     * @return true if the login was successful, 
     *         false if the received Admin object is not set
     */
    public function login(Admin $admin): bool
    {
        if (!$admin) {
            return false;
        }

        // Prevention against session fixation attacks
        session_regenerate_id();

        $_SESSION['admin_id'] = $admin->id;
        $this->adminID = $admin->id;
        $this->username = $_SESSION['username'] = $admin->username;
        $this->lastLogin = $_SESSION['last_login'] = time();

        return true;
    }

    public function isLoggedIn(): bool
    {
        return isset($this->adminID) && $this->lastLoginIsRecent();
    }

    public function lastLoginIsRecent(): bool
    {
        if (!isset($this->lastLogin)) {
            return false;
        } elseif ($this->lastLogin + self::MAX_LOGIN_TIME < time()) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * It handles the session message
     * @param $message The new session message (optional)
     * @return<string> The existing session message if no one is received,
     *         or true if a message is received, 
     *         in which case it becomes the new session message
     */
    public function message(string $message = ''): string|true
    {
        if (empty($message)) {
            return $_SESSION['message'] ?? '';
        } else {
            $_SESSION['message'] = $message;
            return true;
        }
    }

    public function clearMessage(): void
    {
        unset($_SESSION['message']);
    }

    public function logout(): void
    {
        unset($_SESSION['admin_id']);
        unset($_SESSION['username']);
        unset($_SESSION['last_login']);
        unset($this->adminID);        
    }
}