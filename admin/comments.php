<?php include("includes/header.php"); ?>
<?php if (!$session->is_signed_in()) {
    redirect("login.php");
} ?>

<?php $comments = (new Comment(new Database))->find_all(); ?>

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
                    COMMENTS
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
                                <th>Author</th>
                                <th>Body</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($comments as $comment) : ?>
                                <tr>
                                    <td><?php echo $comment->id; ?></td>
                                    <td><?php echo $comment->author; ?>
                                    <td><?php echo $comment->body; ?></td>
                                    <td><a class="btn btn-success" href="edit_comment.php?id=<?php echo $comment->id ?>">Edit</a></td>
                                    <td><a class="btn btn-danger delete_button" href="delete_comment.php?id=<?php echo $comment->id; ?>">Delete</a></td>
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