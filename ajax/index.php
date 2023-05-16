<!DOCTYPE html>
<html lang="ko">

<head>
	<meta charset="UTF-8">
	<title>Ajax Request</title>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	
</head>
<body>
	<button id="myButton">버튼</button>
	<p id = "view_ajax">

	<script>
	// $(document).ready(function(){
	// 	$("#myButton").click(function(){
	// 		alert("Button clicked!");
	// 	});
	// });

	let count = 0;
            function clickCounter() {
              count++;
              
              if (count === 1) {
                $.ajax({
                  url : "/cs/ajax/ajax.php",
                  type : "POST",
                  data : { data1: 62, count: 1 },
                  success : function(data, status) {
                         $("#view_ajax").html(data);	// 전송받은 데이터와 전송 성공 여부를 보여줌.
                     }
                });

              } else if (count === 2) {

                $.ajax({
				  url : "/cs/ajax/ajax.php",
                  type : "POST",
                  data : { data1: 62, count: 2 },
                  success : function(data, status) {
                         $("#view_ajax").html(data);	// 전송받은 데이터와 전송 성공 여부를 보여줌.
                     }
                });
			}
		}
		
        $(document).ready(function() {
            $("#myButton").click(clickCounter);
        });
    </script>


	
</body>
</html>