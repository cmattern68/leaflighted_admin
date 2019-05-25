<?php
if (preg_match("/modal/i", $_SERVER['REQUEST_URI']))
    echo "<script type=\"text/javascript\">window.location.href = '../index.php?page=home';</script>";
require_once('../functions/User/edit_current_user.func.php');
?>
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
                    if (isset($_POST['editSubmit'])) {
                        makeChanges($current_user);
                        ?>
                        <script type='text/javascript'>
                            $(window).load(function(){
                                $('.edit-profile-cl').modal('show');
                            });
                        </script>
                    <?php
                    }
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
