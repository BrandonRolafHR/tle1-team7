<?php

session_start();

if (!isset($_SESSION['loggedInUser'])) {
    header('Location: login.php');
    exit;
}
$errors = [];

if (isset($_POST['submit'])) {
    /** @var mysqli $db */
    require_once "../included/connection.php";

    // Get form data
    $name        = trim($_POST['name'] ?? '');
    $date        = $_POST['date'] ?? '';
    $description = trim($_POST['description'] ?? '');
    $visible     = $_POST['visible'] ?? 'private';
    $userId      = (int)$_SESSION['loggedInUser']['id'];

    // Server-side validation
    
    if ($name == '') {
        $errors['name'] = 'Please fill in the name of the event.';
    }
    if ($date == '') {
        $errors['date'] = 'Please fill in the date of the event.';
    }
    
    
    if (!in_array($visible, ['private', 'friends', 'everyone'], true)) {
        $visible = 'private';
    }

    // If data valid
      if (empty($errors)) {
        $stmt = mysqli_prepare($db,
            "INSERT INTO events (user_id, name, date, description, visibility)
             VALUES (?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'issss', $userId, $name, $date, $description, $visible);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_close($db);
            header('Location: /2026_2027/tle_t7/calendar.php/');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Momento</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/create.css">
</head>
<?php $activePage = 'add'; ?>
<body>
        <header class="event">
            <a href="/index.php">
                <span>↫</span>
            </a>
            <h1>Add new event</h1>
        </header>        
        <main>

            <form action="" method="POST">
                <div class="event">
                <label for="name">Event name</label>
                <input type="text" name="name" id="name" >
                </div>

                <div>
                    <label for="visible">Open to</label>
                    <select id="visible" name= "visible">
                        <option value="private">private</option>
                        <option value="friends">friends</option>
                        <option value="everyone">everyone</option>

                    </select>
                </div>

                <div class="event">
                    <label for="date">Date and time</label>
                    <input type="datetime-local" name="date" id="date">
                </div>

                <div class="event" >
                    <label for="description">Description</label>
                    <input type="text" name="description" id="description" >
                </div>               

                <button type="submit" name="submit">Save</button>
            </form>
        </main>
       <?php require_once "../components/footer.php"; ?>
    </body>
</html>