<?php include("includes/header.php"); ?>
<?php include("includes/init.php"); ?>
<?php include("includes/modal_library.php"); ?>
<?php if (!$session->is_signed_in()) {
  redirect("login.php");
} ?>

<?php

if (empty($_GET['id'])) {
  redirect('users.php');
}

$user = (new User(new Database))->find_by_id($_GET['id']);

if (isset($_POST['update'])) {

  if ($user) {

    $user->username = $_POST['username'];
    $user->password = $_POST['password'];
    $user->first_name = $_POST['first_name'];
    $user->last_name = $_POST['last_name'];

    if (empty($_FILES['user_image'])) {
      $user->save();
      redirect('users.php');
      $session->message('The user has been updated.');
    } else {
      $user->set_file($_FILES['user_image']);
      $user->upload_image();
      $user->save();
      redirect('users.php');
      $session->message('The user has been updated.');
    }
  }
}

?>



<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <?php include("includes/navigation.php"); ?>
  <?php include("includes/sidebar.php"); ?>
  <!-- /.navbar-collapse -->
</nav>

<div id="page-wrapper">
  <div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header">
          Edit User
        </h1>
        <div class="col-md-4 user-image-box">
          <a href="#" data-toggle="modal" data-target="#photo-modal"><img class="img-responsive" src="<?php echo $user->image_placeholder(); ?>" alt=""></a>
        </div>
        <form action="" method="post" enctype="multipart/form-data">
          <div class="col-md-8">
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" name="username" class="form-control" value="<?php echo $user->username; ?>">
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" name="password" class="form-control" value="<?php echo $user->password; ?>">
            </div>
            <div class="form-group">
              <label for="first_name">First Name</label>
              <input type="text" name="first_name" class="form-control" value="<?php echo $user->first_name; ?>">
            </div>
            <div class="form-group">
              <label for="last_name">Last Name</label>
              <input type="text" name="last_name" class="form-control" value="<?php echo $user->last_name; ?>">
            </div>
            <div class="form-group">
              <a id="user-id" class="btn btn-danger" href="delete_user.php?id=<?php echo $user->id; ?>">Delete User</a>
              <input type="submit" name="update" value="Update User" class="btn btn-success pull-right">
            </div>
          </div>
        </form>
      </div>
    </div>
    <!-- /.row -->

  </div>
  <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->


<?php include("includes/footer.php"); ?>