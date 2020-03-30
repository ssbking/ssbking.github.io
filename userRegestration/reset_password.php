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
    <title>Log-In</title>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-4 offset-md-4 form-div login">
        <form action="reset_password.php" method="post">
        <h3 class="text-center">Reset your password</h3>

           
        <?php if(count($errors) > 0): ?>
            <div class="alert alert-danger">
            <?php foreach($errors as $error): ?>
             <li><?php echo $error; ?></li>
             <?php endforeach ; ?>
            </div>
            <?php endif; ?>

            <div class="form-group">
            <lable  for="password">password</lable>
            <input type="password" name="password" value="<?php echo $username; ?>" class="form-control form-control-lg">
            </div>
           
            <div class="form-group">
            <lable  for="password">Conform Password</lable>
            <input type="password" name="passwordConf" class="form-control form-control-lg">
            </div>
           

            <div class="form-group">
            <button type="submit" name="reset-password-btn" class="btn btn-primary btn-block btn-lg">
            Reset Password    
            </button>
            </div>
            
        </form>
        </div>
    </div>
</div>


</body>
</html>