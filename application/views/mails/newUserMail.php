<!DOCTYPE html>
<html lang="en">
<head> 
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta charset="utf-8">

    <style>
        body {
            font-family: 'Open Sans', 'Helvetica Neue', Arial, sans-serif;
            font-size: 14px;
            border: 1px solid;
        }
        .panel-header{border: 1px solid #000;background-color: #F05F40;color: #fff;text-align: center}
        .panel-body{border:1px solid #000;padding:0 10px}
        .panel-footer{border:1px solid #000;padding:0 10px;background-color: #F05F40;color: #fff;text-align: center}
    </style>

</head>
<body>
    <div class="panel-header">
        <h1>Family Home</h1>
    </div>
    <div class="panel-body">
        <p>Estimado usuario: </p>

        <p>Junto con saludar, le informamos que desde el sistema Family Home se ha registrado este 
            correo para acceder al panel administrativo como "<?php echo $level_access; ?>". Los datos de
            acceso a su cuenta son los siguientes: </p>
            
        <ul>
            <li><strong>Correo electrónico: </strong><?php echo $email_access; ?></li>
            <li><strong>Contraseña: </strong><?php echo $password; ?></li>
        </ul>

        <p>Para ingresar a este sistema, primero debe acceder a <a href="<?= $_SERVER['HTTP_BASE_URL']; ?>/panel"><?= $_SERVER['HTTP_BASE_URL']; ?>/panel</a>, ingresar
            con esta cuenta de correo y su contraseña.

        <p>Luego de ingresar al sistema, podrá cambiar esta contraseña en la opción "Mi Perfil".</p>

        <p>Sistema Family Home</p>
    </div>
    <div class="panel-footer">
        <p>Este mensaje ha sido enviado automaticamente desde Sistema Family Home. Por favor, no responda a este mensaje.</p>
    </div>
</body>
</html>