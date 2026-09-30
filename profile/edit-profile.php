<?php
session_start();
if (!isset($_SESSION['loggedInUser'])) {
    header('Location: login.php');
    exit;
}else {
    require_once "../included/connection.php";

    $query = "SELECT * FROM users WHERE id = " . $_SESSION['loggedInUser']['id'];
    $result = mysqli_query($db, $query);
    $user = mysqli_fetch_assoc($result);
    // mysqli_close($db);
}

if (isset($_POST['submit'])) {
    /** @var mysqli $db */
    require_once "../included/connection.php";

    // Get form data
    $username = mysqli_escape_string($db, $_POST['username']);
    $birthdate = mysqli_escape_string($db, $_POST['birthdate']);
    $email = mysqli_escape_string($db, $_POST['email']);
    $bio = mysqli_escape_string($db, $_POST['bio']);

    // Server-side validation
    $errors = [];
    if ($username == '') {
        $errors['username'] = 'Please fill in your username.';
    }
    if ($birthdate == '') {
        $errors['birthdate'] = 'Please fill in your birthdate.';
    }
    if ($email == '') {
        $errors['email'] = 'Please fill in your email.';
    }
    if ($bio === '') {
    $bio = 'no bio';
}
    

    // If data valid
    if (empty($errors)) {
        //update user data in the database.
        $query = "UPDATE users SET username='$username', birthdate='$birthdate', email='$email', bio='$bio' WHERE id=" . $_SESSION['loggedInUser']['id'];

        $result = mysqli_query($db, $query);

        if ($result) {
            mysqli_close($db);
            header('Location: settings.php');
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>edit user info</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="websiteContainer">
    <div class="container">
        <header class="settings-header">
            <a href="settings.php">
                <span>↫</span>
            </a>
            <h1>edit user info</h1>
        </header>
        <main class="edit-profile">
            <form action="" method="POST">
                <div class="form-group">
                <label for="username">username:</label>
                <input type="text" name="username" id="username" value="<?= htmlentities($user['username']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">email:</label>
                    <input type="email" name="email" id="email" value="<?= htmlentities($user['email']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="birthdate">birthdate:</label>
                    <input type="date" name="birthdate" id="birthdate" value="<?= $user['birthdate'] ?>" required>
                </div>

                <label for="bio">bio:</label>
                <textarea name="bio" id="bio" rows="4"><?= htmlentities($user['bio']) ?></textarea>

                <button type="submit" name="submit">save</button>
            </form>
        </main>
    </div>
</div>
</body>
</html>