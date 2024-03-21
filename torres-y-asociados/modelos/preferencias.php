<?php
    $sqlPref = "SELECT censMemes, censComentarios, tema, idioma
                FROM usuarios
                WHERE id='" . $user['id'] . "'
    ";

    $resultPref = mysqli_query($conn, $sqlPref);

    if(!$resultPref){
        die('Error de Consulta' . mysqli_error($conn));
    }

    $user_prefs = mysqli_fetch_all($resultPref, MYSQLI_ASSOC);

    foreach($user_prefs as $user_pref){
        /* --Idioma-- */
        if($user_pref['idioma'] == 'spanish'){
            $idioma1 = "selected"; //spanish
            $idioma2 = ""; //english
        }else if($user_pref['idioma'] == 'english'){
            $idioma2 = "selected"; //english
            $idioma1 = ""; //spanish
        }
        
        /* --Tema-- */
        if($user_pref['tema'] == 'light'){
            $tema = ""; // light
        }else if($user_pref['tema'] == 'dark'){
            $tema = "checked"; // dark
        }

        /* --Censura Comentarios-- */
        if($user_pref['censComentarios'] == 'on'){
            $censComen = "checked";
        }else if($user_pref['censComentarios'] == 'off'){
            $censComen = "";
        }

        /* --Censura Memes-- */
        if($user_pref['censMemes'] == 'on'){
            $censMeme = "checked";
        }else if($user_pref['censMemes'] == 'off'){
            $censMeme = "";
        }
    }
?>