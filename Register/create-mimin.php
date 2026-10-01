<?php
session_start();
require_once '../included/connection.php';

if (!isset($_SESSION['loggedInUser'])) {
    header('Location: /Register/login.php');
    exit;
}

?>



<?php require_once "../components/avatar-creator.php"; ?>