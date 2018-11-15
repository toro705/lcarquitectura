
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" id="general">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        General
                        <!-- <small>Panel de control</small> -->
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="javascript:;"><i class="fa fa-dashboard"></i> General</a></li>
                    </ol>
                </section>
                <!-- Main content -->
                <section class="content">
                    <!-- Main row -->
                    <div class="row">
                        <div class="col-xs-12">
                        </div>
                        <div class="col-lg-4 col-xs-12">
                            <!-- small box -->
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <h3><?= $admins ?></h3>
                                    <p>Administradores</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-cogs"></i>
                                </div>
                                <a href="<?= base_url('admin/users/redirect/1') ?>" class="small-box-footer">
                                    Más Información 
                                    <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-xs-12">
                            <!-- small box -->
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <h3><?= $proyectos ?></h3>
                                    <p>Proyectos</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-building"></i>
                                </div>
                                <a href="<?= base_url('admin/users/redirect/2') ?>" class="small-box-footer">
                                    Más Información 
                                    <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-xs-12">
                            <!-- small box -->
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <h3><?= $photos ?></h3>
                                    <p>Fotos</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-user"></i>
                                </div>
                                <a href="<?= base_url('admin/users/redirect/2') ?>" class="small-box-footer">
                                    Más Información 
                                    <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- /.row (main row) -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            