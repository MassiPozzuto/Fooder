<div class="container fluid">
    <h1>Ha ocurrido una falla técnica</h1>
    <hr/>
    <div class="container" >
            <img src="../Img/cattusmanga_error.png" width="20%" height="20%" alt="Gato en problemas" />
    </div>
    <div class="container-fluid">
        <p>Nuestros técnicos están trabajando para solucionar este inconveniente...</p>
        <p>Si el problema persiste, puedes contactar al soporte para obtener ayuda y asistencia.</p>
        <p>También puedes revisar en twitter el estado del servicio.</p>
        <ul>
            <li>Haga click en el botón para ser redirigido a la pagina principal</li>
        </ul>
        <button id="redirect" class="btn btn-primary">
            Click aqui
        </button>
    </div>
    <hr/>
    <h4>Información técnica del error</h4>
    <div class="container-fluid">
    <?php
    if ((isset($error_level) && isset($error_message) && isset($error_file) && isset($error_line) && isset($error_context)) === true) {
        ?>
        <p><strong>Tipo de error:</strong> <?php echo $error_level; ?></p>
        <p><strong>Mensaje de error:</strong> <?php echo $error_message;?></p>
        <p><strong>Archivo de error:</strong> <?php echo $error_file;?></p>
        <p><strong>Línea que fallo:</strong> <?php echo $error_line;?></p>
        <p><strong>Variables definidas:</strong>  <pre><?php print_r($error_context);?></pre></p>
    <?php
    } else { echo("<p>No se ha encontrado ninguna falla.</p>"); }
    ?>
    </div>
</div>

<script>
    document.querySelector('#redirect')
        .addEventListener('click', () => {
            window.location.href = '<?php echo ($GLOBALS["index_root"]) ?>homepage'
        });
</script>