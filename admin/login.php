<?php require_once('includes/header.php'); ?>

<?php
if ($session->is_signed_in()) {
  redirect('index.php');
}
$message = '';

if (isset($_POST['submit'])) {
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);

  // Method to check database user
  $user = new User(new Database);
  $user_found = $user->verify_user($username, $password);

  if ($user_found) {
    $session->login($user_found);
    redirect('index.php');
  } else {
    $message = 'Your password or username are incorrect';
  }
} else {

  $username = '';
  $password = '';
}

?>

<!-- Navigation -->
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <?php include("includes/navigation.php"); ?>


</nav>
<br>
<br>


<div class="container">
  <div class="row">
    <div class="col-md-6 col-md-offset-2">
      <h4 class="bg-danger"><?php echo $message; ?></h4>
      <div class="panel panel-default">
        <div class="panel-heading">Login</div>
        <div class="panel-body">
          <form id="login-id" class="form-horizontal" role="form" method="post" action="">
            <div class="form-group">
              <label for="username" class="col-md-4 control-label">Username</label>
              <div class="col-md-6">

                <input id="email" type="username" class="form-control" name="username" value="<?php echo htmlentities($username); ?>">
              </div>
            </div>

            <div class="form-group">
              <label for="password" class="col-md-4 control-label">Password</label>
              <div class="col-md-6">

                <input id="password" type="password" class="form-control" name="password" value="<?php echo htmlentities($password); ?>">
              </div>
            </div>

            <div class="form-group">
              <div class="col-md-6 col-md-offset-4">
                <button name="submit" type="submit" class="btn btn-primary">
                  <i class="fa fa-btn fa-sign-in"></i> Login
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</div>