<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

?>
<?php
session_start();
session_destroy();
header("Location: Homemade/signin.html"); // Redirect to login page
exit();
?>
