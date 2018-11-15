<!doctype html>
<html class="no-js" lang="es">
    <?php $this->load->view('app/blocks/header');?>
    <body>
    <style>
        .carousel-inner{
            height:100%;
        }
    </style>


    <?php $this->load->view('app/blocks/nav');?>
    <header id="myCarousel" class="carousel slide">
        
        <!-- Indicators -->
        <!-- Wrapper for Slides -->
        <div class="carousel-inner completo" style="">
                <?php foreach ($slider->images as $v) : ?>
            
                    <div class="item  completo">
                        <!-- Set the first background image using inline CSS below. -->
                        <div class="fill" style="background-image:url('<?= base_url('public/app/files/proyectos/large/'.$v->name);?>')"></div>
                    </div>
                <?php endforeach ?>
             
        </div>

        <!-- Controls -->
        <a id="prevslide" class="load-ite" href="#myCarousel" data-slide="prev"></a>

        <a id="nextslide" class="load-item " href="#myCarousel" data-slide="next"></a>


    </header>
    <?php $this->load->view('app/blocks/scripts');           ?>
    <script>

        $(document).ready(function () {

            $('.carousel').carousel({
                interval: 5000 //changes the speed
            })
            $('.item:first-child').addClass('active');
        });
    </script>

    <?php $this->load->view('app/blocks/footer');           ?>
