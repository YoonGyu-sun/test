<?php 
include($_SERVER['DOCUMENT_ROOT'].'/cs/include/dbinfo.php');
include($_SERVER['DOCUMENT_ROOT'].'/cs/include/ss.php');
?>
<!DOCTYPE html>
<html lang="kr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/cs/css/index_style.css">
    <title>게시판</title>
    <script>
        // Ajax로 서버시간 0.5초마다 출력
            function sendRequest() {
			var httpRequest = new XMLHttpRequest();
			httpRequest.onreadystatechange = function() {
				if (httpRequest.readyState == XMLHttpRequest.DONE && httpRequest.status == 200 ) {
					document.getElementById("text").innerHTML = httpRequest.responseText;
				}
			};
			httpRequest.open("GET", "/cs/include/ajax.php");
			httpRequest.send();
		}
		window.setInterval("sendRequest()", 1);	// 매 0.5초마다 Ajax 요청을 보냄.
        

    </script>

</head>
<body>
    <div id="right"><h3><?php echo "".$_SESSION['loginid']."님"; ?></h3></div>
    
    <h2>게시판입니다.</h2>
    
    <h2 id ="text"></h2>

    <!-- 만약 if(ajax값이 게시판이면 저것을 불러와라 switch문도 생각해볼것) -->
    <form action="/cs/logout.php" method="POST"> 
    <input type="submit" id = "left" value="Logout"></button>
    </form>     

    <!-- 검색입니다. -->
        <h4>검색 버튼</h4>
    <div>
    <form action= "/cs/include/search_result.php" method="get">
    
    <select name = "catgo">
        <option value = "titlet">제목</option>
        <option value = "textt">내용</option>
        <option value = "namet">글쓴이</option>
    </select>


    <label>
    <input type = "text" name = "search" id = "search" required="required" /> <button>검색</button>
    </label>

    </form>
    </div>
    
    <h4>글을 자유롭게 작성해보세요</h4>    

<table>
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

    // 결과 집합의 행 수를 가져오는 코드
    $stmt = $mysqli->stmt_init();
    $sql1 = "SELECT * FROM boardt";
    $result1 = $mysqli->query($sql1);
    $total_posts = $result1->num_rows; // 전체 게시물 수
    $posts_per_page = 8; // 한 페이지에 보여줄 수

    $current_page = isset($_GET['page']) ? $_GET['page'] : 1; // 삼항 현재 페이지 받아오기

    $total_pages = ceil($total_posts / $posts_per_page); // 전체 페이지 수를 계산

    $offset = ($current_page - 1) * $posts_per_page; // 가져올 게시물의 시작 위치
    $sql = "SELECT * FROM boardt ORDER BY idx DESC LIMIT $offset, $posts_per_page";
    $result = $mysqli->query($sql); 


    // START. 이전 페이지와 다음 페이지 링크
    $prev_page = $current_page - 1;
    $next_page = $current_page + 1;

    if ($prev_page < 1) {
        $prev_page = 1;
    }

    if ($next_page > $total_pages) {
        $next_page = $total_pages;
    }

    $prev_link = "<a href='?page=1'>이전</a>";
    $next_link = "<a href='?page=$total_pages'>다음</a>";
    // END. 이전 페이지와 다음 페이지 링크

    // 페이지 번호 링크 만들기
    $page_links = "";

    for ($i = 1; $i <= $total_pages; $i++) {
        if ($i == $current_page) {
            $page_links .= "<strong>$i</strong>";
        } else {
            $page_links .= "<a href='?page=$i'>  $i  </a>";
        }
    }
    // 리스트 페이징하기
    $number = $total_posts - ($current_page - 1) * $posts_per_page;

    // 게시물 출력 코드
    while($row=$result->fetch_array()){            
?>


<tbody>
        <tr onclick="location.href='/cs/look.php?idx=<?php echo $row['idx'];?>'">
        
          <td width="70"><?php echo $number--; ?></td>
          <td width="130"><?php echo $row['titlet']; ?></td>
          <td width="400"><?php echo $row['textt']; ?></td>
          <td width="120"><?php echo $row['namet']; ?></td>
          <td width="100"><?php echo $row['dayt']; ?></td>
          <td width="100"><?php echo $row['lookt']; ?></td>
        </tr>
      </tbody>


    <?php 
         }
         
    ?>


</table>
<?php
    echo $prev_link . "" . $page_links . "" .$next_link;
?>
<br>
<button type="button" onClick="location.href='/cs/create.php'">글쓰기🎁🤢</button>


<?php
    
    $mysqli->close();
?>
</body>
</html>



