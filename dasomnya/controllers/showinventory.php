<?php
$sql = "SELECT * FROM itemsshop RIGHT JOIN userinventory ON itemsshop.ID = userinventory.item_ID WHERE userinventory.user_ID =" . $_SESSION['datos']['ID'] . ";";
$result = mysqli_query($conn, $sql);
$items = array();

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $items[] = $row;
    }
}
$contaritems= count($items);
$_SESSION['itemstotales'] = $contaritems;

foreach ($items as $items) {
    if($_GET['type']==$items['type'] || $_GET['type']=='all'){
        
?>

    <div class="col-sm-4 mb-3 d-flex align-items-stretch">
        <div class="card box varios" style="width:300px">
            <img src="../pointshop/<?php echo $items['imgcode']; ?>.png" class="card-img-top"  width="100px" height="200px" style="margin-top:0px" alt="image">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title" style="margin-top:15px"><?php echo $items['Name']; ?></h5>
                <p class="card-text mb-4"><?php echo $items['Description']; ?></p>
                <button id="<?php echo $items['imgcode'];?>" class="btn btn-primary mt-auto align-self-center">Equipar</button>
            </div>
        </div>
    </div>
    <?php if ($items['type'] == 2) { ?>
    <script type="text/javascript">
   $(document).ready(function(){
    $('#<?php echo $items['imgcode'];?>').click(function(){
        var code = "<?php echo $items['imgcode'];?>";
        var id = <?php echo $_SESSION['datos']['ID']?>;
        $.post("changepfp.php",{
        imgcode: code,
        userid: id
    }, function(data,status){
         window.location.replace('inventario.php?type=all&error=none');
        $("#avatar").attr("src", "../pointshop/<?php echo $items['imgcode'];?>.png");
      return false;

    }
    );
        });
});
 </script>
<?php } if ($items['type'] == 3) { ?>
    <script type="text/javascript">
   $(document).ready(function(){
    $('#<?php echo $items['imgcode'];?>').click(function(){
        var code = "<?php echo $items['imgcode'];?>";
        var id = <?php echo $_SESSION['datos']['ID']?>;
        $.post("changebg.php",{
        imgcode: code,
        userid: id
    }, function(data,status){
         window.location.replace('inventario.php?type=all&error=none1');
      return false;

    }
    );
        });
});
 </script>
<?php } } }?>
