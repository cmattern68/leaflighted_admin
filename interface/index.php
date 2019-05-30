<?php
require_once("../functions/User/user.class.php");
require_once("../functions/Rooter/rooter.class.php");

session_start();
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    session_destroy();
    header("Location: ../index.php");
}
$current_user = new User($_SESSION['user_id']);
if (isset($_COOKIE['oauth_tok'])) {
    $token = new Token(Lib::Sanitize($_COOKIE['oauth_tok']));
    if ($token->getValue() == null || $token->getUserAssociateId() !== $current_user->getId() || $token->getValidation() == false)
        header("Location: ../index.php");
    else {
        $objArr = $current_user->getTokens();
        $isFound = false;
        foreach ($objArr as $obj) {
            if ($token->getValue() === $obj->getValue()) {
                $isFound = true;
                break;
            }
        }
        if (!$isFound)
            header("Location: ../index.php");
    }
} else
    header("Location: ../index.php");

/*pages*/
$rooter = null;
if (isset($_GET['page']))
    $rooter = new Rooter($_GET['page']);
else
    header("Location:index.php?page=home");
$content = $rooter->getContent();
?>
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Leaflighted - Dashboard</title>
        <!-- Custom fonts for this template-->
        <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
        <!-- Custom styles for this template-->
        <link href="../css/sb-admin-2.min.css" rel="stylesheet">
        <link href="../css/style.css" rel="stylesheet">
        <link rel="shortcut icon" href="../img/logo.png" type="image/png" />
        <link rel="apple-touch-icon" href="../img/logo.png"/>
        <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.4.0/css/bootstrap4-toggle.min.css" rel="stylesheet">
        <!--JavaScript-->
        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
        <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.4.0/js/bootstrap4-toggle.min.js"></script>
        <script src="../js/jquery.repeatable.js"></script>
    </head>
    <body id="page-top">
        <div id="wrapper">
            <?php include("body/header.php"); ?>
                <div id="content-wrapper" class="d-flex flex-column">
                    <div id="content">
                        <?php include("body/navbar.php"); ?>
                        <!--PAGE CONTENT-->
                        <?php include($content); ?>
                    </div>
                    <?php include("body/footer.php"); ?>
                </div>
            </div>
            <!-- Bootstrap core JavaScript-->
            <script src="../vendor/jquery/jquery.min.js"></script>
            <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
            <!-- Core plugin JavaScript-->
            <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
            <!-- Custom scripts for all pages-->
            <script src="../js/sb-admin-2.min.js"></script>
            <!-- Page level plugins -->
            <script src="../vendor/chart.js/Chart.min.js"></script>
            <!-- Page level custom scripts -->
            <script src="../js/demo/chart-area-demo.js"></script>
            <script src="../js/demo/chart-pie-demo.js"></script>
        </body>
    </html>
