<!DOCTYPE html>
<head>
<script src="//code.jquery.com/jquery.min.js"></script>
    <script>
        function add(){
            $.ajax({
                url: "calc.php",
                type: "get",
                data: {
                    a: $('#a').val(),
                    b: $('#b').val(),
                }
            }).done(function(data){
                $('#result').text(data);
            })
        }
    </script>
</head>
<body>
    <input type="number" id="a">
    <input type="number" id="b">
    <button onclick="add()">더하기</button>
    <p id="result"></p>

 
</body>