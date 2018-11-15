
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        <?= $title ?>
                        <small><?= $action ?></small>
                    </h1>
                    <ol class="breadcrumb">
                        <!-- <li><a href="<?= base_url() ?>"><i class="fa fa-dashboard"></i> Inicio</a></li> -->
                        <li><a href="<?= base_url('admin/'.$module.'/redirect') ?>"><?= $title ?></a></li>
                        <li class="active"><?= $action ?></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content" id="<?= $module ?>">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-danger">
                                <div class="box-body">
                                    <form method="post" role="form" id="user-form" class="submitForms formValidation" enctype="multipart/form-data">
                                        <input type="hidden" name="id" value="<?= $id ?>">
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group <?= (form_error('name')) ? 'has-error' : '' ?>">
                                                  <label>Nombre</label>
                                                  <input type="text" name="name" class="form-control" placeholder="Ingrese Nombre" value="<?= set_value('name', $name) ?>" data-rule-required="true"/>
                                                  <?= form_error('name') ?>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Estado</label>
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" name="state" value="1" <?php echo set_checkbox('state', 1, $state) ?>/>
                                                            Activo
                                                        </label>
                                                    </div>
                                                    <?= form_error('state') ?>
                                                </div>
                                            </div>

                                        </div>
                                    </form>
                                    <!-- /form -->
                                    <?php if ($this->uri->segment(4) == 2) : ?>
                                      <div class="row">
                                          <div class="col-md-12">
                                              <form class="form-horizontal" id="fileUpload" method="POST" enctype="multipart/form-data">
                                                  <div class="form-group">
                                                      <label class="col-lg-12">Fotos</label>
                                                      <div class="fileupload-buttonbar clearfix">
                                                          <div class="col-lg-12">
                                                              <span class="btn btn-primary btn-flat fileinput-button">
                                                                  <i class="glyphicon glyphicon-plus"></i>
                                                                  <span>Agregar Fotos</span>
                                                                  <input type="file" name="file" multiple>
                                                              </span>
                                                              <button type="button" class="btn btn-default btn-flat delete-all hidden pull-right">
                                                                  <i class="glyphicon glyphicon-trash"></i>
                                                                  <span>Eliminar Todos</span>
                                                              </button>
                                                              <span class="fileupload-process"></span>
                                                              <div class="fileupload-progress fade" style="paddign:0">
                                                                  <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                                                      <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                                                                  </div>
                                                                  <div class="progress-extended">&nbsp;</div>
                                                              </div>
                                                              <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
                                                          </div>
                                                      </div>
                                                  </div>
                                                  <?php $this->load->view('blocks/file_upload') ?>
                                              </form>
                                          </div>
                                      </div>
                                    <?php endif ?>                                    
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-danger btn-flat pull-right">Guardar</button>
                                        <a href="<?= base_url('admin/'.$module.'/redirect') ?>" class="btn btn-default btn-flat pull-right">Cancelar</a>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                              </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </section>
                <!-- /.content -->

            </div>
            <!-- /.content-wrapper -->
                    