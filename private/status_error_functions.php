<?php

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
            $output .= "<li>{h($error)}</li>";
        }
        $output .=<<<'ERROR'
                </ul>
            </section>
        ERROR;
    }
    return $output;
}

function getAndClearSessionMessage(): string
{
    $sessionMsg = trim($_SESSION['message'] ?? '');
    if ($sessionMsg !== '') {
        unset($_SESSION['message']);
    }
    return $sessionMsg;
}

function displaySessionMessage()
{
    $message = getAndClearSessionMessage();
    return "<p id=\"message\">{h($message)}</p>";
}