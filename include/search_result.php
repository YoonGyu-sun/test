<?php 
  
  include($_SERVER['DOCUMENT_ROOT'].'/cs/include/dbinfo.php');
?>
<!doctype html>
<head>
<meta charset="UTF-8">
<title>게시판</title>
<link rel="stylesheet" type="text/css" href="/BBS/css/style.css" />
</head>
    
<body>
    
<div id="board_area"> 
    <!-- 18.10.11 검색 추가 -->
    
<?php
      /* 검색 변수 */
    $catagory = $_GET['catgo'];
    $search_con = $_GET['search'];

 if($catagory=='titlet'){
            $catname = '제목';
        } else if($catagory=='namet'){
            $catname = '작성자';
        } else if($catagory=='textt'){
            $catname = '내용';
        } 
?>

<h1> <?php echo $catname; ?>  :  <?php echo $search_con; ?> 검색결과</h1>
    <h4 style="margin-top:30px;"><a href="/cs/index.php">홈으로</a></h4>
    <table class="list-table">
        <thead>
          <tr>
                <th width="70">번호</th>
                <th width="130">제목</th>
                <th width="400">내용</th>
                <th width="120">글쓴이</th>
                <th width="100">작성일</th>
                <th width="100">조회수</th>
            </tr>
        </thead>
<?php
    $stmt = $mysqli->stmt_init();
    $sql = "SELECT * FROM boardt WHERE $catagory like '%$search_con%' order by idx desc";
    $resulta = $mysqli->query($sql);
    while($rowa=$resulta->fetch_array()){

        $title=$rowa['titlet'];
        if(strlen($title)>30){
            $title=str_replace($rowa['titlet'], mb_substr($rowa['titlet'],0,30,"utf-8")."...",$rowa['titlet']);
        }
        
        $sql2 = "SELECT * FROM reply WHERE con_num=".$rowa['idx']."";
        $resultb = $mysqli->query($sql2);
        var_dump($resultb);

        $resultb->fetch();
        ?>
<tbody>
      <tr>
        <td width="70"><?php echo $rowa['idx']; ?></td>
        <td width="500">


<?php
    $boardtime = $rowa['dayt'];
    $timenow = date("Y-m-d");
?>

        <a href='/cs/look.php?idx=<?php echo $boardt["idx"]; ?>'>
        <span style="background:yellow;"> <?php echo $title; ?> </span>
        <span class="re_ct">[<?php echo $resultb;?>] </span></a></td>
        <td width="120"><?php echo $boardt['namet']?></td>
        <td width="100"><?php echo $boardt['dayt']?></td>
        
      </tr>
    </tbody>
 <?php } ?>



    </table>
    <!-- 18.10.11 검색 추가 -->
    <div id="search_box2">
        <form action="/cs/include/search_result.php" method="get">
          <select name="catgo">
            <option value="title">제목</option>
            <option value="name">글쓴이</option>
            <option value="content">내용</option>
          </select>
          <input type="text" name="search" size="40" required="required"/> <button>검색</button>
        </form>
      </div>
    </div>
    </body>
    </html>