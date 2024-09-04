<div class="wrapper">
    <!-- Sidebar -->
    <nav class="sidebar">
        <a href="<?= WEB_PATH.'index.php'?>" <h4 class="text-center"> <?= $_SESSION['is_admin']." Dashboard" ?> </h4> </a>
        <a href="<?= WEB_PATH.'index.php/event_list'?>" id="events-link">Events</a>
        <a href="<?= WEB_PATH.'index.php/user_list'?>">Users</a>
        <a href="javascript:void()" id="logout_link">Logout</a>
    </nav>

   