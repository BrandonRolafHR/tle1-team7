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
    $name = mysqli_escape_string($db, $_POST['name']);
    $date = mysqli_escape_string($db, $_POST['date']);
    $description = mysqli_escape_string($db, $_POST['description']);
    $userId = (int)$_SESSION['loggedInUser']['id'];

    // Server-side validation
    
    if ($name == '') {
        $errors['name'] = 'Please fill in the name of the event.';
    }
    if ($date == '') {
        $errors['date'] = 'Please fill in the date of the event.';
    }
    
    
    

    // If data valid
    if (empty($errors)) {
        //update user data in the database.
                $query = "INSERT INTO events (user_id, name, date, description) 
                  VALUES ('$userId', '$name', '$date', '$description')";

        $result = mysqli_query($db, $query);

        if ($result) {
            mysqli_close($db);
            
            header('Location: /calendar.php');
            // header('Location: ' . $_SERVER['HTTP_REFERER']);
        

// header("location:javascript://history.go(-1)");

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
    <link rel="stylesheet" href="/css/style.css">
     <link rel="stylesheet" href="/css/calendar.css">
</head>
<body>
   
    
         <header class="settings-header">
            <a href="/index.php">
                <span>↫</span>
            </a>
            <h1>Add new event</h1>
        </header>

        
            <main class="edit-profile">
            <form action="" method="POST">
                <div class="form-group">
                <label for="name">event name:</label>
                <input type="text" name="name" id="name" >
                </div>

                 <!-- <div class="form-group">
                    <label for="date">date:</label>
                    <input type="date" name="date" id="date" >
                </div> -->
                <div class="form-group">
                    <label for="date">date and time:</label>
                    <input type="datetime-local" name="date" id="date">
                </div>

                <div class="form-group">
                    <label for="description">description:</label>
                    <input type="description" name="description" id="description" >
                </div>

               

                

                <button type="submit" name="submit">opslaan</button>
            </form>
        </main>
    </body>
</html>