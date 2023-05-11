<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="UTF-8">
<title>Ajax Intro</title>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script>
    $(function() {
        $("#requestBtn").on("click", function() {
            $("#text").load("/cs/ajax/test.php");
        });
    });
</script>
</head>
 
<body>
<h1>Ajax(Asynchronous JavaScript and XML)</h1>
<p id="text">이 단락에 다른 텍스트를 불러와보죠!</p>
<button id="requestBtn">데이터 불러오기!</button>
</body>
</html>