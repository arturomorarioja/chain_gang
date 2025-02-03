<?php

function isBlank(string $value): bool
{
    return !isset($value) || trim($value) === '';
}

function isValidEmail(string $email): bool
{
    $emailRegex = '/\A[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}\Z/i';
    return preg_match($emailRegex, $email);
}