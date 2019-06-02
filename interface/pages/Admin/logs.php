<?php
if (preg_match("/pages/i", $_SERVER['REQUEST_URI']))
    echo "<script type=\"text/javascript\">window.location.href = '../../index.php?page=home';</script>";
if (!$current_user->asAuthorizationToAccess("Consult Logs"))
    echo "<script type=\"text/javascript\">window.location.href = '../../index.php?page=home';</script>";
require_once("../functions/Logs/logs.func.php");
$logs = generateLogObjArray();
?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800"><i class="fas fa-fw fa-cog"></i>Logs</h1>
    <div class="row">
        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-target-flush-log">Flush logs</button>
        <table class="table table-hover table-dark">
            <thead>
                <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Ip</th>
                    <th scope="col">Location</th>
                    <th scope="col">Message</th>
                    <th scope="col">Success</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if (empty($logs)) {
                        ?>
                        <tr class="table-active">
                            <th colspan="5">No log coverage.</th>
                        </tr>
                        <?php
                    } else {
                        foreach ($logs as $log) {
                            ?>
                                <tr class="table-<?php echo $log->_level; ?>">
                                    <th scope="col"><?php echo $log->_date; ?></th>
                                    <td scope="col"><?php echo $log->getIp(); ?></th>
                                    <td scope="col"><?php echo $log->getLocation(); ?></th>
                                    <td scope="col"><?php echo $log->_message; ?></th>
                                    <td scope="col"><?php echo $log->_success ? "True" : "False"; ?></th>
                                </tr>
                            <?php
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade" id="modal-target-flush-log" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Flush logs</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Do you really want to flush the logs ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <form method="POST" action="">
                    <?php
                    if (isset($_POST['submit']))
                        flushLogs();
                    ?>
                    <input type="submit" name="submit" value="Flush" class="btn btn-danger" value="Flush logs">
                </form>
            </div>
        </div>
    </div>
</div>
