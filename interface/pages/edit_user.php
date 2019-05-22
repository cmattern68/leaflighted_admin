<?php
if (preg_match("/page/i", $_SERVER['REQUEST_URI']) && !preg_match("/index.php/i", $_SERVER['REQUEST_URI']))
    echo "<script type=\"text/javascript\">window.location.href = 'index.php?page=home';</script>";
require_once("../functions/edit_user.func.php");
if (isset($_GET['id']) && isset($_GET['rank'])) {
    $id = Lib::Sanitize($_GET['id']);
    $rank = Lib::Sanitize($_GET['rank']);
    if (is_numeric($id) && is_numeric($rank) && $id > 0)
        changeUserRank($id, $rank);
}
$users = getUserList();
?>
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
                            <?php
                            if ($user->getGrade()) {
                                ?>
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-target-<?php print $user->getId(); ?>">Set as users </button>
                                <?php
                            } else {
                                ?>
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-target-<?php print $user->getId(); ?>">Set as admin</button>
                                <?php
                            }
                            ?>
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
<?php
foreach ($users as $user) {
?>
    <div class="modal fade" id="modal-target-<?php print $user->getId(); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Set as <?php echo $user->getGrade() ? "users" : "admin"; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Do you really want to make <?php
                    $rank = $user->getGrade() ? "users" : "admin";
                    $msg = $user->_name." ".$user->_lastname." as ".$rank;
                    echo $msg;
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <form method="POST" action="">
                        <a href="index.php?page=edit_user&id=<?php echo $user->getId(); ?>&rank=<?php echo $user->getGrade() ? 0 : 1; ?>" class="btn btn-primary btn-user btn-block">Save changes</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>
