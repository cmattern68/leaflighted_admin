<?php
if (preg_match("/page/i", $_SERVER['REQUEST_URI']) && !preg_match("/index.php/i", $_SERVER['REQUEST_URI']))
    echo "<script type=\"text/javascript\">window.location.href = 'index.php?page=home';</script>";
if (!$current_user->getGrade())
    header("Location:index.php?page=home");
require_once("../functions/generate_oauth_token.func.php");
if (isset($_GET['id'])) {
    $id = Lib::Sanitize($_GET['id']);
    if (is_numeric($id) && $id > 0)
        generateNewToken($id);
}
$users = getUserForTokList();
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
                        <th scope="col">Number of Token</th>
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
                            <td><?php echo count($user->getTokens()); ?></td>
                            <td>
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-target-<?php print $user->getId(); ?>">Generate token </button>
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
                    <h5 class="modal-title" id="exampleModalLabel">Generate new token</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Do you really want to generate a new token for <?php
                    echo $user->_name." ".$user->_lastname;
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <form method="POST" action="">
                        <a href="index.php?page=generate_auth_token&id=<?php echo $user->getId(); ?>" class="btn btn-primary btn-user btn-block">Save changes</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>
