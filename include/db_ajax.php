<?php
    include($_SERVER['DOCUMENT_ROOT'].'/cs/include/dbinfo.php');
    include($_SERVER['DOCUMENT_ROOT'].'/cs/include/ss.php');
?>

<!DOCTYPE html>
<html lang="kr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
<?php

$save_num = "0";
$var1 = $_POST['data1'];
$var2 = ($_POST['count'] - 1) * 3; 

$session = $_POST['session'];




            $stmt=$mysqli->stmt_init();
            $sql4 = "SELECT * FROM reply WHERE con_num = $var1 ORDER BY idx limit $var2, 3";
            $result = $mysqli->query($sql4);
            while($row2 = $result->fetch_array()){
            
                if($save_num == "0") {
                    //맨 처음 불러온 댓글 중 가장 최상단에 출력된 댓글의 번호를 저장한다.
                    $save_num = $row2['idx'];
                }
                // 닉네. 댓글 등록시간, 댓글 내용순으로 출력    
                ?>
                <!-- // name에는 세션값이 들어가게  content값만 불러오면 된다 -->
                <div><b> <?php echo $row2['name'];?></b></div><br>
                <div> <?php echo $row2['content'];?> </div><br>
                <div> <?php echo $row2['date'];?> </div><br>
<?php            
                if($row2['name'] == $_SESSION['loginid']){?>
                <button type=button onclick="location.href = '/cs/co_update.php';" >댓글 수정</button>
                <button type=button onclick="co_delete()" value="confirm">댓글 삭제</button>
                
                    <?php } ?>
                    <h6>ㅡㅡㅡㅡㅡㅡㅡㅡㅡ</h6>
                    <?php } ?>
    <script>
        function co_delete() {
            if(confirm("삭제하시면 복구할 수 없습니다. 삭제하시겠습니까?")){
                  location.href = "/cs/co_delete.php";
                } else{
                
                }
            }
    </script>
        
</body>
</html>




    

