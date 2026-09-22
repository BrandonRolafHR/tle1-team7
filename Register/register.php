<?php
session_start();
require_once '../included/connection.php';

$errors = [];

if (isset($_POST['register'])) {
    $email = trim($_POST['email'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $birthdate = trim($_POST['birthdate'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm = trim($_POST['confirm_password'] ?? '');

    //validation of form
    if ($email === '') {
        $errors['email'] = 'E-mail is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid e-mail address';
    }
    if ($username === '') $errors['username'] = 'Username is required';
    if ($birthdate === '') {
        $errors['birthdate'] = 'Birthdate is required';
    } else {
        $birthDateObj = DateTime::createFromFormat('Y-m-d', $birthdate);
        $today = new DateTime();

        if (!$birthDateObj || $birthDateObj->format('Y-m-d') !== $birthdate) {
            // catches malformed input like "2025-13-45"
            $errors['birthdate'] = 'Please enter a valid date';
        } elseif ($birthDateObj > $today) {
            // catches future dates
            $errors['birthdate'] = 'Birthdate cannot be in the future';
        } else {
            $age = $today->diff($birthDateObj)->y;
            if ($age < 16) { // pick whatever minimum age you need
                $errors['birthdate'] = 'You must be at least 13 years old to register';
            }
        }
    }
    if ($password === '') $errors['password'] = 'Password is required';
    if ($password !== $confirm) $errors['confirm_password'] = 'Passwords do not match';

    //check if username already exists
    if (empty($errors)) {
        $stmt = mysqli_prepare($db, "SELECT id FROM users WHERE username = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    }

    //if all is good, insert user
    if (empty($errors)) {
        $defaultAvatarId = 1; // the id of your default/placeholder avatar row
        $defaultBio = "Hey, I'm $username! I haven't written a bio yet.";
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = mysqli_prepare($db, "INSERT INTO users (username, email, password, birthdate, bio, avatar_id) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sssssi", $username, $email, $passwordHash, $birthdate, $defaultBio, $defaultAvatarId);
        mysqli_stmt_execute($stmt);
        $_SESSION['user_id'] = mysqli_stmt_insert_id($stmt);
        $_SESSION['username'] = $username;
        header('Location: list.php');
        exit;
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
          name="viewport">
    <meta content="ie=edge" http-equiv="X-UA-Compatible">
    <title></title>
    <link rel="icon" type="image/x-icon" href="/images/favicon.gif">
    <link rel="stylesheet" href="../css/style.css">
</head>
<main>
    <h2>Create an Account</h2>

    <form method="post">
        <div>
            <label>E-mail</label>
            <input type="text" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
            <?php if (isset($errors['email'])) echo "<p>{$errors['email']}</p>"; ?>
        </div>
        <div>
            <label>Username</label>
            <input type="text" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
            <?php if (isset($errors['username'])) echo "<p>{$errors['username']}</p>"; ?>
        </div>
        <div>
            <label>Birthdate</label>
            <input type="date" id="birthday" name="birthdate"
                   value="<?= htmlspecialchars($_POST['birthdate'] ?? '') ?>">
            <?php if (isset($errors['birthdate'])) echo "<p>{$errors['birthdate']}</p>"; ?>
        </div>
        <div>
            <label>Password</label>
            <input type="password" name="password">
            <?php if (isset($errors['password'])) echo "<p>{$errors['password']}</p>"; ?>
        </div>
        <div>
            <label>Confirm Password</label>
            <input type="password" name="confirm_password">
            <?php if (isset($errors['confirm_password'])) echo "<p>{$errors['confirm_password']}</p>"; ?>
        </div>
        <button type="submit" name="register">Register</button>
    </form>

    <p>Already have an account? <a href="login.php">Login here</a></p>

    <?php require_once "../components/footer.php"; ?>
</main>