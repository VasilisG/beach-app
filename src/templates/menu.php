<?php
session_start();
?>

<div class="side-actions">
    <a id="menu-toggle" class="menu-toggle side-action" title="Toggle Menu">
        <i class="fa-solid fa-bars"></i>
    </a>
    <a id="add-pin-action" class="add-pin side-action" title="Add Place">
        <i class="fa-solid fa-location-dot"></i>
    </a>
    <a id="user-status-action" 
       class="user-status side-action <?= isset($_SESSION['token']) ? 'user-loggedin' : 'user-loggedout' ?>" 
       title="<?= isset($_SESSION['token']) ? 'Logged In' : 'Logged Out' ?>">
        <i class="fa-solid fa-user"></i>
    </a>
</div>
<div id="menu-container" class="menu-container">
    <nav class="navigation-menu">
        <div class="menu-close-container">
            <span id="menu-close" class="menu-close">
                <i class="fa-sharp fa-solid fa-xmark"></i>
            </span>
        </div>
        <div class="nav-group">
            <h3 class="nav-group-title">User</h3>
            <hr class="nav-hr">
            <?php if(isset($_SESSION['token'])): ?>
                <a class="nav-action logout-action" id="logout-action"><i class="fa-solid fa-power-off"></i><span class="nav-action-name">Logout</span></a>
            <?php else: ?>
                <a class="nav-action login-action" id="login-action"><i class="fa-solid fa-power-off"></i><span class="nav-action-name">Login</span></a>
            <?php endif; ?>
            <a class="nav-action register-action <?= isset($_SESSION['token']) ? 'nav-action-inactive' : '' ?>" id="register-action">
                <i class="fa-solid fa-user-plus"></i><span class="nav-action-name">Register</span>
            </a>
        </div>
        <div class="nav-group">
            <h3 class="nav-group-title">Content</h3>
            <hr class="nav-hr">
            <a class="nav-action user-content-action" user-content="place"><i class="fa-solid fa-umbrella-beach"></i><span class="nav-action-name">Places</span></a>
            <a class="nav-action user-content-action" user-content="photo"><i class="fa-sharp fa-solid fa-images"></i><span class="nav-action-name">Photos</span></a>
            <a class="nav-action user-content-action" user-content="comment"><i class="fa-solid fa-comment"></i><span class="nav-action-name">Comments</span></a>
        </div>
    </nav>
</div>