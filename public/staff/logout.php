<?php

require_once '../../private/initialize.php';

$session->logout();

header('Location: ' . urlFor('/staff/login.php'));