<?php require_once 'controllers/authController.php'; 

//user verification 
if (isset($_GET['token'])){
    $token = $_GET['token'];
    verifyUser($token);
}
//reset password
if (isset($_GET['password-token'])){
    $passwordToken = $_GET['password-token'];
    resetPassword($passwordToken);
}

if(!isset($_SESSION['id'])){
    header('location: login.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta http-equiv="Cache-Control" content="no-cache">
    <!-- bootstrap 4 css -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<link rel="stylesheet" href="style.css">
    <title>Log-In</title>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-4 offset-md-4 form-div login">
      
        <?php if(isset($_SESSION['message'])): ?>


      <div class="alert <?php echo $_SESSION['alert-class']; ?>">
      <?php 
      echo $_SESSION['message'];
      unset ($_SESSION['message']);
      unset ($_SESSION['alert-class']);
      ?>
      </div>
        <?php endif;?>

<h3>Welcome, <?php echo $_SESSION['username']; ?></h3>

<a href="index.php?logout=1" class="logout">logout</a>


<?php if(!$_SESSION['verified']): ?>
<div class="alert alert-warning">
You need to verify accout ,please click the link sent to ur email to verify yourself!
thank you
<strong><?php echo $_SESSION['email']; ?></strong>
</div>
<?php endif; ?>

<?php if($_SESSION['verified']): ?>
<div>
<button class="btn btn-block btn-lg btn-primary">I Am Verifyed</button>
</div>
<?php endif ; ?>
        </div>
    </div>
</div>


</body>
</html>