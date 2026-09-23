<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
          name="viewport">
    <meta content="ie=edge" http-equiv="X-UA-Compatible">
    <title></title>
    <link rel="icon" type="image/x-icon" href="/images/favicon.gif">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="../css/create.css">
</head>
<body>
<main>

<section>
    <h1>What do you want to add?</h1>
    <div class="prompt">
        <button type="button" class="add-post">Add post</button>
        <button type="button" class="add-event">Add event</button>
    </div>
</section>
</main>

<?php require_once "../components/footer.php"; ?>
</body>


<script>
    document.querySelector('.add-post').addEventListener('click', () => {
        window.location.href = '/create/add-post.php';
    });
    document.querySelector('.add-event').addEventListener('click', () => {
        window.location.href = '/create/add-event.php';
    });
</script>