
    <body class="hold-transition skin-yellow-light login-page">
        <div class="preloader"><h1>Cargando...</h1></div>
        <div class="login-box">
            <div class="login-logo">
                <!-- <a href="<?= base_url() ?>"><img src="<?= base_url('public/admin/img/logo.png') ?>" alt="" /></a> -->
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body">
                <p class="text-center">
                    <a class="inline-block" href="<?= base_url() ?>">
                        <img class="img-responsive inline-block" src="<?= base_url('public/admin/img/logo.png') ?>" alt="" />
                    </a>
                </p>
                <p class="login-box-msg">Accede para comenzar tu sesión</p>
                <form method="post" id="sign-in-form" class="formValidation" action="<?= base_url('admin/users/signIn') ?>">
                    <div class="form-group has-feedback">
                        <input type="email" name="email" class="form-control" placeholder="E-mail" value="<?= set_value('email') ?>" data-rule-required="true"/>
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        <?= form_error('email') ?>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" name="password" class="form-control" placeholder="Contraseña" value="<?= set_value('password') ?>" data-rule-required="true"/>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        <?= form_error('password') ?>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Ingresar</button>
                    </div>
                </form>
            </div>
            <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->
