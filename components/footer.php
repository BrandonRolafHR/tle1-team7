<?php

?>
<!-- <link rel="stylesheet" href="../css/style.css"> -->
<script defer src="../js/footer.js"></script>

    <footer>
        <div class="item <?php if(isset($activePage) && $activePage === 'home') echo 'active'; ?>">
            <img src="../images/home-icon.png" alt="home icon" class="home">
        </div>

        <div class="item <?php if(isset($activePage) && $activePage === 'calender') echo 'active'; ?>">
            <img src="../images/agenda-icon.png" alt="calender icon" class="calender">
        </div>

        <div class="item <?php if(isset($activePage) && $activePage === 'add') echo 'active'; ?>">
            <img src="../images/add-icon.png" alt="new icon" class="add">
        </div>

        <div class="item <?php if(isset($activePage) && $activePage === 'friends') echo 'active'; ?>">
            <img src="../images/friends-icon.png" alt="friends icon" class="friends">
        </div>

        <div class="item <?php if(isset($activePage) && $activePage === 'profile') echo 'active'; ?>">
            <img src="../images/profile-icon.png" alt="profile icon" class="profile">
        </div>
    </footer>
