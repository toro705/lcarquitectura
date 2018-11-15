            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="<?= base_url('public/app/images/users/' . $_SESSION['User']->image) ?>" class="img-circle" alt="User Image">
                        </div>
                        <div class="pull-left info">
                            <p><?= $_SESSION['User']->first_name . ' '. $_SESSION['User']->last_name ?></p>
                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    <!-- sidebar menu -->
                    <ul class="sidebar-menu">
                        <li data-controller="dashboards"><a href="<?= base_url('admin/dashboards') ?>"><i class="fa fa-dashboard"></i> <span>General</span></a></li>
                        <li data-controller="users_1"><a href="<?= base_url('admin/users/redirect/1') ?>"><i class="fa fa-cogs"></i> <span>Administradores</span></a></li>
                        <li data-controller="users_2"><a href="<?= base_url('admin/users/redirect/2') ?>"><i class="fa fa-building"></i> <span>Proyectos</span></a></li>
                        <li data-controller="users_2"><a href="<?= base_url('admin/users/update/4/40') ?>"><i class="fa fa-building-o"></i> <span>Listado de Proyectos</span></a></li>
                        <li data-controller="users_1"><a href="<?= base_url('admin/users/update/3/35') ?>"><i class="fa fa-file-image-o"></i> <span>Slider</span></a></li>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>
            