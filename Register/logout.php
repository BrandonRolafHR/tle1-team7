<?php
session_start();
session_unset();
session_destroy();
header('Location: Register/login.php');
exit;

