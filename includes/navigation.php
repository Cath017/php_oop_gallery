    <nav class="navbar navbar-expand-lg" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand" href="#">PHP OOP GALLERY</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="navbar-nav mr-auto">
                    <li>
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <?php if ($session->is_signed_in()) : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="admin">Admin</a>
                        </li>
                    <?php endif; ?>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <?php if (!$session->is_signed_in()) : ?>
                        <li class="nav-item"><a class="nav-link" href="admin/login.php">Login</a></li>
                    <?php else : ?>
                        <li class=" nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-user"> <?php echo $session->username; ?></i><b class="caret"></b></a>
                            <ul class="dropdown-menu" role="menu">
                                <li class="nav-link">
                                    <a id="logout" class="nav-link" href="admin/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>