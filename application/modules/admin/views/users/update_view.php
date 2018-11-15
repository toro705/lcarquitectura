
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
                        <li><a href="<?= base_url('admin/users/redirect/' . $type) ?>"><?= $title ?></a></li>
                        <li class="active"><?= $action ?></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content" id="user">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-primary">
                                <div class="box-body">
                                    <form method="post" role="form" id="user-form" class="submitForms formValidation" enctype="multipart/form-data">
                                        <input type="hidden" name="id" value="<?= $id ?>">
                                        <div class="row">
                                        <?php if ($this->uri->segment(4) == 3 ) : ?>
                                        <?php elseif ($this->uri->segment(4) == 4 ) : ?>
                                            <div class="col-md-6 hidden">
                                                <div class="form-group <?= (form_error('user_type_id')) ? 'has-error' : '' ?>">
                                                    <label>Tipo de Usuario</label>
                                                    <select name="user_type_id" class="form-control" data-rule-required="true">
                                                        <option value="">Selecione...</option>
                                                        <?php foreach ($user_types as $k => $v) { ?>
                                                            <option value="<?= $v->id ?>" <?= set_select('id', $v->id, $v->selected ) ?>><?= $v->name ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <?= form_error('user_type_id') ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6 hidden">
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
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                  <label for="image">Imagen</label>
                                                  <div>
                                                    <!-- The fileinput-button span is used to style the file input field as button -->
                                                    <span class="btn fileinput-button">
                                                        <div class="absolute">
                                                          <i class="fa fa-pencil-square-o"></i>
                                                          <span>Editar</span>
                                                        </div>
                                                        <!-- The file input field used as target for the file upload widget -->
                                                        <input id="simpleFileUpload" type="file" name="file"/>
                                                        <!-- The container for the uploaded files -->
                                                        <div id="files" class="files">
                                                            <img class="img-responsive img-circle" src="<?= base_url('public/app/images/users/'.$image) ?>">
                                                        </div>
                                                    </span>
                                                    <!-- The global Messages -->
                                                    <div id="messages" class="messages"></div>
                                                    <!-- The global progress bar -->
                                                    <div id="progress" class="progress">
                                                        <div class="progress-bar progress-bar-primary"></div>
                                                    </div>
                                                  </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 hidden">
                                                 <div class="form-group <?= (form_error('first_name')) ? 'has-error' : '' ?>">
                                                  <label>Nombre</label>
                                                  <input type="text" name="first_name" class="form-control" placeholder="Ingrese Nombre" value="<?= set_value('first_name', $first_name) ?>" data-rule-required="true"/>
                                                  <?= form_error('first_name') ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6 hidden">
                                                <div class="form-group <?= (form_error('last_name')) ? 'has-error' : '' ?>">
                                                  <label>Ubicación</label>
                                                  <input type="text" name="last_name" class="form-control" placeholder="Ingrese Ubicación" value="<?= set_value('last_name', $last_name) ?>" data-rule-required="true"/>
                                                  <?= form_error('last_name') ?>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group <?= (form_error('description')) ? 'has-error' : '' ?>">
                                                  <label>Biografía</label>
                                                  <textarea id="ckeditor" name="description" class="form-control" rows="3" placeholder="Ingrese Biografía"><?= set_value('description', $description) ?></textarea>
                                                  <?= form_error('description') ?>
                                                </div>
                                            </div>
                                        <?php else : ?>
                                            <div class="col-md-6 hidden">
                                                <div class="form-group <?= (form_error('user_type_id')) ? 'has-error' : '' ?>">
                                                    <label>Tipo de Usuario</label>
                                                    <select name="user_type_id" class="form-control" data-rule-required="true">
                                                        <option value="">Selecione...</option>
                                                        <?php foreach ($user_types as $k => $v) { ?>
                                                            <option value="<?= $v->id ?>" <?= set_select('id', $v->id, $v->selected ) ?>><?= $v->name ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <?= form_error('user_type_id') ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                  <label for="image">Imagen</label>
                                                  <div>
                                                    <!-- The fileinput-button span is used to style the file input field as button -->
                                                    <span class="btn fileinput-button">
                                                        <div class="absolute">
                                                          <i class="fa fa-pencil-square-o"></i>
                                                          <span>Editar</span>
                                                        </div>
                                                        <!-- The file input field used as target for the file upload widget -->
                                                        <input id="simpleFileUpload" type="file" name="file"/>
                                                        <!-- The container for the uploaded files -->
                                                        <div id="files" class="files">
                                                            <img class="img-responsive img-circle" src="<?= base_url('public/app/images/users/'.$image) ?>">
                                                        </div>
                                                    </span>
                                                    <!-- The global Messages -->
                                                    <div id="messages" class="messages"></div>
                                                    <!-- The global progress bar -->
                                                    <div id="progress" class="progress">
                                                        <div class="progress-bar progress-bar-primary"></div>
                                                    </div>
                                                  </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                 <div class="form-group <?= (form_error('first_name')) ? 'has-error' : '' ?>">
                                                  <label>Nombre</label>
                                                  <input type="text" name="first_name" class="form-control" placeholder="Ingrese Nombre" value="<?= set_value('first_name', $first_name) ?>" data-rule-required="true"/>
                                                  <?= form_error('first_name') ?>
                                                </div>
                                            </div>
                                            <?php if ($this->uri->segment(4) == 2 ) : ?>
                                            <div class="col-md-6">
                                                <div class="form-group <?= (form_error('last_name')) ? 'has-error' : '' ?>">
                                                  <label>Ubicación</label>
                                                  <input type="text" name="last_name" class="form-control" placeholder="Ingrese la Ubicación" value="<?= set_value('last_name', $last_name) ?>" data-rule-required="true"/>
                                                  <?= form_error('last_name') ?>
                                                </div>
                                            </div>                                                
                                            <?php else : ?>
                                            <div class="col-md-6">
                                                <div class="form-group <?= (form_error('last_name')) ? 'has-error' : '' ?>">
                                                  <label>Apellido</label>
                                                  <input type="text" name="last_name" class="form-control" placeholder="Ingrese el Apellido" value="<?= set_value('last_name', $last_name) ?>" data-rule-required="true"/>
                                                  <?= form_error('last_name') ?>
                                                </div>
                                            </div>
                                            <?php endif ?>

                                            <div class="col-md-6">
                                                <div class="form-group <?= (form_error('email')) ? 'has-error' : '' ?> <?= ($user_type_id != 1) ? 'hidden' : '' ?>">
                                                  <label>E-mail</label>
                                                  <input type="text" name="email" class="form-control" placeholder="Ingrese E-mail" value="<?= set_value('email', $email) ?>" data-rule-required="true" data-rule-email="true"/>
                                                  <?= form_error('email') ?>
                                                </div>
                                            </div>


                                            <div style="opacity: 0;" class="col-md-6  <?= ($user_type_id == 1) ? 'hidden' : '' ?>">
                                                <div class="form-group <?= (form_error('user_type_id')) ? 'has-error' : '' ?>">
                                                    <label>Origen</label>
                                                    <select name="user_origin_id" class="form-control" value="1">
                                                        <?php foreach ($origins as $k => $v) { ?>
                                                            <option value="<?= $v->id ?>" <?= set_select('id', $v->id, $v->selected ) ?>><?= $v->name ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <?= form_error('user_origin_id') ?>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6 <?= ($creating_user_id) ? 'hidden' : '' ?> <?= ($user_type_id != 1) ? 'hidden' : '' ?>">
                                                <div class="form-group">
                                                  <label>&nbsp;</label>
                                                  <div>
                                                    <button type="button" class="btn btn-primary btn-flat" id="passwordChange">Modificar Contraseña</button>
                                                  </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 <?= ($user_type_id != 1) ? 'hidden' : '' ?>">
                                              <div class="row">
                                                <div class="col-md-12 passwordChange <?= (!$creating_user_id) ? 'hidden' : '' ?>">
                                                  <div class="form-group <?= (form_error('password')) ? 'has-error' : '' ?>">
                                                    <label>Contraseña</label>
                                                    <input type="password" name="password" id="password" class="form-control" placeholder="Ingrese Contraseña" value="<?= set_value('password') ?>" data-rule-required="true"/>
                                                    <?= form_error('password') ?>
                                                  </div>
                                                </div>
                                                <div class="col-md-12 passwordChange <?= (!$creating_user_id) ? 'hidden' : '' ?>">
                                                  <div class="form-group <?= (form_error('password_confirm')) ? 'has-error' : '' ?>">
                                                    <label>Repetir Contraseña</label>
                                                    <input type="password" name="password_confirm" class="form-control" placeholder="Ingrese Repetir Contraseña" value="<?= set_value('password_confirm') ?>" data-rule-required="true" data-rule-equalto="#password"/>
                                                    <?= form_error('password_confirm') ?>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>

                                            <div class="col-md-12 <?= ($user_type_id != 2) ? 'hidden' : '' ?>">
                                                <div class="form-group <?= (form_error('description')) ? 'has-error' : '' ?>">
                                                  <label>Biografía</label>
                                                  <textarea id="ckeditor" name="description" class="form-control" rows="3" placeholder="Ingrese Biografía"><?= set_value('description', $description) ?></textarea>
                                                  <?= form_error('description') ?>
                                                </div>
                                            </div>
                                   
                                            <div class="col-md-6 hidden">
                                                <div class="form-group">
                                                  <label>Posición</label>
                                                  <input type="number" name="position" class="form-control" placeholder="Ingrese La posición" value="<?= set_value('position', $position) ?>" data-rule-required="false"/>
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

                                        <?php endif ?>    
                                        </div>

                                    </form>
                                    <!-- /form -->
                                    <?php if ($this->uri->segment(4) == 2 ) : ?>
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
                                    <?php if ($this->uri->segment(4) == 4 ) : ?>
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
                                    <?php if ($this->uri->segment(4) == 3 ) : ?>
                                      <div class="row">
                                          <div class="col-md-12">
                                              <form class="form-horizontal" id="fileUpload" method="POST" enctype="multipart/form-data">
                                                  <div class="form-group">
                                                      <label class="col-lg-12">Slider Principal</label>
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

                                </div>
                                <?php if ($this->uri->segment(4) == 3 ) : ?>
                                  <div class="box-footer">
                     
                                      <a href="<?= base_url('admin/dashboards') ?>" class="btn btn-primary btn-flat pull-right">Guardar</a>
                                      <a href="<?= base_url('admin/dashboards') ?>" class="btn btn-default btn-flat pull-right">Volver</a>
                                  </div>
                                <?php else : ?>
                                      
                                
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary btn-flat pull-right">Guardar</button>
                                    <a href="<?= base_url('admin/'.$module.'/redirect/' . $type) ?>" class="btn btn-default btn-flat pull-right">Cancelar</a>
                                </div>
                                <?php endif ?>
                              </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </section>
                <!-- /.content -->

            </div>
            <!-- /.content-wrapper -->
                    