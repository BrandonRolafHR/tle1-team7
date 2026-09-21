<?php
session_start();
require_once 'includes/connection.php';

$errors = [];

if (isset($_POST['register'])) {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm = trim($_POST['confirm_password'] ?? '');

    //validation of form
    if ($username === '') $errors['username'] = 'Username is required';
    if ($password === '') $errors['password'] = 'Password is required';
    if ($password !== $confirm) $errors['confirm_password'] = 'Passwords do not match';

    //check if username already exists
    if (empty($errors)) {
        $usernameEsc = mysqli_real_escape_string($db, $username);
        $result = mysqli_query($db, "SELECT id FROM users WHERE username = '$usernameEsc' LIMIT 1");
        if (mysqli_num_rows($result) > 0) {
            $errors['username'] = 'Username already taken';
        }
    }

    //if all is good, insert user
    if (empty($errors)) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        mysqli_query($db, "INSERT INTO users (username, password) VALUES ('$usernameEsc', '$passwordHash')");
        $_SESSION['user_id'] = mysqli_insert_id($db);
        $_SESSION['username'] = $username;
        header('Location: list.php'); // redirect after register
        exit;
    }
}
?>

<main>
    <h2>Create an Account</h2>

    <form method="post">
        <div>
            <label>Username</label>
            <input type="text" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
            <?php if (isset($errors['username'])) echo "<p>{$errors['username']}</p>"; ?>
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
</main>