<?php

define('CLOUDFLARE_EMAIL', '[your_email]');
define('TURNSTILE_SITE_KEY', '[turnstile_site_key]');
define('TURNSTILE_SECRET', '[turnstile_secret]');

function verify_turnstile_token($token)
{
    $url = "https://challenges.cloudflare.com/turnstile/v0/siteverify";
    $headers = array(
        'Content-Type: application/json',
        'X-Auth-Email: CLOUDFLARE_EMAIL',
        'X-Auth-Key: TURNSTILE_SECRET'
    );
    $data = array(
        'token' => $token,
        'sitekey' => TURNSTILE_SITE_KEY,
        'secret' => TURNSTILE_SECRET,
        'response' => $token
    );
    $options = array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => $headers
    );
    $ch = curl_init($url);
    curl_setopt_array($ch, $options);
    $response = curl_exec($ch);
    $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($statusCode !== 200) {
        throw new Exception("Failed to verify Turnstile token. Status code: $statusCode");
    }

    $responseData = json_decode($response, true);

    if (!$responseData['success']) {
        throw new Exception("Turnstile token verification failed. Error: " . $responseData['error-codes'][0]);
    }

    return $responseData;
}

function end_session()
{
    if (isset($_SESSION)) {
        session_unset();
        session_destroy();
    }
}

function stay_home()
{
    header('Location: index.php');
    exit;
}

function go_to_page()
{
    header('Location: page.php');
    exit;
}
