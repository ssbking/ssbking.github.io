<?php
session_start();

require 'config/db.php';
require_once 'emailController.php';

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
if(empty($username)){
    $errors['username'] = "Username Required";
}

if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $errors['email'] = "email address is invalid";
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


sendVerificationEmail($email, $token);

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

//user verification function
function verifyUser($token){
    global $conn ;
    $sql = "SELECT * FROM  user WHERE token='$token' LIMIT 1"; 
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){
$user = mysqli_fetch_assoc($result);
$update_query = "UPDATE user SET verified=1 WHERE token='$token'";


if(mysqli_query($conn, $update_query)){
    //log user in
     // login success user 
     $_SESSION['id'] = $user['id'];
     $_SESSION['username'] = $user['username'];
     $_SESSION['email'] = $user['email'];
     $_SESSION['verified'] = 1;
     
     // falsh message
     $_SESSION['message'] = "your email address was successfully verified!!";
     $_SESSION['alert-class'] = 'alert-success';
     header('location: index.php');
     exit();
}
    }else{
        echo 'user not found';
    }
}

//if user clickes on the forget- password link

if(isset($_POST['forget-password'])){
    $email = $_POST['email'];
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors['email'] = "email address is invalid";
    }
    
    if(empty($email)){
        $errors['email'] = "email Required";
    }

    if (count($errors) == 0 ) {
        $sql = "SELECT * FROM user WHERE email=? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $token = $user['token'];
        sendPasswordResetLink($email, $token);
        header('location: password_message.php');
        exit(0);
    }
    
} 

if(isset($_POST['reset-password-btn'])){
    $password = $_POST['password'];
    $passwordConf = $_POST['passwordConf'];

    if(empty($password) || empty($passwordConf)){
        $errors['password'] = "new password Required";
    }
    
    if($password !== $passwordConf){
        $errors['passwordConf'] = "password dosent match.";
    }

    $password = password_hash($password, PASSWORD_DEFAULT);
    $email = $_SESSION['email'];


    if(count($errors) == 0 ){
        $sql = "UPDATE user SET password='$password' WHERE email='$email'";
        $result = mysqli_query($conn, $sql);
            if($result){
                header('location: login.php');
                exit(0);
            }
    }

}




function resetPassword($token){
    global $conn;
    $sql = "SELECT * FROM user WHERE token='$token' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
    $_SESSION['email'] = $user['email'];
    header('location: reset_password.php');
    exit(0);

}