<?php
if (preg_match("/pages/i", $_SERVER['REQUEST_URI']))
    echo "<script type=\"text/javascript\">window.location.href = '../index.php?page=home';</script>";
if (!$current_user->getGrade())
    header("Location:index.php?page=home");
require_once("../functions/Roles/add_roles.func.php");
$sections = getSections();
?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800"><i class="fas fa-fw fa-cog"></i>Add new roles</h1>
    <div class="row">
        <div class="col-lg-7">
            <div class="p-5">
                <form method="POST" action="">
                    <?php
                        if (isset($_POST['submit']))
                            createRoles();
                    ?>
                    <div class="form-group">
                        <input type="text" class="form-control" id="label" name="label" placeholder="Roles Label">
                    </div>
                    <div class="form-group">
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
                                            <td><input type="checkbox" data-toggle="toggle" data-onstyle="success" name="action-<?php echo Lib::Sanitize($section); ?>" value="on"></td>
                                        </tr>
                                <?php
                            }
                        ?>
                            </tbody>
                        </table>
                    </div>
                    <input type="submit" id="submit" name="submit" value="Add roles" class="btn btn-primary btn-user btn-block">
                </form>
            </div>
        </div>
    </div>
</div>
