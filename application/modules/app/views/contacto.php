<!doctype html>
<html class="no-js" lang="es">
    <?php $this->load->view('app/blocks/header');?>
<body class="cuerpo-contacto">


    <?php $this->load->view('app/blocks/nav');?>
    <div  class="container">
        <div class="col-lg-12 col-md-12 seccion-contacto">
              
                    <div class="col-md-2">
                        <div class="container col-lg-3 rotar2 hidden-sm hidden-xs" style="width: 80vh; ">
                        <p class="contacto-titulo-grande">Contacto</p>
                    </div>
                    </div>
                        
                        <div class="col-md-6 contact-grid">
                            <?php if ($success) {
                                echo($mensaje);
                                
                            } else { ?>
                                <p class="error"></p>
                                <form action="" method="post" class="form-contacto">    
                                    <input type="text" name="name" value="<?= set_value('name') ?>" placeholder="Nombre y Apellido:*"  required>
                                     <?= form_error('name') ?>
                                    <input type="email" name="email" value="<?= set_value('email') ?>" placeholder="Mail:*" required>
                                     <?= form_error('email') ?>
                                    <input type="text" name="subject" value="<?= set_value('subject') ?>"  placeholder="Asunto:" required>
                                     <?= form_error('subject') ?>
                                    
                                    <textarea cols="77" rows="6"  placeholder="Mensaje:" name="description"required><?= set_value('description') ?></textarea>
                                    <p style="color: #FFF">*Campos Obligatorios</p>
                                     <?= form_error('description') ?>
                                    <div class="send">
                                        <input type="submit" value="ENVIAR">
                                    </div>
                                </form>
                            <?php } ?>
                            
                        </div>
                        <div class="col-md-4 contact-in">
                            <div class="line-separator-superior"></div>
                            <div class="line-separator"></div>
                                <div class="address-more">
                                    <p>Colegiales Bs. As. - Argentina</p>
                                    <p>Tel: 011 4551 6801</p>
                                    <p><a href="mailto:info@lcarquitectura.com.ar"> info@lcarquitectura.com.ar</a></p>
                                </div>
                            <div class="line-separator"></div>
                            <div class="line-separator-inferior"></div>
                        </div>
                        <div class="clearfix"> </div>
                
            

            
            

        </div>
    </div>
    <?php $this->load->view('app/blocks/scripts');           ?>
