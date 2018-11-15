<div class="user-panel">
    <div class="pull-left image">
        <img src="<?= base_url('public/app/images/newspapers/'.$image) ?>" class="img-responsive img-thumbnail" alt="Imagen de Diairio">
    </div>
    <div class="pull-left info">
        <p><?= $name ?></p>
        <?php if ($state) { ?>
            <a href="javascript:;"><i class="fa fa-circle text-success"></i> Activo</a>
        <?php } else { ?>
            <a href="javascript:;"><i class="fa fa-circle text-danger"></i> Inactivo</a>
        <?php } ?>
    </div>
    <div class="clearfix"></div>
    <div class="form-group mt-10">
        <p><?= $typography ?></p>
    </div>
</div>