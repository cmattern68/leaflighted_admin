<?php
if (preg_match("/pages/i", $_SERVER['REQUEST_URI']))
    echo "<script type=\"text/javascript\">window.location.href = '../../../index.php?page=home';</script>";
if (!$current_user->asAuthorizationToAccess("Manage Users"))
    echo "<script type=\"text/javascript\">window.location.href = '../../../index.php?page=home';</script>";
require_once("../functions/User/delete_user.func.php");
if (isset($_GET['id'])) {
    $id = Lib::Sanitize($_GET['id']);
    if (is_numeric($id))
        deleteUser($id);
}
$users = Lib::getUserList();
?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800"><i class="fas fa-fw fa-cog"></i>Delete User</h1>
    <div class="row">
        <div class="col-lg-7">
            <div class="p-5">
                <table class="table table-hover table-dark">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Login</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($users as $user) {
                            ?>
                            <tr>
                                <th scope="row"><?php echo $i; ?></th>
                                <td><?php echo $user->_name." ".$user->_lastname; ?></td>
                                <td><?php echo $user->_login; ?></td>
                                <td>
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-target-<?php print $user->getId(); ?>">Delete users </button>
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
