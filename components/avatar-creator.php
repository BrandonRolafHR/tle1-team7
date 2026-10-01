<?php

if (!isset($_SESSION['loggedInUser'])) {
    header('Location: /Register/login.php');
    exit;
} else {
    $user_id = $_SESSION['loggedInUser']['id'];
    $user_query = "SELECT * 
            FROM users 
            WHERE users.id = $user_id";
    $user_result = mysqli_query($db, $user_query);
    $user = mysqli_fetch_assoc($user_result);
}


if (isset($_POST['submit'])) {
    $imageName = $user['avatar'];

    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
        $imageName = time() . '_' . $_FILES['avatar']['name'];
        $uploadFileDir = './uploads/';

        if (!is_dir($uploadFileDir)) {
            mkdir($uploadFileDir, 0777, true);
        }

        if (!move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFileDir . $imageName)) {
            $imageName = $user['avatar']; // Fallback if move fails

        }


    }

    $profile_query = "UPDATE users 
                        SET avatar = '" . mysqli_real_escape_string($db, $imageName) . "' 
                        WHERE users.id = $user_id";
    mysqli_query($db, $profile_query);
    mysqli_close($db);

    header('Location:home.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>edit user info</title>

<link rel="stylesheet" href="../css/style.css">
<script defer src="../js/avatar.js"></script>
</head>

<body>
<div class="websiteContainer">
    <div class="container">

<div>

    <header class="settings-header">
        <a href="../profile/edit-profile.php">
            <span>↫</span>
        </a>
        <h1>customise your mimin</h1>
    </header>


<div>
<div class="mimin">
    <img class="miminImage" id="skinImg" src="../avatar-components/tle1_body/body-pale.PNG" alt="selected skin colour">
    <img class="miminImage" id="eyesImg" src="../avatar-components/tle1_eyes/eyes_blue.PNG" alt="selected eye colour">
    <img class="miminImage" id="hairImg" src="../avatar-components/tle1_black/long_black.PNG" alt="selected hairstyle">
    <img class="miminImage" id="clothingImg" src="../avatar-components/tle1_clothing/style-1.PNG" alt="selected clothing">
    <img class="miminImage" id="accessoriesImg" src="../avatar-components/tle1_accessories/bow-pink.PNG" alt="selected accessory">
</div>
</div>




<form method="post" class="miminOptions" enctype="multipart/form-data">
    <input type="hidden" name="avatar" id="avatarData">

<div class="miminButtons">
<div class="skinOptions">
    <button type="button" onclick="prevFunctionSkin()"><</button>
    <p>Skin colour</p>
    <button type="button" onclick="nextFunctionSkin()">></button>
</div>

<div class="eyeOptions">
    <button type="button" onclick="prevFunctionEyes()"><</button>
    <p>Eye colour</p>
    <button type="button" onclick="nextFunctionEyes()">></button>
</div>

<div class="hairOptions">
    <button type="button" onclick="prevFunctionHair()"><</button>
    <p>Hairstyle</p>
    <button type="button" onclick="nextFunctionHair()">></button>
</div>

<div class="clothingOptions">
    <button type="button" onclick="prevFunctionClothing()"><</button>
    <p>Clothing</p>
    <button type="button" onclick="nextFunctionClothing()">></button>
</div>

<div class="accessoryOptions">
    <button type="button" onclick="prevFunctionAccessories()"><</button>
    <p>Accessories</p>
    <button type="button" onclick="nextFunctionAccessories()">></button>
</div>
</div>

    <div class="uploadMimin">
    <p>screenshot me and upload me as profile picture!</p>


    <label>
        <input type="file" name="profile_picture" id="profile_picture">
        <span><span class="file-label"></span></span>
    </label>
        <p>
            <?= isset($errorMessages['profile_picture']) ? htmlentities($errorMessages['profile_picture']) : '' ?>
        </p>
    </div>

    <button type="submit" name="submit" class="saveMimin"><a href="/home.php">upload my mimin</a></button>

</form>



</div>

    </div>

</div>

</body>