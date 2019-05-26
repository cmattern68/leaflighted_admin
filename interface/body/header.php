<?php
if (preg_match("/body/i", $_SERVER['REQUEST_URI']))
    echo "<script type=\"text/javascript\">window.location.href = '../index.php?page=home';</script>";
$getPage = Lib::Sanitize($_GET['page']);
?>
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php?page=home">
        <div class="sidebar-brand-text mx-3">Leaflighted</div>
    </a>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?php if ($getPage == 'home') echo 'active'; ?>">
        <a class="nav-link" href="index.php?page=home">
            <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>
    <!-- Nav Item - Pages Collapse Menu -->
    <?php if ($current_user->getGrade() == true) { ?>
    <li class="nav-item  <?php if ($getPage == 'add_user' || $getPage == 'edit_user' || $getPage == 'delete_user'
    || $getPage == 'generate_auth_token' || $getPage == 'delete_auth_token' || $getPage == 'logs') echo 'active'; ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>User Config</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Manage User</h6>
                <a class="collapse-item" href="index.php?page=add_user">Register new user</a>
                <a class="collapse-item" href="index.php?page=edit_user">Edit user</a>
                <a class="collapse-item" href="index.php?page=delete_user">Delete user</a>
                <h6 class="collapse-header">Manage Token</h6>
                <a class="collapse-item" href="index.php?page=generate_auth_token">Generate auth token</a>
                <a class="collapse-item" href="index.php?page=delete_auth_token">Delete auth token</a>
                <h6 class="collapse-header">Manage Roles</h6>
                <a class="collapse-item" href="index.php?page=add_roles">Add roles</a>
                <a class="collapse-item" href="index.php?page=edit_roles">Edit Roles</a>
                <a class="collapse-item" href="index.php?page=delete_roles">Delete roles</a>
                <h6 class="collapse-header">Other</h6>
                <a class="collapse-item" href="index.php?page=logs">View Logs</a>
                <h6 class="collapse-header">Project Administration</h6>
                <a class="collapse-item" href="">Consult reports</a>
            </div>
        </div>
    </li>
<?php } ?>
    <li class="nav-item <?php if ($getPage == 'roadmap' || $getPage == 'unitest' || $getPage == 'benchmark' || $getPage == 'chat') echo 'active'; ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Utilities</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="index.php?page=roadmap">Roadmap</a>
                <a class="collapse-item" href="index.php?page=unitest">Unitest</a>
                <a class="collapse-item" href="index.php?page=benchmark">Benchmark</a>
                <a class="collapse-item" href="index.php?page=chat">Chat</a>
                <a class="collapse-item" href="">Make Weekly Report</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCalendar" aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-calendar-alt"></i>
            <span>Calendar</span>
        </a>
        <div id="collapseCalendar" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="">Add meeting</a>
                <a class="collapse-item" href="">Consult calendar</a>
            </div>
        </div>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Website
    </div>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item <?php if ($getPage == 'add_article' || $getPage == 'edit_article' || $getPage == 'delete_article'
    || $getPage == 'add_game' || $getPage == 'edit_game' || $getPage == 'delete_game') echo 'active'; ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#leaflighted" aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Leaflighted</span>
        </a>
        <div id="leaflighted" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Manage Article:</h6>
                <a class="collapse-item" href="index.php?page=add_article">Add Article</a>
                <a class="collapse-item" href="index.php?page=edit_article">Edit Article</a>
                <a class="collapse-item" href="index.php?page=delete_article">Delete Article</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Manage games:</h6>
                <a class="collapse-item" href="index.php?page=add_game">Add game</a>
                <a class="collapse-item" href="index.php?page=edit_game">Edit game</a>
                <a class="collapse-item" href="index.php?page=delete_game">Delete game</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#rite" aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Rite</span>
        </a>
        <div id="rite" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Manage Rite:</h6>
            </div>
        </div>
    </li>
<hr class="sidebar-divider d-none d-md-block">
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>
</ul>
