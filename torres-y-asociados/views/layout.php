<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?php echo RUTA ?>/img/logo.png">
    <!-- <link rel="stylesheet" href="<?php echo RUTA ?>/css/bootstrap.css"> -->
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.1.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="<?php echo RUTA ?>/css/estilos.css">
    <script src="js/main-scripts.js"></script>
    <script src="https://kit.fontawesome.com/962681b4cf.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tiny.cloud/1/3gmo333dcmyqstg430edl0rc3obt76oqrxtlqfarde8d4am0/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script type="text/javascript">
        
        tinymce.init({
            selector: 'textarea1',
            max_height: 270,
            min_height: 270,
            setup: function editor(editor) {
                var max = 460;
                editor.on('submit', function(event) {
                    var numChars = tinymce.activeEditor.plugins.wordcount.body.getCharacterCount();
                    if (numChars > max) {
                        alert("Maximum " + max + " characters allowed."); //Cambiar el alert por algun mensaje en la pagina
                        event.preventDefault();
                        return false;
                    }
                });
            },
            skin: 'oxide<?php echo $skin = $clase == 'dark' ? '-dark' : '';?>',
            content_css: 'default', //se puede cambiar el tema de area de edicion pero no se ve el placeholder
            plugins: [
            'advlist', 'autolink', 'link', 'lists', 'charmap', 'preview',
            'searchreplace', 'wordcount', 'visualblocks', 'visualchars', 'insertdatetime',
            'emoticons'
            ],
            toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | ' +
            'bullist numlist outdent indent | ' +
            'forecolor backcolor emoticons',
            menubar: 'edit insert format'
        });
    </script>

    <title>Memingos</title>
</head>
<body <?php echo("class='".$clase."'")?>>

    <?php
        require_once('nav-bar.php');

        /** */

        require_once('anuncios.php');
    ?>
    
    <div class="d-more-container">
        <div id="dropdown-more" class="dropdown-more" style="display: none;">
            <a class="boton-clasificacion d-more-btns" href="<?php echo RUTA ?>/clasificacion.php"><img src="<?php echo RUTA ?>/img/clasificacion-imagen.png" class="clasif-nav-bar"></a>
            <?php foreach($rowRoles as $rowRol){
                if($rowRol['perfil_id'] == 1){
                    echo('<a class="link-lista-usuarios d-more-btns" href="'.RUTA.'/lista-admin.php">' . $language['nav-bar']['btn-admin'] . '</a>');
                    echo('<a class="link-lista-usuarios d-more-btns" href="'.RUTA.'/red-social.php">Redes</a>');
                
                    break;
                }else if($rowRol['perfil_id'] == 2){
                    echo('<a class="link-lista-usuarios d-more-btns" href="'.RUTA.'/lista-mod.php">' . $language['nav-bar']['btn-mod'] . '</a>');
                    echo('<a class="link-lista-usuarios d-more-btns" href="'.RUTA.'/red-social.php">Redes</a>');
                    
                    break;
                }else{
                    echo('<a class="link-lista-usuarios d-more-btns" href="'.RUTA.'/red-social.php">Redes</a>');
                }
            } ?>
        </div>
        <button id="d-more-btn-open" class="d-more-btn-open"><i class="fa-solid fa-arrow-right"></i></button>
    </div>

    <div class="contenedor-prueba">
        <?php
            if($section == "feed-principal"){
                include "carousel.php";
            }?>
            <div id="content">
                <?php require_once($section . ".php"); ?>
            </div>
            <?php
                if($section=="feed-principal" || $section == 'resultados-busqueda' || $section == 'galeria-usuario'){
                    echo('<div class="home-boton"><a class="subir-arriva" href="javascript:void(0);"><i class="fa-solid fa-arrow-turn-up"></i></a></div>');
                }
            ?>
    </div>
</body>