<?php require_once 'controllers/authController.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta http-equiv="Cache-Control" content="no-cache">
    <!-- bootstrap 4 css -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<link rel="stylesheet" href="style.css">
    <title>Forget-Password</title>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-4 offset-md-4 form-div login">
        <form action="forget_password.php" method="post">
        <h3 class="text-center">Recover your password</h3>

        <p>Please enter your email address you used to sign-up on this site and 
           we will assist you in recovering your password.
        </p>   
        <?php if(count($errors) > 0): ?>
            <div class="alert alert-danger">
            <?php foreach($errors as $error): ?>
             <li><?php echo $error; ?></li>
             <?php endforeach ; ?>
            </div>
            <?php endif; ?>

            <div class="form-group">
           
            <input type="email" name="email" class="form-control form-control-lg">
            </div>
           
           

            <div class="form-group">
            <button type="submit" name="forget-password" class="btn btn-primary btn-block btn-lg">recover your password</button>
            </div>
          
        </form>
        </div>
    </div>
</div>


</body>
</html>