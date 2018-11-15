<!doctype html>
<html class="no-js" lang="es">
    <?php $this->load->view('app/blocks/header');?>
    <body>


    <?php $this->load->view('app/blocks/nav');?>

    <section class="cuerpo-estudio">
        <div class="col-lg-12 contenido-estudio">


            <div class="bio-text col-sm-4 col-md-5 col-lg-7">

                <div style="width: 204px">
                    <div class="line-separator-superior"></div>
                    <div class="line-separator-izquierdo"></div>
                    <div class="titulo-estudio">
                        <p>Estudio
                            <br>Biografía</p>
                    </div>
                    <div class="line-separator-derecho"></div>
                    <div class="line-separator-inferior"></div>
                </div>

                <div class="col-md-12 col-lg-12 parrafo-biografia listado-estudio">
                    <p>
                        Arq. Leandro Cyderboim.
                        Nació en  Buenos Aires, Argentina, en el año 1979. Obtuvo el título de Arquitecto en la Universidad de Buenos Aires en el año 2010. A los 20 años construyo su primera obra, habiéndose recibido de maestro de obras en el año 1998. En sus comienzos, se introduce en el mundo de la arquitectura, remodelando los llamados “tipo casa”, mientras estudiaba la carrera de arquitectura, para luego sumarse en la construcción de casas unifamiliares, locales comerciales, edificios multifamilares y emprendimientos inmobiliarios. Al mismo tiempo, obtuvo la matricula como Corredor Inmobiliario, donde se desarrolló durante 17 años, como socio gerente en la empresa Constructora e Inmobiliaria Crecer SA. Como Corredor Inmobiliario. A trabajado como asesor para otros estudios, empresas e inversionistas, en innumerables desarrollos inmobiliarios desde su gestión, conociendo y desarrollando las necesidades, tipologías, recursos, valor del m2, rentabilidades, para poder comercializar los mismos.  
                        En el año 2014, estableció su propio estudio que lleva su nombre, donde al día de la fecha se desarrolla profesionalmente.


                    </p>
                </div>



            </div>

            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
        
    </section>

    <!-- /.container -->



    <?php $this->load->view('app/blocks/scripts');           ?>
    <script>

        $(document).ready(function () {

            $('.carousel').carousel({
                interval: 5000 //changes the speed
            })
        });
    </script>

    <?php $this->load->view('app/blocks/footer');           ?>
