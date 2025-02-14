<?php

function requireLogin(): void
{
    global $session;
    if (!$session->isLoggedIn()) {
        header('Location: ' . urlFor('/staff/login.php'));
    }    
}

function displayErrors(array $errors=[]): string
{
    $output = '';
    if (!empty($errors)) {
        $output =<<<'ERROR'
            <section class="error">
                <p>Please fix the following errors:</p>
                <ul>
        ERROR;
        foreach ($errors as $error) {
            $error = h($error);
            $output .= "<li>$error</li>";
        }
        $output .=<<<'ERROR'
                </ul>
            </section>
        ERROR;
    }
    return $output;
}

function displaySessionMessage(): string
{
    global $session;
    $message = h($session->message());
    if (!empty($message)) {
        $session->clearMessage();
        return "<p class=\"message\">$message</p>";
    }
    return '';
}