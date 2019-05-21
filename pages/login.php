<?php
if (preg_match("/pages/i", $_SERVER['REQUEST_URI']))
    header("Location: ../index.php");

include("functions/login.func.php");
if (isset($_SESSION['user_id']))
    checkValideData($_SESSION['user_id']);
?>
<div class="row justify-content-center">
    <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-6 d-none d-lg-block bg-login-image login-img"></div>
                    <div class="col-lg-6">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4 text-dark-mode">Leaflighted Admin Panel</h1>
                            </div>
                            <form class="user" method="POST">
                                <?php
                                    if (isset($_POST['submit']))
                                        initLogin();
                                ?>
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user form-dark-mode" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter Email Address...">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user form-dark-mode" id="password" name="password" placeholder="Password">
                                </div>
                                <input type="submit" value="Login" class="btn btn-success btn-user btn-block" name="submit">
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small black-a" href="">Forgot Password?</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
