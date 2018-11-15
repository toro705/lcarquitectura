
    <body class="hold-transition skin-yellow-light sidebar-mini fixed <?= $_SESSION['Menu']['class'] ?>">
        <div class="preloader"><h1>Cargando...</h1></div>
        <div class="wrapper">
            <header class="main-header">
                <!-- Logo -->
                <a href="http://lcarquitectura.com.ar" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b><img src="<?= base_url('public/admin/img/logo-img.png') ?>"/></b></span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b><img class="img-responsive" src="<?= base_url('public/admin/img/logo.png') ?>"/></b></span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- Messages: style can be found in dropdown.less-->
                            <li class="dropdown messages-menu hidden">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-envelope-o"></i>
                                    <span class="label label-success">4</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">Tienes 4 mensajes</li>
                                    <li>
                                        <!-- inner menu: contains the actual data -->
                                        <ul class="menu">
                                            <!-- start message -->
                                            <li>
                                                <a href="javascript:;">
                                                    <div class="pull-left">
                                                        <img src="<?= base_url('public/app/images/users/' . $_SESSION['User']->image) ?>" class="img-circle" alt="User Image">
                                                    </div>
                                                    <h4>
                                                        Support Team
                                                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                                    </h4>
                                                    <p>Why not buy a new awesome theme?</p>
                                                </a>
                                            </li>
                                            <!-- end message -->
                                            <!-- start message -->
                                            <li>
                                                <a href="#">
                                                    <div class="pull-left">
                                                        <img src="<?= base_url('public/app/images/users/' . $_SESSION['User']->image) ?>" class="img-circle" alt="User Image">
                                                    </div>
                                                    <h4>
                                                        Support Team
                                                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                                    </h4>
                                                    <p>Why not buy a new awesome theme?</p>
                                                </a>
                                            </li>
                                            <!-- end message -->
                                            <!-- start message -->
                                            <li>
                                                <a href="#">
                                                    <div class="pull-left">
                                                        <img src="<?= base_url('public/app/images/users/' . $_SESSION['User']->image) ?>" class="img-circle" alt="User Image">
                                                    </div>
                                                    <h4>
                                                        Support Team
                                                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                                    </h4>
                                                    <p>Why not buy a new awesome theme?</p>
                                                </a>
                                            </li>
                                            <!-- end message -->
                                            <!-- start message -->
                                            <li>
                                                <a href="#">
                                                    <div class="pull-left">
                                                        <img src="<?= base_url('public/app/images/users/' . $_SESSION['User']->image) ?>" class="img-circle" alt="User Image">
                                                    </div>
                                                    <h4>
                                                        Support Team
                                                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                                    </h4>
                                                    <p>Why not buy a new awesome theme?</p>
                                                </a>
                                            </li>
                                            <!-- end message -->
                                        </ul>
                                    </li>
                                    <li class="footer"><a href="#">Ver todos los mensajes</a></li>
                                </ul>
                            </li>
                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="<?= base_url('public/app/images/users/' . $_SESSION['User']->image) ?>" class="user-image" alt="User Image">
                                    <span class="hidden-xs"><?= $_SESSION['User']->first_name . ' '. $_SESSION['User']->last_name ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="<?= base_url('public/app/images/users/' . $_SESSION['User']->image) ?>" class="img-circle" alt="User Image">
                                        <p>
                                            <?= $_SESSION['User']->first_name . ' '. $_SESSION['User']->last_name ?>
                                            <small>Miembro desde <?= date('d/m/Y', $_SESSION['User']->created) ?></small>
                                        </p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-body">
                                        <div class="pull-left">
                                            <a href="<?= base_url('admin/users/update/'.$_SESSION['User']->user_type_id.'/'.$_SESSION['User']->id) ?>" class="btn btn-default btn-flat">Perfil</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="<?= base_url('admin/users/signOut') ?>" class="btn btn-default btn-flat">Salir</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>            