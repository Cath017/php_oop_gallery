<?php require('init.php');

$user = new User(new Database);
$photo = new Photo(new Database);

if (isset($_POST['image_name'])) {
  $user->ajax_save_user_image($_POST['image_name'], $_POST['user_id']);
}

if (isset($_POST['photo_id'])) {
  $photo->display_image_info($_POST['photo_id']);
}
