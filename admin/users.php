<?php include("includes/header.php"); ?>
<?php if (!$session->is_signed_in()) {
    redirect("login.php");
} ?>

<?php
$users = (new User(new Database))->find_all();
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
                    USERS <a class="btn btn-primary pull-right" href="add_user.php"> Add User</a>
                </h1>
                <?php if ($message) : ?>
                    <div id="msg" class="row">
                        <div class="col-md-6">
                            <div class="alert alert-success"><?php echo $message; ?></div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="col-md-12">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Photo</th>
                                <th>Username</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user) : ?>
                                <tr>
                                    <td><?php echo $user->id; ?></td>
                                    <td><img class="image-user" src="<?php echo $user->image_placeholder(); ?>" alt=""></td>
                                    <td><?php echo $user->username; ?>
                                        <div class="action_links">
                                            <br>
                                            <a class="btn btn-danger delete_button" href="delete_user.php?id=<?php echo $user->id; ?>">Delete</a>
                                            <a class="btn btn-success" href="edit_user.php?id=<?php echo $user->id ?>">Edit</a>
                                        </div>
                                    </td>
                                    <td><?php echo $user->first_name; ?></td>
                                    <td><?php echo $user->last_name; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->

<?php include("includes/footer.php"); ?>