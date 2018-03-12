<?php
error_reporting(E_ALL ^ E_DEPRECATED);
ini_set("display_errors",1);
require_once '../includes/query.php';

$q = new Query();
if(isset($_POST)){
    $id = $q->addUser($_POST['firstname'],$_POST['lastname'],$_POST['username'],$_POST['email'],$_POST['password']);
    if($id == -1){
        echo 'Error in Signing Up';
        exit;
    }else{
        $_SESSION['id'] = $id;
        header("Location: index.php");
    }
}else{
    echo 'Access Violation';
}