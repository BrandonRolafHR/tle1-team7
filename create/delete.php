<?php
session_start();
require_once '../included/connection.php';

if (!isset($_SESSION['loggedInUser'])) {
    header('Location: /Register/login.php');
    exit;
}

$userId = $_SESSION['loggedInUser']['id'];
$postId = (int)($_GET['id'] ?? $_POST['id'] ?? 0);

if ($postId <= 0) {
    header('Location: /home.php');
    exit;
}

// fetch the post, but only if it belongs to the logged in user
$stmt = mysqli_prepare($db, "SELECT id, title FROM posts WHERE id = ? AND user_id = ?");
mysqli_stmt_bind_param($stmt, "ii", $postId, $userId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$post = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

// post doesn't exist or isn't yours
if (!$post) {
    header('Location: /home.php');
    exit;
}

// confirmed: actually delete (POST only, so a link/crawler can't delete by accident)
if (isset($_POST['confirm_delete'])) {
    $stmt = mysqli_prepare($db, "DELETE FROM posts WHERE id = ? AND user_id = ?");
    mysqli_stmt_bind_param($stmt, "ii", $postId, $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header('Location: /home.php');
    exit;
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
          name="viewport">
    <meta content="ie=edge" http-equiv="X-UA-Compatible">
    <title>Delete post</title>
    <link rel="icon" type="image/x-icon" href="/images/favicon.gif">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="../css/create.css">
</head>
<body>
<main style="padding-bottom: 120px;">
    <h1>Delete post</h1>
    <p style="text-align: center;">
        Are you sure you want to delete "<?= htmlspecialchars($post['title']) ?>"? This can't be undone.
    </p>

    <form method="post">
        <input type="hidden" name="id" value="<?= $post['id'] ?>">
        <div class="delete-actions">

            <button type="submit" name="confirm_delete" class="danger">Delete</button>
            <a href="/home.php">Cancel</a>
        </div>
    </form>
</main>

<?php require_once "../components/footer.php"; ?>
</body>
</html>