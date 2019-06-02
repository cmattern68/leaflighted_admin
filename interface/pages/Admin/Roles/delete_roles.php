<?php
if (preg_match("/pages/i", $_SERVER['REQUEST_URI']))
    echo "<script type=\"text/javascript\">window.location.href = '../../../index.php?page=home';</script>";
if (!$current_user->asAuthorizationToAccess("Manage Roles"))
    echo "<script type=\"text/javascript\">window.location.href = '../../../index.php?page=home';</script>";
require_once("../functions/Roles/delete_roles.func.php");
if (isset($_GET['uuid'])) {
    $uuid = Lib::Sanitize($_GET['uuid']);
    deleteRole($uuid);
}
$roles = Lib::getRolesListObj();
?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800"><i class="fas fa-fw fa-cog"></i>Delete Roles</h1>
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
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-target-<?php print $role->getUuid(); ?>">Delete Roles </button>
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
foreach ($roles as $role) {
?>
    <div class="modal fade" id="modal-target-<?php print $role->getUuid(); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete role <?php echo $role->_name; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Do you really want to delete <?php echo $role->_name; ?> role ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <form method="POST" action="">
                        <a href="index.php?page=delete_roles&uuid=<?php echo $role->getUuid(); ?>" class="btn btn-primary btn-user btn-block">Save changes</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>
