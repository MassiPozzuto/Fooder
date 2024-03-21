SELECT recipes.id AS recipe_id, users.username, users.avatar, tbl_cant_comments.cant_comm, COUNT(likes_recipes.recipe_id) AS cant_likes
FROM recipes 
INNER JOIN users ON recipes.user_id = users.id 
LEFT JOIN likes_recipes ON recipes.id = likes_recipes.recipe_id 
LEFT JOIN 
	(SELECT recipes.id AS recipe_id, COUNT(comments.recipe_id) AS cant_comm 
        FROM recipes 
        LEFT JOIN comments ON comments.recipe_id=recipes.id 
        GROUP BY comments.recipe_id) AS tbl_cant_comments 
    ON recipes.id = tbl_cant_comments.recipe_id
GROUP BY recipes.id;
/***********************************************************************/
SELECT comments.*, tbl_cant_likes.cant_likes
FROM comments 
LEFT JOIN 
	(SELECT comment_id, COUNT(comment_id) AS cant_likes 
        FROM likes_comments 
     	GROUP BY comment_id) AS tbl_cant_likes
	ON comments.id = tbl_cant_likes.comment_id
WHERE comments.recipe_id=10;