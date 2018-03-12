<?php
error_reporting(E_ALL ^ E_DEPRECATED);
session_start();
require_once '../../config.php';
class Query{
    var $opt;
    var $pdo;
    function __construct(){
        global $opt;
        global $pdo;
        $opt = [
        PDO::ATTR_PERSISTENT 		 => FALSE,
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => true,
        ];
        $pdo = new PDO(DB_DRIVER.":host=".DB_SERVER.";dbname=".DB_NAME, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, $opt);
    }
    private function url_exists($url) {
        if (!$fp = curl_init($url)){
            return false;
        }else{
        return true;
        }
    }
    private function xss_cleaner($input_str) {
        $return_str = str_replace( array('<',';','|','&','>',"'",'"',')','('), array('&lt;','&#58;','&#124;','&#38;','&gt;','&apos;','&#x22;','&#x29;','&#x28;'), $input_str );
        $return_str = str_ireplace( '%3Cscript', '', $return_str );
        return $return_str;
    }
    function getIP(){
        if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from shared internet
        {
          $ip=$_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check if ip is passed from proxy
        {
          $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
          $ip=$_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
    function getUserAgent(){
        return $_SERVER['HTTP_USER_AGENT'];
    }
    
    function addUser($firstname,$lastname,$username,$email,$password){
        global $pdo;
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        
        $query = $pdo->prepare("INSERT INTO members(firstname,lastname,username,email,password_hash) VALUES(:firstname,:lastname,:username,:email,:password_hash)");
        
        $query->bindParam(":firstname",$firstname,PDO::PARAM_STR);
        $query->bindParam(":lastname",$lastname,PDO::PARAM_STR);
        $query->bindParam(":username",$username,PDO::PARAM_STR);
        $query->bindParam(":email",$email,PDO::PARAM_STR);
        $query->bindParam(":password_hash",$password_hash,PDO::PARAM_STR);
        try{
            $query->execute();
            $id = $pdo->lastInsertId();
            return $id;
        }catch(PDOException $e){
            $pdo->rollback();
            return -1;
        }
    }
    function addPost($author_id,$title,$text){
        global $pdo;
        $date_time = date("D-M-Y h:i:sa");
        $query = $pdo->prepare("INSERT INTO posts(author_id,title,text,datetime) VALUES(:author_id,:title,:text,:datetime)");
        $query->bindParam(":author_id",$author_id,PDO::PARAM_INT);
        $query->bindParam(":title",$title,PDO::PARAM_STR);
        $query->bindParam(":text",$text,PDO::PARAM_STR);
        $query->bindParam(":datetime",$date_time,PDO::PARAM_STR);
        try{
            $query->execute();
            $id = $pdo->lastInsertId();
            return $id;
        }catch(PDOException $e){
            $pdo->rollback();
            return -1;
        }
    }
    function addComment($post_id,$author_id,$comment){
        global $pdo;
        $date_time = date("D-M-Y h:i:sa");
        $query = $pdo->prepare("INSERT INTO comments(post_id,author_id,comment,datetime) VALUES(:post_id,:author_id,:comment,:datetime)");
        $query->bindParam(":post_id",$post_id,PDO::PARAM_INT);
        $query->bindParam(":author_id",$author_id,PDO::PARAM_INT);
        $query->bindParam(":comment",$comment,PDO::PARAM_STR);
        $query->bindParam(":datetime",$date_time,PDO::PARAM_STR);
        try{
            $query->execute();
            $id = $pdo->lastInsertId();
            return $id;
        }catch(PDOException $e){
            $pdo->rollback();
            return -1;
        }
    }
    
    function verifyUser($identity,$password){
        global $pdo;
        $query = $pdo->prepare("SELECT id,password_hash from members WHERE username=:identity OR email=:identity");
        $query->bindParam(":identity",$identity,PDO::PARAM_STR);
        try{
            $query->execute();
            $password_hash = ($query->fetch())->password;
            $id = $pdo->lastInsertId();
            if(password_verify($password, $password_hash))
                return $id;
            else
                return -2;
        }catch(PDOException $e){
            $pdo->rollback();
            return -1;
        }
    }
}