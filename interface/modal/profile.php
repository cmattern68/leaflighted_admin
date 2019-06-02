<?php
if (preg_match("/modal/i", $_SERVER['REQUEST_URI']))
    echo "<script type=\"text/javascript\">window.location.href = '../index.php?page=home';</script>";
?>
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

                                <dt class="col-sm-3">Roles</dt>
                                <dd class="col-sm-9">
                                    <?php
                                        $userRoles = $current_user->getRoles();
                                        foreach ($userRoles as $role) {
                                            echo "<p>".$role->_name."</p>";
                                        }
                                    ?>
                                </dd>

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
