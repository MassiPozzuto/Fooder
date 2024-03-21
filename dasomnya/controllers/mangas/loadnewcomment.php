 <?php
  
                      $sql = "SELECT * FROM comments INNER JOIN users ON users.ID = comments.User_ID WHERE Manga_ID = $_GET[manga] AND mangachapter = $_GET[capitulo] ORDER BY comments.ID DESC";
                      $result = mysqli_query($conn, $sql);
                      $resultCheck = mysqli_num_rows($result);
                      if ($resultCheck > 0) {
                          while ($row = mysqli_fetch_assoc($result)) {
                      ?>
                      
                              <div class="d-flex flex-start mt-4">

                                  <a href="../controllers/perfil.php?User=<?php echo $row['ID'] ?>">
                                      <img class="rounded-circle shadow-1-strong me-3" src="<?php echo $row['profile_pic'] ?>" alt="avatar" width="65" height="65"/>
                                  </a>
                                  <div class="flex-grow-1 flex-shrink-1">
                                      <div class="">
                                          <div class="">
                                              <h5 class="mb-1">
                                                  <?php echo $row['Name'] ?>
                                              </h5>
                                              <span class="text-muted small"><?php echo $row['created_at']?></span>
                                          </div>
                                          <p class="small mb-0">
                                              <?php echo $row['content'] ?>
                                          </p>
                                      </div>
                                  </div>
                              </div>
                              <hr>
                      <?php
                          }
                      } else {
                          echo "<p class='h6'>No hay ningun comentario. Se el primero en comentar!</p>";
                      }
  