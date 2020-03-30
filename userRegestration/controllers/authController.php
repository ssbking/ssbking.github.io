<?php
session_start();

require 'config/db.php';

$errors = array();
$username = "";
$email = "";


// if user clicked signup button

if (isset($_POST['signup-btn'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordConf = $_POST['passwordConf'];

// validation

if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $errors['email'] = "email address is invalid";
}

if(empty($username)){
    $errors['username'] = "Username Required";
}
if(empty($email)){
    $errors['email'] = "email Required";
}

if(empty($password)){
    $errors['password'] = "password Required";
}

if($password !== $passwordConf){
    $errors['passwordConf'] = "password dosent match.";
}

$emailQuery = "SELECT * FROM user WHERE email=? LIMIT 1";
$stmt = $conn->prepare($emailQuery);
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();
$userCount = $result->num_rows;
$stmt->close();

if($userCount > 0){
    $errors['email'] = "email alredy exists";
}

if(count($errors) === 0){
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $token = bin2hex(random_bytes(50));
    $verified = false ; 
    
    // $sql ="INSERT INTO user (username, email, verified, token, password) VALUES(?, ?, ?, ?, ?)"; 
    $stmt = $conn->prepare("INSERT INTO user SET username=?, email=?, verified=?, token=?, password=?");
    $stmt->bind_param('ssbss', $username, $email, $verified, $token, $hash);
    if($stmt->execute()){
// login user automaticlly
$user_id = $conn->insert_id;
$_SESSION['id'] = $user_id;
$_SESSION['username'] = $username;
$_SESSION['email'] = $email;
$_SESSION['verified'] = $verified;

// falsh message
$_SESSION['message'] = "you have logged in";
$_SESSION['alert-class'] = 'alert-success';
header('location: index.php');
exit();


    } else {
        $errors['db_error']="Database error : failed to register";
    }
    
}

}


// if user clickes log-in button.
if (isset($_POST['login-btn'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
    // validation


    if(empty($username)){
        $errors['username'] = "Username Required";
    }


    if(empty($password)){
        $errors['password'] = "password Required";
    }

    if (count($errors) === 0){
 
        $sql = "SELECT * FROM user WHERE email=? or username=? limit 1;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss',$username , $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
    
        // https://www.sitepoint.com/hashing-passwords-php-5-5-password-hashing-api/
        if(password_verify($password, $user['password'])){
        // login success user 
        $_SESSION['id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['verified'] = $user['verified'];
        
        // falsh message
        $_SESSION['message'] = "you have logged in";
        $_SESSION['alert-class'] = 'alert-success';
        header('location: index.php');
        exit();
            }else{
                $errors['login-fail'] = "Wrong creadentials";
            }
    }
}

//logout function
if(isset($_GET['logout'])){
    session_destroy();
    unset($_SESSION['id']);
    unset($_SESSION['username']);
    unset($_SESSION['email']);
    unset($_SESSION['verified']);
    header('location: login.php');
    exit();
}