
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
                            <div class="box box-danger">
                                <div class="box-header">
                                    <!-- <h3 class="box-title">Usuarios</h3> -->
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="dataTables_length" id="<?= $module ?>-table_length">
                                                <form method="post" id="numrows" action="<?= base_url('admin/'.$module.'/redirect') ?>">
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
                                            <div id="<?= $module ?>-table_filter" class="dataTables_filter">
                                                <form method="post" class="text-center">
                                                    <label>
                                                        Buscar:
                                                        <input type="search" name="search" value="<?= $search ?>" class="form-control input-sm"/>
                                                    </label>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="col-md-4 text-right">
                                            <a href="<?= base_url('admin/'.$module.'/create/') ?>" class="btn btn-danger btn-flat"><i class="fa fa-plus"></i>Agregar</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Id <div><a href="<?= base_url('admin/'.$module.'/read/id/asc/'.$numrows.'/'.$start)?>" class=""><i class="fa fa-angle-up"></i></a><a href="<?= base_url('admin/'.$module.'/read/id/desc/'.$numrows.'/'.$start)?>"><i class="fa fa-angle-down"></i></a></div></th>
                                                <th>Nombre <div><a href="<?= base_url('admin/'.$module.'/read/name/asc/'.$numrows.'/'.$start)?>" class=""><i class="fa fa-angle-up"></i></a><a href="<?= base_url('admin/'.$module.'/read/name/desc/'.$numrows.'/'.$start)?>"><i class="fa fa-angle-down"></i></a></div></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($states as $k => $state) { ?>
                                                <tr>
                                                    <td><?= $state->id ?></td>
                                                    <td><?= $state->name ?></td>
                                                    <td class="text-center">
                                                        <div class="btn-group">
                                                            <a data-toggle="tooltip" title="Editar"   class="btn btn-danger btn-flat" href="<?= base_url('admin/'.$module.'/update/'.$state->id) ?>"><i class="fa fa-edit"></i></a>
                                                            <a data-toggle="tooltip" title="Eliminar" class="btn btn-danger btn-flat removeAction" href="<?= base_url('admin/'.$module.'/delete/'.$state->id) ?>"><i class="fa fa-trash"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Id</th>
                                                <th>Nombre</th>
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
                    