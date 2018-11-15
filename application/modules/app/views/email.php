<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>LC Arquitectura</title>
    <style href>
        a {
            text-decoration: none;
            color: inherit;
        }
    </style>
    <style>
        h1,
        h3 {
            color: inherit;
        }
        
        img {
            width: inherit;
            height: auto;
            max-width: 100%;
        }
    </style>
</head>

<body>
    <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable" style="max-width: 800px!important; max-width: 100%; margin: 0 auto;">
        <tr>
            <td align="center" valign="top">
                <table style="font-family: 'Century Gothic', Arial; color: #484749; border: 2px solid #000;"  cellpadding="20" cellspacing="0" max-width="100%" id="emailContainer" background="#FFF">
                    <tr>
                        <td align="center">
                            <table width="100%">
                                <tr style="background: #FFF">
                                    <td align="center" valign="top" style="padding: 25px 0;">
                                        <a href="javascript:;">
                                            <img src="http://c0590484.ferozo.com/public/app/img/logo_arquitecto2.png" alt="Leandro Cyderboim Arquitectura">
                                        </a>
                                        <h1 style="text-align: center; color: #000; font-weight: 100; margin: 5px 0;">Nuevo Contacto</h1>
                                    </td>
                                </tr>
                                <tr style="line-height: 25px; font-size: 23px;">
                                    <td style="padding: 20px; color: #989699; width: 50%!important; width: 50%;" valign="top" align="center">
                                        <p style="font-size: 15px;">
                                            <B>Nombre:</B>
                                            <?php echo $dataform['name']; ?>
                                            <br>
                                            <B>Email:</B>
                                            <?php echo $dataform['email']; ?>
                                            <br>
                                            <B>Tema:</B>
                                            <?php echo $dataform['subject']; ?>
                                            <br>
                                            <B>Mensaje:</B>
                                            <?php echo $dataform['description']; ?>
                                            <br>

                                        </p>

                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>