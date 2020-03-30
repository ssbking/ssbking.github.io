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
        <form action="login.php" method="post">
        <h3 class="text-center">Log-In</h3>

           
        <?php if(count($errors) > 0): ?>
            <div class="alert alert-danger">
            <?php foreach($errors as $error): ?>
             <li><?php echo $error; ?></li>
             <?php endforeach ; ?>
            </div>
            <?php endif; ?>

            <div class="form-group">
            <lable  for="username">Username or email</lable>
            <input type="text" name="username" value="<?php echo $username; ?>" class="form-control form-control-lg">
            </div>
           
            <div class="form-group">
            <lable  for="password">Password</lable>
            <input type="password" name="password" class="form-control form-control-lg">
            </div>
           

            <div class="form-group">
            <button type="submit" name="login-btn" class="btn btn-primary btn-block btn-lg">Log-In</button>
            </div>
<p class="text-center">Not yet a member? <a href="signup.php">Sign Up</a></p>
        </form>
        </div>
    </div>
</div>


</body>
</html>