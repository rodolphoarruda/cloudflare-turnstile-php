<?php
session_start();

require 'functions.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="simple.css">
    <title>Turnstile</title>
</head>

<body>
    <h1>
        <?php echo $_SESSION['name'] . ' ' . $_SESSION['lastname']; ?>!
    </h1>

    <?php if (isset($warning)): ?>
        <p style="color: red;"><?php echo $warning; ?></p>
    <?php endif; ?>

    <h3>Session data:</h3>
    <pre><?php print_r($_SESSION); ?></pre>

    <h3>POST data:</h3>
    <pre><?php print_r($_POST); ?></pre>
    <p><a href="clear_session.php">go back</a></p>
</body>

</html>