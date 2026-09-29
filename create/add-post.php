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

    // validation of form (location is optional)
    if ($title === '') $errors['title'] = 'Title is required';
    if ($caption === '') $errors['caption'] = 'Caption is required';

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
        $imageData = null;

        if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imageData = file_get_contents($_FILES['image']['tmp_name']);
            // skip move_uploaded_file entirely — storing the raw bytes in the DB instead
        }

        if (empty($errors)) {
            $userId = $_SESSION['loggedInUser']['id'];

            // store NULL instead of an empty string when no location is given
            $location = $location === '' ? null : $location;

            $stmt = mysqli_prepare($db, "INSERT INTO posts (user_id, title, image, text, location) VALUES (?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "issss", $userId, $title, $imageData, $caption, $location);
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
    <style>
        /* "Choose image" button (move this into create.css if you prefer) */
        .pick-btn {
            display: inline-block;
            padding: 8px 16px;
            border: 2px solid #4a6aa5;
            border-radius: 12px;
            background: white;
            cursor: pointer;
        }
    </style>
</head>
<?php $activePage = 'add'; ?>
<body>
<div class="websiteContainer">
<main>
    <h1>Add post</h1>
    <form method="post" enctype="multipart/form-data">
        <div>
            <label>Title</label>
            <input type="text" name="title" value="<?= htmlspecialchars($_POST['title'] ?? '') ?>">
            <?php if (isset($errors['title'])) echo "<p class='error'>{$errors['title']}</p>"; ?>
        </div>
        <div class="under">
            <label>Image</label>
            <label for="image" class="image-picker">
                <img id="preview" src="" alt="Tap to change image" style="display: none; max-width: 90vw; margin-top: 10px; cursor: pointer; border-radius: 2vh;">
                <span id="pick-text" class="pick-btn">Choose image</span>
            </label>
            <input type="file" name="image" id="image" accept="image/*" hidden>
            <?php if (isset($errors['image'])) echo "<p class='error'>{$errors['image']}</p>"; ?>
        </div>
        <div>
            <label for="caption">Caption</label>
            <textarea name="caption" id="caption" rows="1"><?= htmlspecialchars($_POST['caption'] ?? '') ?></textarea>
            <?php if (isset($errors['caption'])) echo "<p class='error'>{$errors['caption']}</p>"; ?>
        </div>
        <div>
            <label for="location">Location (optional)</label>
            <input list="locations" id="location" name="location" placeholder="Type or select a location" value="<?= htmlspecialchars($_POST['location'] ?? '') ?>">
            <datalist id="locations">
                <option value="Amsterdam">
                <option value="Rotterdam">
                <option value="The Hague">
                <option value="Utrecht">
                <option value="Flakkee">
                <option value="Urk">
            </datalist>
        </div>

        <button type="submit" name="post">Post</button>
    </form>

</main>
</div>
<script>
    const imageInput = document.getElementById('image');
    const preview = document.getElementById('preview');
    const pickText = document.getElementById('pick-text');

    imageInput.addEventListener('change', () => {
        const file = imageInput.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                preview.src = e.target.result;
                preview.style.display = 'block';
                pickText.style.display = 'none';
            };
            reader.readAsDataURL(file);
        } else {
            preview.src = '';
            preview.style.display = 'none';
            pickText.style.display = 'inline-block';
        }
    });

    const caption = document.getElementById('caption');

    function autoGrow() {
        caption.style.height = 'auto';                    // reset so it can also shrink
        caption.style.height = caption.scrollHeight + 'px';
    }

    caption.addEventListener('input', autoGrow);
    autoGrow(); // sizes it correctly on page load (e.g. after a validation error re-fills it)
</script>


<?php require_once "../components/footer.php"; ?>
</body>
</html>
