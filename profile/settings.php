<?php
// session_start();

// if (!isset($_SESSION['loggedInUser'])) {
//     header('Location: login.php');
//     exit;
// }else {
//     require_once "includes/database.php";

//     $query = "SELECT * FROM users WHERE id = " . $_SESSION['loggedInUser']['id'];
//     $result = mysqli_query($db, $query);
//     $user = mysqli_fetch_assoc($result);
//     mysqli_close($db);
// }

?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>settings</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
        <header class="settings-header">
            <a href="/tle1-team7/profile/profile.php">
                <span>↫</span>
            </a>
            <h1>settings</h1>
        </header>
    <main>
        <section class="user-info">
            <h2>account gegevens</h2>
            <p>gebruikersnaam:</p>
            <p>email:</p>
            <p>geboortedatum:</p>
            <p>bio:</p>
            <a href="/edit-profile.php">
                <div>wijzig ✏️</div>
            </a>

            <a href="../Register/logout.php">
                <div>uitloggen</div>
            </a>

        </section>
    </main>

</body>
</html>