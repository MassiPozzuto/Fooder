<?php
session_start();
require_once("../../server/config.php");

if (isset($_POST['submit']) & !empty($_POST)) {
    function invalidgenre($genre)
    {
        isset($result);
        if (!preg_match("/^[a-z A-Z][0-9a-z A-Z_]{1,24}[0-9a-zA-Z]*$/", $genre)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }
    function invalidtitle($title)
    {
        isset($result);
        if (!preg_match("/^[a-z A-Z][0-9a-z A-Z_]{1,40}[0-9a-zA-Z]*$/", $title)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }
   
    $userid =  $_SESSION['datos']['ID'];
    $manga = $_GET['mangaid'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $sqlg1 = "";
    $sqlg2 = "";
    $sqlg3 = "";
    $sqlg4 = "";

    if (isset($_POST['genre0'])) {
        $genre0 =  mysqli_real_escape_string($conn, $_POST['genre0']);
        if (isset($genre0) &&  empty($genre0)) {
            header("location: ../manga.php?manga=" . $manga . "&error=emptyinput");
            die();
        }
        if(isset($genre0) && invalidgenre($genre0) !== false){
            header("location: ../manga.php?manga=" . $manga . "&error=invalidname");
            exit();
            die();
        }
        $chckexist = "SELECT * FROM mangagenders WHERE Name = '$genre0';";
        $rexist = mysqli_query($conn, $chckexist);
        if (mysqli_num_rows($rexist) > 0) {

            $sqlgnr = "SELECT g_ID FROM mangagenders WHERE Name = '$genre0';";
            $rgnr = mysqli_query($conn, $sqlgnr);
            $gnrid = mysqli_fetch_all($rgnr);
            $id = $gnrid[0][0];
            $sqlask =  "SELECT * FROM mangagenders_manga WHERE Manga_ID = '$manga' AND counter = 1;";
            $resultask =  mysqli_query($conn, $sqlask);
            if (mysqli_num_rows($resultask) == NULL || mysqli_num_rows($resultask) == 0) {
                $sqlg0 =  "INSERT INTO mangagenders_manga (Manga_ID, MangaGenders_ID, counter) VALUES('$manga', '$id',1);";
            } else {
                $sqlg0 =  "UPDATE mangagenders_manga SET MangaGenders_ID = '$id' WHERE Manga_ID = '$manga' AND counter = 1;";
            }
        } else {
            $sqlnewgnr = "INSERT INTO mangagenders (Name, image) VALUES('$genre0','$manga');";
            $resultnewgnr = mysqli_query($conn, $sqlnewgnr);
            $sqlgetnewgnr = "SELECT g_ID FROM mangagenders WHERE Name = '$genre0';";
            $resultnewid = mysqli_query($conn, $sqlgetnewgnr);
            $newid = mysqli_fetch_all($resultnewid);

            $id = $newid[0][0];
            $sqlask =  "SELECT * FROM mangagenders_manga WHERE Manga_ID = '$manga' AND counter = 1;";
            $resultask =  mysqli_query($conn, $sqlask);
            if (mysqli_num_rows($resultask) == NULL || mysqli_num_rows($resultask) == 0) {
                $sqlg0 =  "INSERT INTO mangagenders_manga (Manga_ID, MangaGenders_ID, counter) VALUES('$manga', '$id',1);";
            } else {
                $sqlg0 =  "UPDATE mangagenders_manga SET MangaGenders_ID = '$id' WHERE Manga_ID = '$manga' AND counter = 1;";
            }
        }
    }
    if (isset($_POST['genre1'])) {
        $genre1 =  mysqli_real_escape_string($conn, $_POST['genre1']);
        if(isset($genre1) && invalidgenre($genre1) !== false){
            header("location: ../manga.php?manga=" . $manga . "&error=invalidname");
            exit();
            die();
        }
        if (isset($genre1) &&  empty($genre1)) {
            header("location: ../manga.php?manga=" . $manga . "&error=emptyinput");
            die();
        }
        $chckexist = "SELECT * FROM mangagenders WHERE Name = '$genre1';";
        $rexist = mysqli_query($conn, $chckexist);
        if (mysqli_num_rows($rexist) > 0) {

            $sqlgnr = "SELECT g_ID FROM mangagenders WHERE Name = '$genre1';";
            $rgnr = mysqli_query($conn, $sqlgnr);
            $gnrid = mysqli_fetch_all($rgnr);
            $id = $gnrid[0][0];
            $sqlask =  "SELECT * FROM mangagenders_manga WHERE Manga_ID = '$manga' AND counter = 2;";
            $resultask =  mysqli_query($conn, $sqlask);
            if (mysqli_num_rows($resultask) == NULL || mysqli_num_rows($resultask) == 0) {
                $sqlg1 =  "INSERT INTO mangagenders_manga (Manga_ID, MangaGenders_ID, counter) VALUES('$manga', '$id',2);";
            } else {
                $sqlg1 =  "UPDATE mangagenders_manga SET MangaGenders_ID = '$id' WHERE Manga_ID = '$manga' AND counter = 2;";
            }
        } else {
            $sqlnewgnr = "INSERT INTO mangagenders (Name, image) VALUES('$genre1','$manga')";
            $resultnewgnr = mysqli_query($conn, $sqlnewgnr);
            $sqlgetnewgnr = "SELECT g_ID FROM mangagenders WHERE Name = '$genre1';";
            $resultnewid = mysqli_query($conn, $sqlgetnewgnr);
            $newid = mysqli_fetch_all($resultnewid);

            $id = $newid[0][0];
            $sqlask =  "SELECT * FROM mangagenders_manga WHERE Manga_ID = '$manga' AND counter = 2;";
            $resultask =  mysqli_query($conn, $sqlask);
            if (mysqli_num_rows($resultask) == NULL || mysqli_num_rows($resultask) == 0) {
                $sqlg1 =  "INSERT INTO mangagenders_manga (Manga_ID, MangaGenders_ID, counter) VALUES('$manga', '$id',2);";
            } else {
                $sqlg1 =  "UPDATE mangagenders_manga SET MangaGenders_ID = '$id' WHERE Manga_ID = '$manga' AND counter = 2;";
            }
        }
    }

    if (isset($_POST['genre2'])) {
        $genre2 =  mysqli_real_escape_string($conn, $_POST['genre2']);
         if (isset($genre2) &&  empty($genre2)) {
            header("location: ../manga.php?manga=" . $manga . "&error=emptyinput");
            die();
        }
        if(isset($genre2) && invalidgenre($genre2) !== false){
            header("location: ../manga.php?manga=" . $manga . "&error=invalidname");
            exit();
            die();
        }
        
        $chckexist = "SELECT * FROM mangagenders WHERE Name = '$genre2';";
        $rexist = mysqli_query($conn, $chckexist);
        if (mysqli_num_rows($rexist) > 0) {

            $sqlgnr = "SELECT g_ID FROM mangagenders WHERE Name = '$genre2';";
            $rgnr = mysqli_query($conn, $sqlgnr);
            $gnrid = mysqli_fetch_all($rgnr);
            $id = $gnrid[0][0];
            $sqlask =  "SELECT * FROM mangagenders_manga WHERE Manga_ID = '$manga' AND counter = 3;";
            $resultask =  mysqli_query($conn, $sqlask);
            if (mysqli_num_rows($resultask) == NULL || mysqli_num_rows($resultask) == 0) {
                $sqlg2 =  "INSERT INTO mangagenders_manga (Manga_ID, MangaGenders_ID, counter) VALUES('$manga', '$id',3);";
            } else {
                $sqlg2 =  "UPDATE mangagenders_manga SET MangaGenders_ID = '$id' WHERE Manga_ID = '$manga' AND counter = 3;";
            }
        } else {
            $sqlnewgnr = "INSERT INTO mangagenders (Name, image) VALUES('$genre2','$manga')";
            $resultnewgnr = mysqli_query($conn, $sqlnewgnr);
            $sqlgetnewgnr = "SELECT g_ID FROM mangagenders WHERE Name = '$genre2';";
            $resultnewid = mysqli_query($conn, $sqlgetnewgnr);
            $newid = mysqli_fetch_all($resultnewid);

            $id = $newid[0][0];
            $sqlask =  "SELECT * FROM mangagenders_manga WHERE Manga_ID = '$manga' AND counter = 3;";
            $resultask =  mysqli_query($conn, $sqlask);
            if (mysqli_num_rows($resultask) == NULL || mysqli_num_rows($resultask) == 0) {
                $sqlg2 =  "INSERT INTO mangagenders_manga (Manga_ID, MangaGenders_ID, counter) VALUES('$manga', '$id',3);";
            } else {
                $sqlg2 =  "UPDATE mangagenders_manga SET MangaGenders_ID = '$id' WHERE Manga_ID = '$manga' AND counter = 3;";
            }
        }
    }
    if (isset($_POST['genre3'])) {

        $genre3 =  mysqli_real_escape_string($conn, $_POST['genre3']);
        if (isset($genre3) &&  empty($genre3)) {
            header("location: ../manga.php?manga=" . $manga . "&error=emptyinput");
            die();
        }
        if(isset($genre3) && invalidgenre($genre3) !== false){
            header("location: ../manga.php?manga=" . $manga . "&error=invalidname");
            exit();
            die();
        }
        $chckexist = "SELECT * FROM mangagenders WHERE Name = '$genre3';";
        $rexist = mysqli_query($conn, $chckexist);
        if (mysqli_num_rows($rexist) > 0) {

            $sqlgnr = "SELECT g_ID FROM mangagenders WHERE Name = '$genre3';";
            $rgnr = mysqli_query($conn, $sqlgnr);
            $gnrid = mysqli_fetch_all($rgnr);
            $id = $gnrid[0][0];
            $sqlask =  "SELECT * FROM mangagenders_manga WHERE Manga_ID = '$manga' AND counter = 4;";
            $resultask =  mysqli_query($conn, $sqlask);
            if (mysqli_num_rows($resultask) == NULL || mysqli_num_rows($resultask) == 0) {
                $sqlg3 =  "INSERT INTO mangagenders_manga (Manga_ID, MangaGenders_ID, counter) VALUES('$manga', '$id',4);";
            } else {
                $sqlg3 =  "UPDATE mangagenders_manga SET MangaGenders_ID = '$id' WHERE Manga_ID = '$manga' AND counter = 4;";
            }
        } else {
            $sqlnewgnr = "INSERT INTO mangagenders (Name, image) VALUES('$genre3','$manga');";
            $resultnewgnr = mysqli_query($conn, $sqlnewgnr);
            $sqlgetnewgnr = "SELECT g_ID FROM mangagenders WHERE Name = '$genre3';";
            $resultnewid = mysqli_query($conn, $sqlgetnewgnr);
            $newid = mysqli_fetch_all($resultnewid);

            $id = $newid[0][0];
            $sqlask =  "SELECT * FROM mangagenders_manga WHERE Manga_ID = '$manga' AND counter = 4;";
            $resultask =  mysqli_query($conn, $sqlask);
            if (mysqli_num_rows($resultask) == NULL || mysqli_num_rows($resultask) == 0) {
                $sqlg3 =  "INSERT INTO mangagenders_manga (Manga_ID, MangaGenders_ID, counter) VALUES('$manga', '$id',4);";
            } else {
                $sqlg3 =  "UPDATE mangagenders_manga SET MangaGenders_ID = '$id' WHERE Manga_ID = '$manga' AND counter = 4;";
            }
        }
    }
    if (isset($_POST['genre4'])) {
        $genre4 =  mysqli_real_escape_string($conn, $_POST['genre4']);
        if (isset($genre4) &&  empty($genre4)) {
            header("location: ../manga.php?manga=" . $manga . "&error=emptyinput");
            die();
        }
     
        if(isset($genre4) && invalidgenre($genre4) !== false){
            header("location: ../manga.php?manga=" . $manga . "&error=invalidname");
            exit();
            die();
        }
        $chckexist = "SELECT * FROM mangagenders WHERE Name = '$genre4';";
        $rexist = mysqli_query($conn, $chckexist);
        if (mysqli_num_rows($rexist) > 0) {

            $sqlgnr = "SELECT g_ID FROM mangagenders WHERE Name = '$genre4';";
            $rgnr = mysqli_query($conn, $sqlgnr);
            $gnrid = mysqli_fetch_all($rgnr);
            $id = $gnrid[0][0];
            $sqlask =  "SELECT * FROM mangagenders_manga WHERE Manga_ID = '$manga' AND counter = 5;";
            $resultask =  mysqli_query($conn, $sqlask);
            if (mysqli_num_rows($resultask) == NULL || mysqli_num_rows($resultask) == 0) {
                $sqlg4 =  "INSERT INTO mangagenders_manga (Manga_ID, MangaGenders_ID, counter) VALUES('$manga', '$id',5);";
            } else {
                $sqlg4 =  "UPDATE mangagenders_manga SET MangaGenders_ID = '$id' WHERE Manga_ID = '$manga' AND counter = 5;";
            }
        } else {
            $sqlnewgnr = "INSERT INTO mangagenders (Name, image) VALUES('$genre4','$manga');";
            $resultnewgnr = mysqli_query($conn, $sqlnewgnr);
            $sqlgetnewgnr = "SELECT g_ID FROM mangagenders WHERE Name = '$genre4';";
            $resultnewid = mysqli_query($conn, $sqlgetnewgnr);
            $newid = mysqli_fetch_all($resultnewid);

            $id = $newid[0][0];
            $sqlask =  "SELECT * FROM mangagenders_manga WHERE Manga_ID = '$manga' AND counter = 5;";
            $resultask =  mysqli_query($conn, $sqlask);
            if (mysqli_num_rows($resultask) == NULL || mysqli_num_rows($resultask) == 0) {
                $sqlg4 =  "INSERT INTO mangagenders_manga (Manga_ID, MangaGenders_ID, counter) VALUES('$manga', '$id',5);";
            } else {
                $sqlg4 =  "UPDATE mangagenders_manga SET MangaGenders_ID = '$id' WHERE Manga_ID = '$manga' AND counter = 5;";
            }
        }
    }
    if (invalidtitle($title)) {
        header("location: ../manga.php?manga=" . $manga . "&error=titleinvalid");
        die();
    }

    if (empty(trim($description))) {
        header("location: ../manga.php?manga=" . $manga . "&error=empty");
        die();
    }
    if (isset($genre0) &&  empty($genre0)) {
        header("location: ../manga.php?manga=" . $manga . "&error=emptyinput");
        die();
    }
    if (isset($genre1) &&  empty($genre1)) {
        header("location: ../manga.php?manga=" . $manga . "&error=emptyinput");
        die();
    }
    if (isset($genre2) &&  empty($genre2)) {
        header("location: ../manga.php?manga=" . $manga . "&error=emptyinput");
        die();
    }
    if (isset($genre3) &&  empty($genre3)) {
        header("location: ../manga.php?manga=" . $manga . "&error=emptyinput");
        die();
    }
    if (isset($genre4) &&  empty($genre4)) {
        header("location: ../manga.php?manga=" . $manga . "&error=emptyinput");
        die();
    }
 
 

    if(isset($genre0) && invalidgenre($genre0) !== false){
		header("location: ../manga.php?manga=" . $manga . "&error=invalidname");
		exit();
        die();
	}
    
    if(isset($genre1) && invalidgenre($genre1) !== false){
		header("location: ../manga.php?manga=" . $manga . "&error=invalidname");
		exit();
        die();
	}
    
    
    if(isset($genre2) && invalidgenre($genre2) !== false){
		header("location: ../manga.php?manga=" . $manga . "&error=invalidname");
		exit();
        die();
	}
    
    
    if(isset($genre3) && invalidgenre($genre3) !== false){
		header("location: ../manga.php?manga=" . $manga . "&error=invalidname");
		exit();
        die();
	}
    
    
    if(isset($genre4) && invalidgenre($genre4) !== false){
		header("location: ../manga.php?manga=" . $manga . "&error=invalidname");
		exit();
        die();
	}
    
    
    $isql = "UPDATE manga SET title = '$title', description = '$description', lastUpdate = NOW() WHERE ID = '$manga';" . $sqlg0 . $sqlg1 . $sqlg2 . $sqlg3 . $sqlg4 . ";";

    $ires = mysqli_multi_query($conn, $isql) or die(mysqli_error($conn));

    if ($ires) {
        header("location: ../manga.php?manga=" . $manga . "&error=none");
       
        exit();
    } else {
        header("Location:" . $_SERVER['HTTP_REFERER' . "&error=true"]);
    }
}
