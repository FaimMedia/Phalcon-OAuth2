<?php
if (preg_match('/\.(?:png|jpg|jpeg|gif)$/', $_SERVER["REQUEST_URI"])) {
    return false;    // serve the requested resource as-is.
}

$requestUri = $_SERVER['REQUEST_URI'];

$_GET['_url'] = $requestUri;

include "public/index.php";