<?php

include($_SERVER['DOCUMENT_ROOT'].'/cs/include/dbinfo.php');
include($_SERVER['DOCUMENT_ROOT'].'/cs/include/ss.php');


        // // 조회수 값 올려주기
        
        if(!isset($_SESSION['id'][$_GET['idx']])) {
            // Update the view count for this post
            $stmt = $mysqli->stmt_init();
            $sql1 = "UPDATE boardt SET lookt = lookt + 1 WHERE idx = ?";
            $stmt->prepare($sql1);
            $stmt->bind_param("i", $_GET['idx']);
            $stmt->execute();
        
            // Add this post to the viewed_posts session array
            $_SESSION['id'][$_GET['idx']] = true;
        }

    

        // 셀렉트 idx 게시물
        $stmt = $mysqli->stmt_init();
        $sql = "SELECT * FROM boardt WHERE idx={$_GET['idx']}";
        $result = $mysqli->query($sql);
        $row=$result->fetch_array();
        
        

?>
<!DOCTYPE html>
<html lang="kr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" >
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style_css\look_style.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title> 글 </title>


    <!-- JQuery와 ajax -->
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script>
    $(function() {
        $("#requestBtn").on("click", function() {
            $("#text").load("/cs/answering.php");
        });
    });
</script>


</head>
<body>

    <h1> 자유게시판 <h1>
    
        <div>작성자: <?php echo $row['namet'];?>&nbsp;&nbsp;</div> 
        <div><?php echo $row['dayt'];?>&nbsp;&nbsp;</div>
        <div id ="static">조회: <?php echo $row['lookt'];?>&nbsp;&nbsp;</div>
    
    <br>
    
    <h2><?php echo $row['titlet'];?></h2>
    <div><h3><?php echo $row['textt'];?></h3></div>
    

    <tr onclick="location.href='/cs/look.php?idx=<?php echo $row['idx']; ?>'">
    <button type="button" onclick="location.href='/cs/index.php'">목록</button>
    <?php
    if($row['namet'] == $_SESSION['loginid']){?>
        <button type="button" onclick="location.href='/cs/update.php?idx=<?php echo $row['idx'];?>'">수정</button>
        <button type="button" onclick="location.href='/cs/delete.php?idx=<?php echo $row['idx'];?>'">삭제</button>
    <?php }?>


    <!-- 댓글 불러오기 -->
    <div class = "view">
        <h1 id = "answer_main">댓글목록</h1>
        <?php 
            $stmt=$mysqli->stmt_init();
            $sql3 = "SELECT * FROM reply WHERE con_num = {$_GET['idx']} ORDER BY idx ASC limit 10";
            $result = $mysqli->query($sql3);
            while($row2 = $result->fetch_array()){
            
                ?>
                <!-- // name에는 세션값이 들어가게  content값만 불러오면 된다 -->
                <div><b> <?php echo $row2['name'];?></b></div><br>
                <div> <?php echo $row2['content'];?> </div><br>
                <div> <?php echo $row2['date'];?> </div><br>
                
                <a href = "#"> 댓글 수정</a>
                <a href = "#"> 댓글 삭제</a>
                <h6>ㅡㅡㅡㅡㅡㅡㅡㅡㅡ</h6>
                    <?php } ?>
                
                    
        
        
        


        </div>

                




<!-- 댓글 작성하기 -->
        <div class = "answer_view">
            <label for = "story"> 댓글은 작성하세요 </label>
    
            <form action="/cs/answering.php?idx= <?php echo $row['idx']?>" method="POST">
        <textarea id="content" name="content" rows="10" cols="43"></textarea>
        <input type="submit" value="댓글"></input>
            </form>
        
    
        </div>
</body>
</html>

