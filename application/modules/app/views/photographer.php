<!doctype html>
<html class="no-js" lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Brite</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="manifest" href="site.webmanifest">
        <link rel="apple-touch-icon" href="icon.png">
        <!-- Place favicon.ico in the root directory -->

        <link rel="stylesheet" href="<?= base_url('public/app/css/normalize.css') ?>">    
        <link rel="stylesheet" href="<?= base_url('public/app/css/animate.css') ?>">    
        <!-- <link rel="stylesheet" href="css/bootstrap.min.css">     -->
<!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" crossorigin="anonymous">

        <link href="https://fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
        <link rel="stylesheet" href="<?= base_url('public/app/css/main.css') ?>">
        <link rel="stylesheet" href="<?= base_url('public/app/js/lightbox/css/lightbox.css') ?>">

    </head>
    <body>
        <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

        <!-- Add your site or application content here -->
        <section id="work">
            <div class="container-fluid">
                <div class="row">
                        <div class="title-bar">
                            <div class="title-title wow fadeIn animated" data-wow-duration="1000ms" data-wow-delay="100ms">
                            <img src="<?= base_url('public/app/img/plus.png') ?>" class="img-responsive">
                                <h2><?= $photographer->first_name.' '.$photographer->last_name ?></h2>
                            </div>
                        </div>
                </div>
                <div class="row bg-2">
                        <?php foreach ($photographer->images as $v) : ?>

                            <a href="<?= base_url('public/app/files/photographers/large/'.$v->name);?>" data-lightbox="works" rel="work" class="work" style="background-image:  url('<?= base_url('public/app/files/photographers/medium/'.$v->name);?>">
                                <span class="work_overlay transition"></span>
                            </a>

                        <?php endforeach ?>
                        <a href="<?= base_url(); ?> " class="work">
                            <span class="work_overlay transition"></span>
                            <span CLASS="work_back animated">VOLVER</span>
                        </a>                        

                </div>
            </div>
        </section> 
        <a href="<?= base_url() ?>" class="scroll-to-top-arrow-button" style="display: inline;"><i class="fa fa-home" aria-hidden="true"></i></a>
        <footer class="bg-2">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <img src="img/plus-orange-SM.png" alt="" class="img-responsive wow fadeIn animated" data-wow-duration="1000ms" data-wow-delay="90ms">
                        <h4 class="color-3 wow fadeIn animated" data-wow-duration="1000ms" data-wow-delay="100ms">EXECUTIVE PRODUCER</h4>
                        <hr class="bg-3 wow fadeIn animated" data-wow-duration="1000ms" data-wow-delay="120ms">
                        <p class=" wow fadeIn animated" data-wow-duration="1000ms" data-wow-delay="130ms">Guille Iriarte</p>
                        <a class=" wow fadeIn animated" data-wow-duration="1000ms" data-wow-delay="140ms" href="tel:+5491156662600">M. +549 11 56 66 26 00</a>
                        <a class=" wow fadeIn animated" data-wow-duration="1000ms" data-wow-delay="150ms" href="mailto:guille@briteproductions.com.ar">E. guille@briteproductions.com.ar</a>
                        <!--                         <ul class="redes list-inline wow fadeIn animated" data-wow-duration="1000ms" data-wow-delay="100ms">
                                                    <li>
                                                        <a href="javascript:;"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                                                    </li>
                                                </ul>
                         -->
                     </div>
                </div>
            </div>
            
        </footer>       
        <script src="<?= base_url('public/app/js/vendor/modernizr-3.5.0.min.js'); ?>"></script>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-3.2.1.min.js"><\/script>')</script>
        <script src="<?= base_url('public/app/js/plugins.js'); ?>"></script>
        <script src="<?= base_url('public/app/js/wow.js'); ?>"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script src="<?= base_url('public/app/js/lightbox/js/lightbox.min.js'); ?>"></script>
        <script src="<?= base_url('public/app/js/main.js'); ?>"></script>

        <!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->
        <script>
            window.ga=function(){ga.q.push(arguments)};ga.q=[];ga.l=+new Date;
            ga('create','UA-XXXXX-Y','auto');ga('send','pageview')
        </script>
        <script src="https://www.google-analytics.com/analytics.js" async defer></script>
    </body>
</html>
