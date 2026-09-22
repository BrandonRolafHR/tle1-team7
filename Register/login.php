<?php
//connect to database
//if form is filled in
//then check if password and username are correct
//if not? show error
//otherwise send to the mainpage


session_start();
require_once '../included/connection.php';

$errors = [];
$redirect = $_GET['redirect'] ?? 'index.php';

if (isset($_POST['login'])) {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $redirect = $_POST['redirect'] ?? 'index.php'; // default after login

    if ($username === '') $errors['username'] = 'Username is required';
    if ($password === '') $errors['password'] = 'Password is required';

    if (empty($errors)) {
        $stmt = mysqli_prepare($db, "SELECT id, username, email, password FROM users WHERE username = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user['password'])) {
                $_SESSION['loggedInUser'] = [
                        'id' => $user['id'],
                        'name' => $user['username'],
                        'email' => $user['email'],
                ];
                header('Location: /tle1-team7/home.php' . $redirect);
                exit;
            } else {
                $errors['login'] = 'Invalid username or password';
            }
        } else {
            $errors['login'] = 'Invalid username or password';
        }
    }
}


?>

<body>

<main>
    <section>
        <form method="post">
            <input type="hidden" name="redirect" value="<?= htmlspecialchars($redirect) ?>">
            <div>
                <label>Username</label>
                <input type="text" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
            </div>
            <div>
                <label>Password</label>
                <input type="password" name="password">
            </div>
            <button type="submit" name="login">Login</button>
            <?php if (isset($errors['login'])) echo "<p>{$errors['login']}</p>"; ?>
        </form>
    </section>
    <div>
        <p>Dont have an account?</p>
        <a href="register.php">Register</a>
    </div>
    <section>
        <a href="logout.php">Logout</a>
    </section>
</main>

</body>