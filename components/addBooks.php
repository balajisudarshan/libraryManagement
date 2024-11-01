<?php
    session_start();
    if($_SESSION['username']== null) {
        die("Error");
    }
?>
