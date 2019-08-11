<?php include("includes/header.php"); ?>

<?php require_once('admin/includes/init.php'); ?>

<?php
$comment = new Comment(new Database);
$photo = new Photo(new Database);
$user = new User(new Database);

if (empty($_GET['id'])) {
    redirect('index.php');
}

$photo = $photo->find_by_id($_GET['id']);
$user = $user->find_by_id($photo->user_id);
$message = "";

if (isset($_POST['submit'])) {
    $author = trim($_POST['author']);
    $body = trim($_POST['body']);

    $new_comment = $comment->create_comment($photo->id, $author, $body);

    if ($new_comment && $new_comment->save()) {

        redirect("photo.php?id={$photo->id}");
    } else {
        $message = "There was some problem...";
    }
} else {
    $author = "";
    $body = "";
}

$comments = $comment->find_comments($photo->id);

?>

<div class="row">

    <!-- Blog Post Content Column -->
    <div class="col-lg-12">

        <!-- Blog Post -->

        <!-- Title -->
        <h1 class="mt-5 text-white"><?php echo $photo->title; ?></h1>

        <!-- Author -->
        <p class="lead text-white">by <?php echo $user->username; ?></p>

        <!-- Date/Time -->
        <p class="text-white">Posted on <?php echo date('D j. M Y h:i:s', strtotime($photo->created_at)); ?></p>

        <!-- Preview Image -->
        <img class="img-fluid mb-4" src="admin/<?php echo $photo->picture_path(); ?>" alt="">

        <br>

        <!-- Post Content -->
        <p class="lead"><?php echo $photo->caption; ?></p>
        <p><?php echo $photo->description; ?></p>

        <br>

        <!-- Blog Comments -->

        <!-- Comments Form -->
        <div class="card card-body">
            <h4>Leave a Comment:</h4>
            <form role="form" method="post">
                <div class="form-group">
                    <input type="text" name="author" class="form-control" placeholder="Author...">
                </div>
                <div class="form-group">
                    <textarea name="body" class="form-control" rows="3" placeholder="Type your comment..."></textarea>
                </div>
                <button type="submit" name="submit" class="btn btn-dark">Submit</button>
            </form>
        </div>

        <br>

        <!-- Posted Comments -->

        <!-- Comment -->
        <?php if (count($comments) > 0) : ?>
            <?php foreach ($comments as $comment) : ?>
                <div class="card border p-3">
                    <div class="card-body">
                        <a class="pull-left" href="#">
                            <img class="media-object mr-3" src="image/avatar.png" alt="" style="width:64px">
                        </a>

                        <h4 class="media-heading"><?php echo $comment->author ?>
                            <small>Posted on <?php echo date('D j. M Y h:i:s', strtotime($comment->created_at)) ?></small>
                        </h4>
                        <?php echo $comment->body ?>
                    </div>
                </div>
                <br>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<!-- /.row -->
<?php include("includes/footer.php"); ?>