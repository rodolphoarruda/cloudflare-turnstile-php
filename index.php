<?php
session_start();
require 'functions.php';

$_SESSION['name'] = 'Hello, Joe';

$warning = '';

// On form submit get the response from Turnstile API (a token) and use it along with the secret key
// and the site key to verify the token. If it clears, then the user is not a robot and is taken to 
// the destination page.
if (isset($_POST['submit'])) {

    $turnstileStatus = verify_turnstile_token($_POST['cf-turnstile-response']);

    if ($turnstileStatus == true) {
        $_SESSION['lastname'] = $_POST['lastname'];
        go_to_page();
    } else {
        stay_home();
        $warning = 'Something went wrong!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    <title>Turnstile</title>
</head>

<body>
    <h1><?php echo $_SESSION['name']; ?>!</h1>
    <p><?php echo $warning; ?></p>
    <form action="" method="post">
        <label for="lastname">Your last name</label>
        <input type="text" name="lastname">
        <button type="submit" name="submit" value="submit">Submit</button>

        <!-- Turnstile widget -->
        <div class="cf-turnstile" data-sitekey="<?php echo TURNSTILE_SITE_KEY; ?>"></div>

    </form>

    <h3>Session data:</h3>
    <pre><?php print_r($_SESSION); ?></pre>
    <h3>POST data:</h3>
    <pre><?php print_r($_POST); ?></pre>

</body>

</html>