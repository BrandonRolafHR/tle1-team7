<?php

session_start();



if (!isset($_SESSION['loggedInUser'])) {
    header('Location: login.php');
    exit;
}

require_once "included/connection.php";
/** @var mysqli $db */
$id = mysqli_escape_string($db, $_GET['id']);
// $query = "SELECT * FROM authors";
// $results = mysqli_query($db, $query);
// $authors = mysqli_fetch_all($results, MYSQLI_ASSOC);


// $query = "SELECT * FROM genres";
// $results = mysqli_query($db, $query);
// $genres = mysqli_fetch_all($results, MYSQLI_ASSOC);


// $query = "SELECT * FROM books WHERE id= $id";
// $results = mysqli_query($db, $query);

// $books = mysqli_fetch_assoc($results);
$query = "SELECT events.*, users.username 
          FROM events 
          JOIN users ON events.user_id = users.id 
          WHERE events.id = $id";
$result = mysqli_query($db, $query);
$events = mysqli_fetch_assoc($result);

if (isset($_POST['submit'])) {
    $eventId = mysqli_escape_string($db, $_POST['id']);
    $name = mysqli_escape_string($db, $_POST['name']);
    $date = mysqli_escape_string($db, $_POST['date']);
    $description = mysqli_escape_string($db, $_POST['description']);
    $userId = (int)$_SESSION['loggedInUser']['id'];


    $errorMessages = [];

   if ($name == '') {
        $errors['name'] = 'Please fill in the name of the event.';
    }
    if ($date == '') {
        $errors['date'] = 'Please fill in the date of the event.';
    }


    if (empty($errorMessages)) {

        $query = "UPDATE `events` SET `name`='$name',`date`='$date',`description`='$description'  WHERE `id` = $eventId";
        $results = mysqli_query($db, $query);
        mysqli_close($db);
        // header('Location:event.php?id='$userid);
        // header('Location: ' . $_SERVER['HTTP_REFERER']);
        header('Location: event.php?id=' . $id);


        exit;
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>event - Edit</title>
</head>
<body>

<header>
    
        <h1>Edit event</h1>

</header>

<div>
    <section>
        <a href="create.php"> Add new author or genre</a>
        <form action="" method="POST">

            <div class="field is-horizontal">
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                            <input class="input" id="id" type="hidden" name="id"
                                   value="<?= htmlentities($id ?? '') ?>"/>
                        </div>
                    </div>
                </div>
            </div>

            <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <label class="label" for="name">Name</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                            <input class="input" id="name" type="text" name="name"
                                   value="<?= htmlentities($events['name']) ?>"/>
                        </div>
                        <p class="help is-danger">
                            <?= $errorMessages['name'] ?? '' ?>
                        </p>
                    </div>
                </div>
            </div>

            <div>
                <div class="form-group">
                        <label for="date">date and time:</label>
                        <input type="datetime-local" name="date" id="date"
                            value="<?= htmlentities($events['date']) ?>">
                </div>
                <p class="help is-danger">
                            <?= $errorMessages['date'] ?? '' ?>
                        </p>
            </div>

            <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <label class="label" for="description">description</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control">

                            <input class="input" id="description" type="text" name="description"
                                   value="<?= htmlentities($events['description']) ?>"/>

                        </div>


                    </div>
                </div>
            </div>

            


            <div class="field is-horizontal">
                <div class="field-label is-normal"></div>
                <div class="field-body">
                    <button class="button is-link is-fullwidth" type="submit" name="submit">Save</button>
                </div>
            </div>
        </form>

    </section>
   
</div>
</body>
</html>

