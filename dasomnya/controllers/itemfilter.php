<?php
$sql = "SELECT * FROM itemtypes";
$result = mysqli_query($conn, $sql);
$type = array();
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $type[] = $row;
    }
}

foreach ($type as $type) {
?>

    <li class="">
        <a href="?type=<?php echo $type['id'] ?>&page=1" class="nav-link owo12"><?php echo $type['category'] ?></a>
    </li>

<?php } ?>
