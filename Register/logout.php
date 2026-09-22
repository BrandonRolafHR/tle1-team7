<?php
session_start();
session_unset();
session_destroy();
header('Location: /tle1-team7/Register/login.php');
exit;
//