<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        table {
  border-collapse: collapse;
  width: 100%;
}

td {
  border: 1px solid black;
  padding : 0px;
  text-align: center;
}
#nse{
    margin: 0px;

}

    </style>
</head>
<body>
    
<table>
  <tr>
    <td>제목</td>
    <td>게시글 2</td>
  </tr>
  <tr>
    <td>내용</td>
    <td>
    <form name="nse" id = "nse" action="add_db_nse.php" method="post">
    
    <textarea name="ir1" id="ir1" class="nse_content" ></textarea>
    <script type="text/javascript">
        var oEditors = [];
        nhn.husky.EZCreator.createInIFrame({
            oAppRef: oEditors,
            elPlaceHolder: "ir1",
            sSkinURI: "/cs/nse/nse_files/SmartEditor2Skin.html",
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
</table>

</body>
</html>