<?php
require_once("../functions/user.class.php");
session_start();
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    session_destroy();
    header("Location: ../index.php");
}
$user = new User($_SESSION['user_id']);

/*pages*/

$page = Lib::Sanitize($_GET['page']);
$pages = scandir("pages");
$content = "";

if (!empty($page) && in_array($page.".php", $pages))
    $content = 'pages/'.$page.".php";
else
    header("Location:index.php?page=home");
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
        <link rel="shortcut icon" href="../img/logo.png" type="image/png" />
        <link rel="apple-touch-icon" href="../img/logo.png"/>
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
