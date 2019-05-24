<?php
if (preg_match("/body/i", $_SERVER['REQUEST_URI']))
    header("Location: ../index.php?page=home");
require_once('../functions/edit_current_user.func.php');
?>
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>
    <!-- Topbar Search -->
    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
        <div class="input-group">
            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>
    </form>
    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
        <li class="nav-item dropdown no-arrow d-sm-none">
            <a class="nav-link dropdown-toggle" href="../#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>
        <div class="topbar-divider d-none d-sm-block"></div>
        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="../#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $current_user->_name." ".$current_user->_lastname; ?></span>
                <img class="img-profile rounded-circle" src="<?php echo $current_user->_avatar; ?>" width="60" height="60">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#" data-toggle="modal" data-target=".profile-cl">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target=".edit-profile-cl">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Settings
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="index.php?page=logout" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>
    </ul>
</nav>
<div class="modal fade profile-cl" idtabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">My Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-6 col-md-4">
                            <img src="<?php echo $current_user->_avatar; ?>" alt="" class="img-thumbnail" width="200px">
                        </div>
                        <div class="col-12 col-md-8">
                            <dl class="row">
                                <dt class="col-sm-3">First Name</dt>
                                <dd class="col-sm-9"><?php echo $current_user->_name; ?></dd>

                                <dt class="col-sm-3">Last Name</dt>
                                <dd class="col-sm-9"><?php echo $current_user->_lastname; ?></dd>

                                <dt class="col-sm-3">Email</dt>
                                <dd class="col-sm-9"><?php echo $current_user->getEmail(); ?></dd>

                                <dt class="col-sm-3">Login</dt>
                                <dd class="col-sm-9"><?php echo $current_user->_login; ?></dd>

                                <dt class="col-sm-3">Admin</dt>
                                <dd class="col-sm-9"><?php echo $current_user->getGrade() ? "True" : "False"; ?></dd>

                                <dt class="col-sm-3">Number of token</dt>
                                <dd class="col-sm-9"><?php echo count($current_user->getTokens()); ?></dd>
                            </dl>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade edit-profile-cl" idtabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit My Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="" enctype="multipart/form-data">
                    <?php
                    if (isset($_POST['editSubmit']))
                        makeChanges($current_user);
                    ?>
                    <div class="container">
                        <div class="row">
                            <div class="col-6 col-md-4">
                                <img src="<?php echo $current_user->_avatar; ?>" alt="" class="img-thumbnail" width="200px">
                                <input type="file" class="form-control-file file-edit" id="editAvatar" name="editAvatar">
                            </div>
                            <div class="col-12 col-md-8">
                                <dl class="row">
                                    <dt class="col-sm-3">First Name</dt>
                                    <dd class="col-sm-9"><?php echo $current_user->_name; ?></dd>

                                    <dt class="col-sm-3">Last Name</dt>
                                    <dd class="col-sm-9"><?php echo $current_user->_lastname; ?></dd>

                                    <dt class="col-sm-3">Email</dt>
                                    <dd class="col-sm-9">
                                        <input type="email" class="form-control" id="editEmail" aria-describedby="emailHelp" name="editEmail" value="<?php echo $current_user->getEmail(); ?>">
                                    </dd>

                                    <dt class="col-sm-3">Login</dt>
                                    <dd class="col-sm-9"><?php echo $current_user->_login; ?></dd>

                                    <dt class="col-sm-3">Admin</dt>
                                    <dd class="col-sm-9"><?php echo $current_user->getGrade() ? "True" : "False"; ?></dd>

                                    <dt class="col-sm-3">Number of token</dt>
                                    <dd class="col-sm-9"><?php echo count($current_user->getTokens()); ?></dd>
                                </dl>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-primary" value="Save changes" name="editSubmit" id="editSubmit">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
