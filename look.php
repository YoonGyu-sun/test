<?php
include($_SERVER['DOCUMENT_ROOT'].'/cs/include/dbinfo.php');
include($_SERVER['DOCUMENT_ROOT'].'/cs/include/ss.php');

// AJAX로 댓글과 수정과 삭제를 비교하여 사용할 수 있도록 변수 선언 후 AJAX로 값 보내기 위함. 
$session = $_SESSION['loginid'];

        // // 조회수 값 올려주기
    $value = $_GET['idx'];

        if(!isset($_SESSION['id'][$value])) {
            // Update the view count for this post
            $stmt = $mysqli->stmt_init();
            $sql1 = "UPDATE boardt SET lookt = lookt + 1 WHERE idx = ?";
            $stmt->prepare($sql1);
            $stmt->bind_param("i", $value);
            $stmt->execute();
        
            // Add this post to the viewed_posts session array
            $_SESSION['id'][$value] = true;
        }

        // 셀렉트 idx 게시물
        $stmt = $mysqli->stmt_init();
        $sql = "SELECT * FROM boardt WHERE idx = $value";
        $result = $mysqli->query($sql);
        $row=$result->fetch_array();

        // 게시물 댓글 count
        $stmt = $mysqli->stmt_init();
        $sql6 = "SELECT count(con_num) FROM reply WHERE con_num= ? ";
        $stmt->prepare($sql6);        
        $stmt->bind_param("i", $value);        
        $stmt->execute();        
        $stmt->bind_result($count);    
        $stmt->fetch();
        $namet = $row['namet'];
// 위 변수 선언은 굳이 할 필요 없는데 해버려서 냅둔 거





?>
<!DOCTYPE html>
<html lang="kr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" >
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="\cs\css\look_style.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <title> 글 </title>


    <style>

table, th, td {
  border: 1px solid black;
}
.nse_content{width:660px;height:500px}

</style>

</head>

<body>
    <a href = "/cs/index.php"><h1> 자유게시판 <h1></a>
    
        <div>작성자: <?php echo $namet;?>&nbsp;&nbsp;</div> 
        <div><?php echo $row['dayt'];?>&nbsp;&nbsp;</div>
        <div id ="static">조회: <?php echo $row['lookt'];?>&nbsp;&nbsp;</div>
    
    <br>
    
    <h2><?php echo $row['titlet'];?></h2>
    <div><h3><?php echo $row['textt'];?></h3></div>
    
    <tr onclick="location.href='/cs/look.php?idx=<?php echo $row['idx']; ?>'">
    <button type="button" onclick="location.href='/cs/index.php'">목록</button>
    <?php
    if($namet == $_SESSION['loginid']){?>
        <button type="button" onclick="location.href='/cs/update.php?idx=<?php echo $row['idx'];?>'">수정</button>
        <button type="button" onclick="location.href='/cs/delete.php?idx=<?php echo $row['idx'];?>'">삭제</button>
    <?php }?>

    <!-- 댓글은 먼저 띄우고 싶다면 여기다가 $row로 글 넣어주고 (include/ajax.php의 33번부터 39번까지 넣어주면 됨. ) db_ajax.php에서 limit 값을 올려서 변경해도 된다.-->

    <p id = "view_ajax">
    <div><button onclick = "clickCounter()" style="cursor:pointer" >댓글 보기</button></div>                  

        
<!-- AJAX를 활용한 댓글 script-->
<script>
    let count = 0;
    var session = "<?php echo $session; ?>";
    
    var php_con_num = "<?php echo $value; ?>";
    var php_count_num_1 = "<?php echo $count; ?>";
    var php_count_num_2 = (php_count_num_1 / 3) + 1;

        function clickCounter() {
          count++;
        
          if (count <= php_count_num_2) {
            $.ajax({
              url : "/cs/include/db_ajax.php",
              type : "POST",
              data : { session: session, data1: php_con_num, count: count },
              success : function(data, status) {
                $("#view_ajax").append(data);    // 전송받은 데이터와 전송 성공 여부를 보여줌.
              }
            });
          }
        }
                $(document).ready(function() {
                    $("#myButton").click(clickCounter);
                });
</script>


<!-- 댓글 작성하기 -->
        <div class = "answer_view">
            <label for = "story"> 댓글을 작성하세요 </label>
    
            <form action="/cs/answering.php?idx= <?php echo $row['idx']?>" method="POST">
        <textarea id="content" name="content" rows="10" cols="43"></textarea>
        <input type="submit" value="댓글"></input>
            </form>
        </div>
        
        <script type="text/javascript" src="/cs/nse/nse_files/js/HuskyEZCreator.js" charset="utf-8"></script>
</head>



<p>
    <form name="nse" action="./nse/add_db_nse.php" method="post">
    
    <table>
  <tr>
    <td>내용</td>
    <td>
    <textarea name="ir1" id="ir1" class="nse_content" rows="10" cols="100"></textarea>
    <script type="text/javascript">
        var oEditors = [];
        nhn.husky.EZCreator.createInIFrame({
            oAppRef: oEditors,
            elPlaceHolder: "ir1",
            sSkinURI: "./nse/nse_files/SmartEditor2Skin.html",
            fCreator: "createSEditor2"
        });
        function submitContents(elClickedObj) {
            // 에디터의 내용이 textarea에 적용됩니다.
            oEditors.getById["ir1"].exec("UPDATE_CONTENTS_FIELD", []);
            // 에디터의 내용에 대한 값 검증은 이곳에서 document.getElementById("ir1").value를 이용해서 처리하면 됩니다.
        
            try {
                elClickedObj.form.submit();
    } catch(e) {}
}
</script>

    </td>
  </tr>
  <tr>
    <td>첨부파일 및 전송</td>
    <td><input type="submit" onclick="submitContents(this)" value="전송" /></td>
  </tr>
</table>
</p>
</form>
</body>
</html>

