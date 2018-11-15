<div class="user-panel">
    <div class="pull-left image">
        <img src="<?= base_url('public/app/images/users/' . $image) ?>" class="profile-user-img img-responsive img-circle" alt="Imagen de Usuario">
    </div>
    <div class="pull-left info">
        <p><?= $first_name . ' ' . $last_name ?></p>
        <?php if ($state) { ?>
            <a href="javascript:;"><i class="fa fa-circle text-success"></i> Activo</a>
        <?php } else { ?>
            <a href="javascript:;"><i class="fa fa-circle text-danger"></i> Inactivo</a>
        <?php } ?>
    </div>
    <div class="clearfix"></div>
    <div class="form-group mt-10">
        <?php if ($user_type_id == 2) : ?>
            <p><?= $description ?></p>
        <?php endif; ?>
        <p><a target="_blank" href="mailto:<?= $email ?>"><?= $email ?></a></p>
    </div>
</div>