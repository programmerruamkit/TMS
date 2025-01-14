<?php 
if($_SESSION['LOGIN_STATUS'] == ''){
    include_once 'pages/login.php';
}else{
    include_once 'pages/logout.php';
} 
?>