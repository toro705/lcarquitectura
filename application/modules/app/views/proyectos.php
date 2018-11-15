<!doctype html>
<html class="no-js" lang="es">
    <?php $this->load->view('app/blocks/header');?>
    <body>


    <?php $this->load->view('app/blocks/nav');?>
    <section id="proyectos">
        <div class="container-fluid">
            <div class="row">
                
                <?php foreach ($proyectos as $v) : ?>

                    <a href="<?= base_url('app/site/proyecto/'.$v->id);?>" class="col-4-nogutter" style="background-image: url(<?= base_url('public/app/images/users/'.$v->image); ?>);">
                        <div class="hover-layout">
                            <div class="hover-layout__content">
                                
                              
                                <p><?php echo $v->first_name; ?></p>
                              
                            </div>
                        </div>
                    </a>
                <?php endforeach ?>
                <?php foreach ($listadoproyectos as $v) : ?>

                    <a href="<?= base_url('app/site/listadoproyecto/'.$v->id);?>" class="col-4-nogutter" style="background-image: url(<?= base_url('public/app/images/users/'.$v->image); ?>);">
                        <div class="hover-layout">
                            <div class="hover-layout__content" style="padding: 30px 76px;">
                             
                                <p>Listado de Obras <br>y proyectos</p>
                             
                            </div>
                        </div>
                    </a>
                <?php endforeach ?>
            </div>

        </div>
    </section>
    
    <?php $this->load->view('app/blocks/scripts');           ?>
    <script>

        $(document).ready(function () {

            $('.carousel').carousel({
                interval: 5000 //changes the speed
            })
        });
    </script>

    <?php $this->load->view('app/blocks/footer');           ?>
