<?php


require_once "../../includes/config.php";

// Detectar si la solicitud es para la API móvil
$isApiRequest = isset($_GET['api']) && $_GET['api'] == '1';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $sqlExistRecipe = "SELECT * FROM recipes WHERE id= '" . $_GET['id'] . "' AND deleted_at IS NULL";
    $resExistRecipe = mysqli_query($conn, $sqlExistRecipe);
    $rowExistRecipe = mysqli_fetch_assoc($resExistRecipe);
    
    if ($rowExistRecipe) {
        if (isset($_SESSION['user'])) {
            // Consulta con `verify_like` para usuarios registrados
            $sqlRecipe = "SELECT recipes.*, users.username, tbl_cant_comments.cant_comments, COUNT(recipes_likes.recipe_id) AS cant_likes, tbl_verify_like.verify_like 
                          FROM recipes 
                          INNER JOIN users ON recipes.user_id = users.id 
                          LEFT JOIN recipes_likes ON recipes.id = recipes_likes.recipe_id 
                          LEFT JOIN 
                              (SELECT recipes.id AS recipe_id, COUNT(comments.recipe_id) AS cant_comments 
                                  FROM recipes 
                                  LEFT JOIN comments ON comments.recipe_id=recipes.id 
                                  WHERE comments.deleted_at IS NULL
                                  GROUP BY comments.recipe_id) AS tbl_cant_comments 
                              ON recipes.id = tbl_cant_comments.recipe_id
                          LEFT JOIN (SELECT recipe_id, COUNT(id) as verify_like 
                                  FROM recipes_likes
                                  WHERE user_id = '" . $_SESSION['user']['id'] . "'
                                  GROUP BY recipe_id) AS tbl_verify_like
                              ON recipes.id = tbl_verify_like.recipe_id
                          WHERE recipes.id= '" . $_GET['id'] . "'
                          GROUP BY recipes.id;";
        } else {
            // Consulta sin `verify_like` para usuarios no registrados
            $sqlRecipe = "SELECT recipes.*, users.username, tbl_cant_comments.cant_comments, COUNT(recipes_likes.recipe_id) AS cant_likes
                          FROM recipes 
                          INNER JOIN users ON recipes.user_id = users.id 
                          LEFT JOIN recipes_likes ON recipes.id = recipes_likes.recipe_id 
                          LEFT JOIN 
                              (SELECT recipes.id AS recipe_id, COUNT(comments.recipe_id) AS cant_comments 
                                  FROM recipes 
                                  LEFT JOIN comments ON comments.recipe_id=recipes.id 
                                  GROUP BY comments.recipe_id) AS tbl_cant_comments 
                              ON recipes.id = tbl_cant_comments.recipe_id
                          WHERE recipes.id= '" . $_GET['id'] . "'
                          GROUP BY recipes.id;";
        }

        $resultRecipe = mysqli_query($conn, $sqlRecipe);
        
        if (!$resultRecipe) {
            if ($isApiRequest) {
                echo json_encode(["error" => "Error en la consulta SQL"]);
                exit();
            } else {
                echo "Error de consulta: " . mysqli_error($conn);
                exit();
            }
        }
        
        $rowRecipe = mysqli_fetch_assoc($resultRecipe);
        $rowRecipe['cant_comments'] =  (is_null($rowRecipe['cant_comments'])) ? 0 : $rowRecipe['cant_comments'];
        
        if ($isApiRequest) {
            // Respuesta JSON para la aplicación móvil
            header("Content-Type: application/json; charset=utf-8");
            print_r(json_encode($rowRecipe)) ;
            exit();
        }
        
    } else {
        if ($isApiRequest) {
            // Respuesta en caso de que no exista la receta para la aplicación móvil
            print_r(json_encode(["error" => "La publicación no existe o ha sido eliminada"])) ;
            exit();
        } else {
            header("Location: home.php");
        }
    }
} else {
    if (!$isApiRequest) {
        header("Location: home.php");
    } else {
        print_r(json_encode(["error" => "ID inválido"]));
        exit();
    }
}

if (!$isApiRequest) {
    $page = $rowRecipe['title'];
    $section = "publication";
    require_once "../../views/layout.php";
}
