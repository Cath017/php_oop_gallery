<?php include("includes/header.php"); ?>

<?php if (!$session->is_signed_in()) {
  redirect("login.php");
} ?>

<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <?php include("includes/navigation.php"); ?>
  <?php include("includes/sidebar.php"); ?>
  <!-- /.navbar-collapse -->
</nav>

<div id="page-wrapper">

  <?php include("includes/content.php"); ?>

</div>
<!-- /#page-wrapper -->

<?php include("includes/footer.php"); ?>