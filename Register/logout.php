<?php
session_start();
session_unset();
session_destroy();
header('Location: /2026_2027/tle_t7/Register/login.php');
exit;

