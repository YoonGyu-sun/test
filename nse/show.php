<?php
    include "./include/connect_db.php";
    $sql = "SELECT * FROM nse_tb ORDER BY no DESC LIMIT 1";
    $res = $mysqli->query($sql);
    $showContent = $res->fetch_array(MYSQLI_ASSOC);
    echo $showContent['content'];
?>