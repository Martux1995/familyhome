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

        <p>Junto con saludar, le informamos que han solicitado su contacto desde la página de FamilyHome
        para obtener información. Los datos de la persona son los siguientes: </p>
            
        <ul>
            <li><strong>Nombre: </strong><?php echo $name; ?></li>
            <li><strong>Correo Electrónico: </strong><?php echo $email; ?></li>
            <li><strong>Teléfono: </strong><?php echo $phone; ?></li>
            <li><strong>Mensaje: </strong><?php echo $message; ?></li>
        </ul>

        <p>Sistema Family Home</p>
    </div>
    <div class="panel-footer">
        <p>Este mensaje ha sido enviado automaticamente desde Sistema Family Home. Por favor, no responda a este mensaje.</p>
    </div>
</body>
</html>