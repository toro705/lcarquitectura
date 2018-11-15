<!doctype html>
<html class="no-js" lang="es">
    <?php $this->load->view('app/blocks/header');?>
    <body class="page-template-onecolumn-page-php">


    <?php $this->load->view('app/blocks/nav');?>
    <section id="proyecto">
        <div class="container-fluid">
            <div class="row">
                <div class="infoContainer TEXT-LEFT">

                    <div class="titulo">
    
                        <?= $proyecto->first_name ?> <span><?= $proyecto->last_name ?></span>

                        <a href="javascript:;" class="moreinfo open">+ info</a>
                        <a href="javascript:;" class="moreinfo cerr" style="display: none;"><i class="fa fa-times" aria-hidden="true"></i> CERRAR</a>

                    </div>

                    <div class="descripcion___">
                        <?= $proyecto->description ?>
                    </div>


                </div>
                <div id="proyecto__carousel" class="carousel slide">
                    
                    <div class="carousel-inner completo">

                        <?php foreach ($proyecto->images as $v) : ?>
                        <div class="item completo">
                            <div class="fill" style="background-image:  url('<?= base_url('public/app/files/proyectos/large/'.$v->name);?>"></div>
                        </div>
                        <?php endforeach ?>

                    </div>
                </div>
            </div>
        </div>
  
    </section>

    <a href="<?= base_url('app/site/proyectos');?>" class="scroll-to-top-arrow-button"><i class="fa fa-chevron-left" aria-hidden="true"></i> Volver </a>
    <?php $this->load->view('app/blocks/scripts');           ?>
    <script>

        $(document).ready(function () {

            $('.carousel').carousel({
                interval: 5000 //changes the speed
            })
            $('.item:first-child').addClass('active');
        });
    </script>
    <a id="prevslide" class="load-ite" href="#proyecto__carousel" data-slide="prev"></a>

    <a id="nextslide" class="load-item " href="#proyecto__carousel" data-slide="next"></a>

    <?php $this->load->view('app/blocks/footer');           ?>
