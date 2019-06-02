<?php
if (preg_match("/pages/i", $_SERVER['REQUEST_URI']))
    echo "<script type=\"text/javascript\">window.location.href = '../../../index.php?page=home';</script>";
if (!$current_user->asAuthorizationToAccess("Manage Users"))
    echo "<script type=\"text/javascript\">window.location.href = '../../../index.php?page=home';</script>";
require_once("../functions/User/delete_user_roles.func.php");
$users = Lib::getUserList();
?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800"><i class="fas fa-fw fa-cog"></i>Delete User Right</h1>
    <div class="row">
        <div class="col-lg-7">
            <div class="p-5">
                <form method="POST" action="">
                    <?php
                    if (isset($_POST['submit']))
                        deleteUserRank();
                    ?>
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
                                $roles = $user->getRoles();
                                $user_roles = array();
                                $pot_roles = Lib::getRolesList();
                                $total_roles = array();
                                $final_roles = array();
                                $j = 0;
                                foreach ($pot_roles as $role) {
                                    $total_roles[$j]['name'] = Lib::Sanitize($role['name']);
                                    $total_roles[$j]['uuid'] = Lib::Sanitize($role['uuid']);
                                    ++$j;
                                }
                                foreach ($roles as $role)
                                    $user_roles[$role->_name] = $role->_name;
                                foreach ($total_roles as $key => $value)
                                    if (in_array($value['name'], $user_roles))
                                        $final_roles[] = $value;
                            ?>
                                <tr>
                                    <th scope="row"><?php echo $i; ?></th>
                                    <td><?php echo $user->_name." ".$user->_lastname; ?></td>
                                    <td><?php echo $user->_login; ?></td>
                                    <td>
                                        <select name="roles[]" class="custom-select set-roles-<?php echo $user->getId(); ?>" size="3" multiple>
                                            <?php
                                            if (!empty($final_roles)) {
                                                foreach ($final_roles as $key => $value) {
                                                    ?>
                                                            <option value="<?php echo Lib::Sanitize($user->getUuid())."-".Lib::Sanitize($value['uuid']); ?>"><?php echo Lib::Sanitize($value['name']); ?></option>
                                                            <?php
                                                        }
                                            } else {
                                                ?>
                                                    <option>No roles available.</option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <?php
                                ++$i;
                                }
                            ?>
                        </tbody>
                    </table>
                <input name="submit" type="submit" class="btn btn-success" value="Save">
                </form>
            </div>
        </div>
    </div>
</div>
