<?php
require_once dirname(__FILE__).'/App/app.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="icon.png">
    <title>Developers & Skills Demo Project</title>
</head>
<body class="my-4 body-bgcolor">

<div class="py-3 container-fluid bg-light">
    <?php include 'App/Views/intro.php'; ?>
    <a href="index.php"><i class="fas fa-home fa-2x"></i></a>
    <hr/>
    <?php include 'App/Views/form.php'; ?>
    <hr/>
    <div id="table-data">
    <?php include 'App/Views/table.php'; ?>
    </div>
</div>

<div id="modal-details"></div>

<script src="js/jquery.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/app.js"></script>
</body>
</html>