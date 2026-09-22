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
    <title>Profiel</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<?php $activePage = 'profile'; ?>
<body>
    <header>
        <h1>username's journey</h1>
    </header>

    <main>
    </main>
    <?php require_once "../components/footer.php" ?>
</body>
</html>