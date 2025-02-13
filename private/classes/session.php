<?php

class Session
{
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
        return isset($this->adminID);
    }

    public function logout(): void
    {
        unset($_SESSION['admin_id']);
        unset($_SESSION['username']);
        unset($_SESSION['last_login']);
        unset($this->adminID);        
    }
}