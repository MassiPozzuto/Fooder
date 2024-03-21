<?php



if (!isset($_GET['type']) || !isset($_GET['page'])) {
?><script>
    window.location.href = 'tienda.php?type=all&page=1';
  </script> ?>
<?php
}
if (isset($_GET['lowest']) == NULL || isset($_GET['highest']) == NULL) {
  $filterprice = "";
  $fplink = "";
}
if (isset($_GET['lowest']) == 'true') {
  $filterprice = "ORDER BY price ASC";
  $fplink = "&lowest=true";
}
if (isset($_GET['highest']) == 'true') {
  $filterprice = "ORDER BY price DESC";
  $fplink = "&highest=true";
}

if ($_GET['type'] == 'all') {
  $reqtype = "";
}

if ($_GET['type'] == '1') {
  $reqtype = "AND type = 1";
}
if ($_GET['type'] == '2') {
  $reqtype = "AND type = 2";
}
if ($_GET['type'] == '3') {
  $reqtype = "AND type = 3";
}
if ($_GET['type'] > 3) {
  $reqtype = "";
}
if (!isset($_GET['page']) || isset($_GET['page']) == NULL || $_GET['page'] == '') {

  $page_number = 1;
} else {

  $page_number = $_GET['page'];
}
$limite = 6;

$initial_page = ($page_number - 1) * $limite;

$sqlget = "SELECT * FROM itemsshop WHERE showitem = 1 " . $reqtype . "  " . $filterprice . ";";
$resultget = mysqli_query($conn, $sqlget);
$sql = "SELECT * FROM itemsshop WHERE showitem = 1 " . $reqtype . "  " . $filterprice . " LIMIT " . $initial_page . ',' . $limite . ";";
$result = mysqli_query($conn, $sql);
$items = array();
if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    $items[] = $row;
  }
}
$total_rows = mysqli_num_rows($resultget);
$total_pages = ceil($total_rows / $limite);


foreach ($items as $items) {

?>
  <div class="col-sm-4 mb-3 d-flex align-items-stretch">
    <div class="card box varios">
       <img src="../pointshop/<?php echo $items['imgcode'] ?>.png" class="card-img-top"  width="100px" height="300px"style="margin-top:0px " alt="image"> 
      <div class="card-body d-flex flex-column">
        <h5 class="card-title"  style="margin-top:15px   "><?php echo $items['Name'] ?></h5>
        <p class="card-text mb-4" style="margin-top:25px   "><?php echo $items['Description'] ?></p>
        <?php
        if (isset($_SESSION['datos'])) {
          $sql1 = "SELECT * FROM itemsshop INNER JOIN userinventory ON itemsshop.ID = userinventory.item_ID WHERE userinventory.user_ID =" . $_SESSION['datos']['ID'] . " AND itemsshop.ID =" . $items['ID'] . ";";

          $result1 = mysqli_query($conn, $sql1);
          $row1 = mysqli_fetch_assoc($result1);
          if (isset($row1['user_ID']) && $row1['user_ID'] == $_SESSION['datos']['ID']) {
        ?>
            <a href="#" class="btn btn-primary disabled" style="margin-top:50px"  ><?php echo "Obtenido" ?></a>
          <?php } else { ?>
            <a href="comprar.php?itemid=<?php echo $items['ID'] ?>" class="btn btn-primary" style="margin-top:50px"><?php echo $items['Price'] ?> <img src="../img/cattus_coin.png" width="20" height="20"></a>
          <?php }
        } else if (isset($_SESSION['datos']) == false) { ?><a href="login.php" class="btn btn-primary mt-auto align-self-"><?php echo $items['Price'] . "<img src='../img/cattus_coin.png' width='20' height='20'></a>";
                                                                                                                                            } ?></a>
      </div>
    </div>
  </div>

<?php }
?>