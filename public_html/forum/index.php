<?php
require_once '../includes/query.php';
$q = new Query();
if(isset($_POST)){
    $id = $q->verifyUser($_POST['identity'],$_POST['password']);
    if($id == -1){
        echo 'Error Occured';
        exit;
    }else if($id == -2){
        echo 'Wrong username/password';
        exit;
    }
    $_SESSION['id'] = $id;
    header("Location: index.php");
}else if(isset($_SESSION['id'])){
    echo 'Welcome User #'.$_SESSION['id'];
}else{
    echo 'Error - ID not set';
    exit;
}