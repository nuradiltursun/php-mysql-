<?php 
    session_start();

    if(!isset($_SESSION['username']) || $_SESSION['role']!='admin'){
        header('location:index.php');
    }
?>

<h1> username :  <?= $_SESSION['username'];  ?> </h1>
<h2> role :  <?= $_SESSION['role'];  ?> </h2>
<a href="logout.php">logout</a>