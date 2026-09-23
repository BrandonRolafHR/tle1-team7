<?php
session_start(); // must be called before checking/using $_SESSION
require_once '../included/connection.php';

if (!isset($_SESSION['loggedInUser'])) {
    header('Location: /Register/login.php');
    exit;
}

$errors = [];

if (isset($_POST['post'])) {
    $title = trim($_POST['title'] ?? '');
    $caption = trim($_POST['caption'] ?? '');
    $location = trim($_POST['location'] ?? '');

    // validation of form
    if ($title === '') $errors['title'] = 'Title is required';
    if ($caption === '') $errors['caption'] = 'Caption is required';
    if ($location === '') $errors['location'] = 'Location is required';

    // image validation (optional)
    if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
        if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            $errors['image'] = 'There was a problem uploading the image';
        } else {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $_FILES['image']['tmp_name']);
            finfo_close($finfo);

            if (!in_array($mimeType, $allowedTypes)) {
                $errors['image'] = 'File must be an image (jpeg, png, gif, or webp)';
            } elseif ($_FILES['image']['size'] > 5 * 1024 * 1024) { // 5MB limit
                $errors['image'] = 'Image must be smaller than 5MB';
            }
        }
    }

    // if all is good, insert post
    if (empty($errors)) {
        $filename = null;

        if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $filename = uniqid('post_', true) . '.' . $ext;
            $uploadPath = __DIR__ . '/../uploads/' . $filename; // adjust to your actual uploads folder

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                $errors['image'] = 'Failed to save the uploaded image';
            }
        }

        if (empty($errors)) {
            $userId = $_SESSION['loggedInUser']['id'];

            $stmt = mysqli_prepare($db, "INSERT INTO posts (user_id, title, image, text, location) VALUES (?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "issss", $userId, $title, $filename, $caption, $location);
            mysqli_stmt_execute($stmt);

            header('Location: /home.php');
            exit;
        }
    }
}

?>
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
    <h1>Add post</h1>
    <form method="post" enctype="multipart/form-data">
        <div>
            <label>Title</label>
            <input type="text" name="title" value="<?= htmlspecialchars($_POST['title'] ?? '') ?>">
            <?php if (isset($errors['title'])) echo "<p class='error'>{$errors['title']}</p>"; ?>
        </div>
        <div>
            <label>Image</label>
            <img id="preview" src="" alt="" style="display: none; max-width: 90vw; margin-top: 10px;">
            <input type="file" name="image" id="image" accept="image/*">
            <?php if (isset($errors['image'])) echo "<p class='error'>{$errors['image']}</p>"; ?>

        </div>
        <div>
            <label>Caption</label>
            <input type="text" name="caption" value="<?= htmlspecialchars($_POST['caption'] ?? '') ?>">
            <?php if (isset($errors['caption'])) echo "<p class='error'>{$errors['caption']}</p>"; ?>
        </div>
        <div>
            <label for="location">Location</label>
            <input list="locations" id="location" name="location" placeholder="Type or select a location" value="<?= htmlspecialchars($_POST['location'] ?? '') ?>">
            <datalist id="locations">
                <option value="Amsterdam">
                <option value="Rotterdam">
                <option value="The Hague">
                <option value="Utrecht">
                <option value="Flakkee">
                <option value="Urk">
            </datalist>
            <?php if (isset($errors['location'])) echo "<p class='error'>{$errors['location']}</p>"; ?>
        </div>

        <button type="submit" name="post">Post</button>
    </form>



</main>

<script>
    const imageInput = document.getElementById('image');
    const preview = document.getElementById('preview');

    imageInput.addEventListener('change', () => {
        const file = imageInput.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            preview.src = '';
            preview.style.display = 'none';
        }
    });
</script>


<?php require_once "../components/footer.php"; ?>
</body>
</html>