<?php
if (preg_match("/pages/i", $_SERVER['REQUEST_URI']))
    echo "<script type=\"text/javascript\">window.location.href = '../../../index.php?page=home';</script>";
if (!$current_user->asAuthorizationToAccess("Manage Roles"))
    echo "<script type=\"text/javascript\">window.location.href = '../../../index.php?page=home';</script>";
    require_once("../functions/Roles/edit_roles.func.php");
$roles = Lib::getRolesListObj();
$sections = Lib::getSections();
?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800"><i class="fas fa-fw fa-cog"></i>Edit Roles</h1>
    <div class="row">
        <div class="col-lg-7">
            <div class="p-5">
                <table class="table table-hover table-dark">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($roles as $role) {
                            ?>
                            <tr>
                                <th scope="row"><?php echo $i; ?></th>
                                <td><?php echo $role->_name; ?></td>
                                <td>
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-target-<?php print $role->getUuid(); ?>">Edit Roles </button>
                                </td>
                            </tr>
                            <?php
                            ++$i;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php
if (isset($_POST['submit']))
    editRoles();
foreach ($roles as $role) {
?>
    <form method="POST" action="">
        <div class="modal fade" id="modal-target-<?php print $role->getUuid(); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit role <?php echo $role->_name; ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-hover table-dark">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Section</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 0;
                            foreach ($sections as $section) {
                                ++$i;
                            ?>
                            <tr>
                                <th scope="row"><?php echo $i; ?></th>
                                <td><?php echo Lib::Sanitize($section); ?></td>
                                <td><input type="checkbox" <?php if ($role->canDoThis($section)) echo "checked";?> data-toggle="toggle" data-onstyle="success" name="action-<?php echo $role->getUuid().'-'.$section; ?>" value="on"></td>
                            </tr>
                            <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="submit">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
<?php
}
?>
