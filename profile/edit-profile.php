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

    // Raw values (no escaping needed, the prepared statement handles it)
    $username  = trim($_POST['username'] ?? '');
    $birthdate = trim($_POST['birthdate'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $bio       = trim($_POST['bio'] ?? '');

    // Server-side validation
    $errors = [];

    if ($username === '') {
        $errors['username'] = 'Please fill in your username.';
    } elseif (mb_strlen($username) < 3) {
        $errors['username'] = 'Username must be at least 3 characters.';
    } elseif (mb_strlen($username) > 20) {
        $errors['username'] = 'Username can be at most 20 characters.';
    } else {
        // make sure nobody else already has this username
        $stmt = mysqli_prepare($db, "SELECT id FROM users WHERE username = ? AND id != ? LIMIT 1");
        mysqli_stmt_bind_param($stmt, 'si', $username, $_SESSION['loggedInUser']['id']);
        mysqli_stmt_execute($stmt);
        if (mysqli_num_rows(mysqli_stmt_get_result($stmt)) > 0) {
            $errors['username'] = 'Username is already taken.';
        }
    }

    if ($birthdate === '') {
        $errors['birthdate'] = 'Please fill in your birthdate.';
    }
    if ($email === '') {
        $errors['email'] = 'Please fill in your email.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email address.';
    }
    if ($bio === '') {
        $bio = 'no bio';
    }

    if (empty($errors)) {
        $stmt = mysqli_prepare($db, "UPDATE users SET username = ?, birthdate = ?, email = ?, bio = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, 'ssssi', $username, $birthdate, $email, $bio, $_SESSION['loggedInUser']['id']);

        if (mysqli_stmt_execute($stmt)) {
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
                    <input type="text" name="username" id="username" maxlength="20"
                           value="<?= htmlentities($_POST['username'] ?? $user['username']) ?>" required>
                    <?php if (isset($errors['username'])) echo "<p class='error'>" . htmlentities($errors['username']) . "</p>"; ?>
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

                <button><a href="../Register/create-mimin.php">customise mimin</a></button>
                
                <button type="submit" name="submit">save</button>
            </form>
        </main>
    </div>
        
    </div>



</body>
</html>