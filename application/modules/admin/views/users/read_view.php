
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        <?= $title ?>
                        <small><?= $action ?></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?= base_url('admin/dashboards') ?>"><i class="fa fa-dashboard"></i> General</a></li>
                        <li><?= $title ?></li>
                        <li class="active"><?= $action ?></li>
                    </ol>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <!-- <h3 class="box-title">Usuarios</h3> -->
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="dataTables_length" id="users-table_length">
                                                <form method="post" id="numrows" action="<?= base_url('admin/'.$module.'/redirect/'.$type) ?>">
                                                    <label>
                                                        Mostrar
                                                        &nbsp;
                                                        <select name="numrows" class="form-control input-sm">
                                                            <option value="10"  <?php if($numrows == 10)  echo 'selected'; ?> >10</option>
                                                            <option value="25"  <?php if($numrows == 25)  echo 'selected'; ?> >25</option>
                                                            <option value="50"  <?php if($numrows == 50)  echo 'selected'; ?> >50</option>
                                                            <option value="100" <?php if($numrows == 100)  echo 'selected'; ?> >100</option>
                                                        </select>
                                                        &nbsp;
                                                        registros
                                                    </label>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div id="users-table_filter" class="dataTables_filter">
                                                <form method="post" class="text-center">
                                                    <label>
                                                        Buscar:
                                                        <input type="search" name="search" value="<?= $search ?>" class="form-control input-sm"/>
                                                    </label>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="col-md-4 text-right">
                                            <a href="<?= base_url('admin/users/create/'.$type) ?>" class="btn btn-primary btn-flat"><?php if ($this->uri->segment(4) == 1) : ?><i class="fa fa-user-plus"></i><?php else : ?> <i class="fa fa-plus" aria-hidden="true"></i><?php endif ?>Agregar</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Id <div><a href="<?= base_url('admin/'.$module.'/read/'.$type.'/id/asc/'.$numrows.'/'.$start)?>" class=""><i class="fa fa-angle-up"></i></a><a href="<?= base_url('admin/'.$module.'/read/'.$type.'/id/desc/'.$numrows.'/'.$start)?>"><i class="fa fa-angle-down"></i></a></div></th>
                                                <th>Nombre <div><a href="<?= base_url('admin/'.$module.'/read/'.$type.'/first_name/asc/'.$numrows.'/'.$start)?>" class=""><i class="fa fa-angle-up"></i></a><a href="<?= base_url('admin/'.$module.'/read/'.$type.'/first_name/desc/'.$numrows.'/'.$start)?>"><i class="fa fa-angle-down"></i></a></div></th>
                                                <th><?php if ($this->uri->segment(4) == 1) : ?>Apellido(s)<?php else : ?> Ubicación <?php endif ?><div><a href="<?= base_url('admin/'.$module.'/read/'.$type.'/last_name/asc/'.$numrows.'/'.$start)?>" class=""><i class="fa fa-angle-up"></i></a><a href="<?= base_url('admin/'.$module.'/read/'.$type.'/last_name/desc/'.$numrows.'/'.$start)?>"><i class="fa fa-angle-down"></i></a></div></th>
                                                <?php if ($this->uri->segment(4) == 1) : ?>
                                                    <th>Email <div><a href="<?= base_url('admin/'.$module.'/read/'.$type.'/email/asc/'.$numrows.'/'.$start)?>" class=""><i class="fa fa-angle-up"></i></a><a href="<?= base_url('admin/'.$module.'/read/'.$type.'/email/desc/'.$numrows.'/'.$start)?>"><i class="fa fa-angle-down"></i></a></div></th>
                                                <?php endif ?>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($users as $k => $user) { ?>
                                                <tr>
                                                    <td><?= $user->id ?></td>
                                                    <td><a class="viewAction" href="<?= base_url('admin/users/view/'.$user->id) ?>"><?= $user->first_name ?></a></td>
                                                    <td><a class="viewAction" href="<?= base_url('admin/users/view/'.$user->id) ?>"><?= $user->last_name ?></a></td>
                                                    <?php if ($this->uri->segment(4) == 1) : ?>
                                                        <td><?= $user->email ?></td>
                                                    <?php endif ?>
                                                    <td class="text-center">
                                                        <div class="btn-group">
                                                            <a data-toggle="tooltip" title="Editar"        class="btn btn-primary btn-flat" href="<?= base_url('admin/users/update/'.$type.'/'.$user->id) ?>"><i class="fa fa-edit"></i></a>
                                                            <a data-toggle="tooltip" title="Ver"           class="btn btn-primary btn-flat viewAction button" href="<?= base_url('admin/users/view/'.$user->id) ?>"><i class="fa fa-eye"></i></a>
                                                            <a data-toggle="tooltip" title="Eliminar"      class="btn btn-primary btn-flat removeAction" href="<?= base_url('admin/users/delete/'.$user->id) ?>"><i class="fa fa-trash"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Id</th>
                                                <th>Nombre</th>
                                                <th><?php if ($this->uri->segment(4) == 1) : ?>Apellido(s)<?php else : ?> Ubicación <?php endif ?></th>
                                                <?php if ($this->uri->segment(4) == 1) : ?>
                                                    <th>Email</th>
                                                <?php endif ?>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="box-footer">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <span>Mostrando <?= $numrows ?> registros del <?= $start_rows ?> al <?= $end_rows ?> de un total de <?= $total_rows ?> registros</span>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <?= $pagination ?>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
                    