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
    <?php if ($current_user->asAuthorizationToAccess(array(
        "Manage Users",
        "Manage Tokens",
        "Manage Roles",
        "Consult Logs",
        "Project Administration",
    ))) { ?>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Users Config</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <?php
                if ($current_user->asAuthorizationToAccess("Manage Users")) {
                ?>
                <h6 class="collapse-header">Manage Users</h6>
                <a class="collapse-item" href="index.php?page=add_user">Register new user</a>
                <a class="collapse-item" href="index.php?page=edit_user_roles">Edit users roles</a>
                <a class="collapse-item" href="index.php?page=delete_user_roles">Delete users roles</a>
                <a class="collapse-item" href="index.php?page=delete_user">Delete users</a>
                <?php
                }

                if ($current_user->asAuthorizationToAccess("Manage Tokens")) {
                ?>
                <h6 class="collapse-header">Manage Tokens</h6>
                <a class="collapse-item" href="index.php?page=generate_auth_token">Generate auth tokens</a>
                <a class="collapse-item" href="index.php?page=delete_auth_token">Delete auth tokens</a>
                <?php
                }

                if ($current_user->asAuthorizationToAccess("Manage Roles")) {
                ?>
                <h6 class="collapse-header">Manage Roles</h6>
                <a class="collapse-item" href="index.php?page=add_roles">Add roles</a>
                <a class="collapse-item" href="index.php?page=edit_roles">Edit Roles</a>
                <a class="collapse-item" href="index.php?page=delete_roles">Delete roles</a>
                <?php
                }

                if ($current_user->asAuthorizationToAccess("Consult Logs")) {
                ?>
                <h6 class="collapse-header">Other</h6>
                <a class="collapse-item" href="index.php?page=logs">View Logs</a>
                <?php
                }

                if ($current_user->asAuthorizationToAccess("Project Administration")) {
                ?>
                <h6 class="collapse-header">Project Administration</h6>
                <a class="collapse-item" href="">Consult reports</a>
                <?php
                }
                ?>
            </div>
        </div>
    </li>
    <?php
    }

    if ($current_user->asAuthorizationToAccess("Utilities")) {
        ?>
    <li class="nav-item">
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
    <?php
    }

    if ($current_user->asAuthorizationToAccess("Calendar")) {
    ?>
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
    <?php
    }

    if ($current_user->asAuthorizationToAccess(array(
        "Manage Article",
        "Manage Games"
    ))) {
    ?>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Website
    </div>
    <!-- Nav Item - Pages Collapse Menu -->
    <?php
    if ($current_user->asAuthorizationToAccess(array(
        "Manage Article",
        "Manage Games"
    ))) {
    ?>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#leaflighted" aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Leaflighted</span>
        </a>
        <div id="leaflighted" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <?php
                if ($current_user->asAuthorizationToAccess("Manage Article")) {
                ?>
                <h6 class="collapse-header">Manage Article:</h6>
                <a class="collapse-item" href="index.php?page=add_article">Add Article</a>
                <a class="collapse-item" href="index.php?page=edit_article">Edit Article</a>
                <a class="collapse-item" href="index.php?page=delete_article">Delete Article</a>
                <?php
                }

                if ($current_user->asAuthorizationToAccess("Manage Games")) {
                ?>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Manage games:</h6>
                <a class="collapse-item" href="index.php?page=add_game">Add game</a>
                <a class="collapse-item" href="index.php?page=edit_game">Edit game</a>
                <a class="collapse-item" href="index.php?page=delete_game">Delete game</a>
                <?php
                }
                ?>
            </div>
        </div>
    </li>
        <?php
        }
        ?>
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
    <?php
    }
    ?>
<hr class="sidebar-divider d-none d-md-block">
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>
</ul>
