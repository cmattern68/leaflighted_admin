<?php
if (preg_match("/pages/i", $_SERVER['REQUEST_URI']))
    echo "<script type=\"text/javascript\">window.location.href = '../index.php?page=home';</script>";
if (!$current_user->getGrade())
    header("Location:index.php?page=home");
require_once("../functions/Token/delete_oauth_token.func.php");
if (isset($_GET['id'])) {
    $id = Lib::Sanitize($_GET['id']);
    if (is_numeric($id))
        deleteToken($id);
}
$users = getUserForTokList();
$midNbUser = count($users) / 2;
?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800"><i class="fas fa-fw fa-cog"></i>Delete Authentification Token</h1>
    <div class="row">
        <div class="col-lg-6">
            <?php
            for ($i = 0; $i < $midNbUser; ++$i) {
                ?>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary"><?php echo $users[$i]->_name." ".$users[$i]->_lastname; ?></h6>
                    </div>
                    <div class="card-body">
                        <?php
                        if (empty($users[$i]->getTokens()))
                            echo "No token generated.";
                        else {
                        ?>
                        <table class="table table-hover table-dark">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Value</th>
                                    <th scope="col">Validate</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $nb = 1;
                                $tokens = $users[$i]->getTokens();
                                foreach ($tokens as $obj) {

                                ?>
                                <tr>
                                    <th scope="row"><?php echo $nb; ?></th>
                                    <td title="<?php echo $obj->getValue(); ?>"><?php echo substr($obj->getValue(), 0, 10)."..."; ?></td>
                                    <td><?php echo $obj->getValidation() ? "Validate" : "Not Validate"; ?></td>
                                    <td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-target-<?php print $obj->getId(); ?>">Delete Token</button></td>
                                </tr>
                                <?php
                                ++$nb;
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="col-lg-6">
            <?php
            for ($i = $midNbUser; $i < $midNbUser * 2; ++$i) {
                ?>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary"><?php echo $users[$i]->_name." ".$users[$i]->_lastname; ?></h6>
                    </div>
                    <div class="card-body">
                        <?php
                        if (empty($users[$i]->getTokens()))
                            echo "No token generated.";
                        else {
                        ?>
                        <table class="table table-hover table-dark">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Value</th>
                                    <th scope="col">Validate</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $nb = 1;
                                $tokens = $users[$i]->getTokens();
                                foreach ($tokens as $obj) {

                                ?>
                                <tr>
                                    <th scope="row"><?php echo $nb; ?></th>
                                    <td title="<?php echo $obj->getValue(); ?>"><?php echo substr($obj->getValue(), 0, 10)."..."; ?></td>
                                    <td><?php echo $obj->getValidation() ? "Validate" : "Not Validate"; ?></td>
                                    <td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-target-<?php print $obj->getId(); ?>">Delete Token</button></td>
                                </tr>
                                <?php
                                ++$nb;
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>
<?php
foreach ($users as $user) {
    $nb = 1;
    $tokens = $user->getTokens();
    foreach ($tokens as $obj) {
?>
    <div class="modal fade" id="modal-target-<?php print $obj->getId(); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Token</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Do you really want to delete <?php echo $user->_name." ".$user->_lastname; ?> token number <?php echo $nb; ?> ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <form method="POST" action="">
                        <a href="index.php?page=delete_auth_token&id=<?php echo $obj->getId(); ?>" class="btn btn-primary btn-user btn-block">Save changes</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
    ++$nb;
    }
}
?>
