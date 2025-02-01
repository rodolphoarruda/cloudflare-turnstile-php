<?php
session_start();
$_SESSION['lastname'] = $_POST['lastname'];
require 'functions.php';
validate_csrf_token();
