<?php

/**
 * It checks whether a string is empty
 * @param $text The string to check
 * @return true if it is empty, false otherwise
 */
function isBlank(string $text): bool
{
    return !isset($text) || trim($text) === '';
}

/**
 * It checks whether an email address is valid
 * @param @email The email address to check
 * @return true if it is a valid email, false otherwise
 */
function isValidEmail(string $email): bool
{
    $emailRegex = '/\A[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}\Z/i';
    return preg_match($emailRegex, $email);
}

/**
 * It checks the length of a string
 * @param $text The string whose length to check
 * @param $min The minimum length the string should have
 * @param $max The maximum length the string should have
 * @return true if the string's length is between min and max,
 *         false otherwise
 */
function lengthBetween(string $text, int $min, int $max): bool
{
    if (strlen($text) < $min) {
        return false;
    }
    if (strlen($text) > $max) {
        return false;
    }
    return true;
}