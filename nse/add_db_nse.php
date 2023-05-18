<?php
    include "./include/connect_db.php"; // 데이터 베이스 접속 프로그램 불러오기
    $nse_content = $mysqli->escape_string($_POST['ir1']);
    $sql = "insert into nse_tb(content)";
    $sql .= " values ('{$nse_content}')";
    $res = $mysqli->query($sql);
 
    if($res){
        //입력 성공시
        echo "success";
    } else{
        echo "fail"; // 디비 입력 실패시 fail표시
    }
?>