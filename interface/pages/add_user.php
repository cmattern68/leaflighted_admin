<?php
if (preg_match("/page/i", $_SERVER['REQUEST_URI']) && !preg_match("/index.php/i", $_SERVER['REQUEST_URI']))
    echo "<script type=\"text/javascript\">window.location.href = 'index.php?page=home';</script>";
if (!$current_user->getGrade())
    header("Location:index.php?page=home");
require_once("../functions/register.func.php");
?>

<div class="row">
    <div class="col-lg-7">
        <div class="p-5">
            <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Register new user</h1>
            </div>
            <form class="user" method="POST" action="">
                <?php
                if (isset($_POST['submit']))
                    initRegisterProcedure();
                ?>
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <input type="text" class="form-control form-control-user" id="name" name="name" placeholder="First Name">
                    </div>
                    <div class="col-sm-6">
                        <input type="text" class="form-control form-control-user" id="lastname" name="lastname" placeholder="Last Name">
                    </div>
                </div>
                <div class="form-group">
                    <input type="email" class="form-control form-control-user" id="email" name="email" placeholder="Email Address">
                </div>
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password">
                    </div>
                    <div class="col-sm-6">
                        <input type="password" class="form-control form-control-user" id="repeatpassword" name="repeatpassword" placeholder="Repeat Password">
                    </div>
                </div>
                <input type="submit" id="submit" name="submit" value="Register Account" class="btn btn-primary btn-user btn-block">
            </form>
        </div>
    </div>
</div>
