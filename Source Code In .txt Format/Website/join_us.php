<html xmlns="https://www.w3.org/1999/xhtml">
<head>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Join Us</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<link rel="stylesheet" href="./css/myStyle.css" />
    <link rel="stylesheet" href="./css/layout.css" />
    <link rel="stylesheet" href="./css/viewRestaurant.css" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
<style>
.mail .container{
 width:600px; 
}
.mail{
 font-family:微軟正黑體;
 font-size:22px;
}
input[type=email] {
    width: 300px;
    box-sizing: border-box; 
}

#bodyText{
    width: 350px;
    box-sizing: border-box;
    border: 1px solid #888;
}
</style>
<script>
        function checkForm() {
            if (document.getElementById("LastName").value == "") {
                alert("Enter LastName, please!");
                return false;
            } else if (document.getElementById("FirstName").value == "") {
                alert("Enter FirstName, please!");
                return false;
            } else if (document.getElementById("emailText").value == "") {
                alert("Enter email, please!");
                return false;
            } else if (document.getElementById("subText").value == "") {
                alert("Enter Company / Restaurant name, please!");
                return false;
            } else if (document.getElementById("bodyText").value == "") {
                alert("Enter information, please!");
                return false;
            }
            submitHandler();
            return true;

        }
</script>
<script>
//宣告預設表單內容為空 （你想要的話也可以加東西）
    var initSubject='',initBody='', initTo='';
 
    //按下傳送按鈕後執行
    function submitHandler(){
        var to = "180162421@stu.vtc.edu.hk";//寫死的傳送對象 就是公司的信箱 不會顯示在網頁上
        var LastName = $('#LastName').val();//讀取ID為 nameTextuser 物件中的值
        var FirstName = $('#FirstName').val();//讀取ID為 nameTextuser 物件中的值
        var emailText = $('#emailText').val();
        var telText = $('#telText').val();
        var subject = $('#subText').val() + " - Apply for trial";
        var bodyText = $('#bodyText').val();
//把user填的資料都塞到 mail body 中
        var body = ""+bodyText+'%0A%0A%0A';//%0A是換行 換了三行
            body += "From："+LastName+' '+FirstName+'%0A';
            body += "Email："+emailText+'%0A';
            body += "Tel："+telText;
//傳送的主要程式碼
        mailTo.href="mailto:"+to+"?subject="+subject+"&body="+body;
        mailTo.click();
    }
//在body onload
    function init(){
        subText.value=initSubject;
        bodyText.value=initBody;
    }
</script>

<script type="text/javascript">
$(document).ready(function(){

});

</script>
</head>


<body onload="init()">
    
    <?php
            include_once('./template/header.php');
            ?>

<div id="main">            
<div class="mail">
    <div class="container">
        <div class="header" style="text-align:center; font-size:50px; padding:30px 0">
        Free Trial
        </div>
     <form id="msg" name="msg" enctype="text/plain" accept-charset="utf-8" onsubmit="return checkForm();">
    <!-- 寄件者姓名    -->
    <div class="form-group">
     <label for="LastName">Last Name *</label>
     <input id="LastName" type="text" name="LastName" class="form-control" value size="60" placeholder="Last Name *" required="required" />  <!-- required 必填欄位 ，placeholder 預設內容--> 
     </div>
     
     <div class="form-group">
     <label for="FirstName">First Name *</label>
     <input id="FirstName" type="text" name="FirstName" class="form-control" value size="60" placeholder="First Name *" required>  <!-- required 必填欄位 ，placeholder 預設內容--> 
     </div>
     
     <!-- 寄件者電話 -->
     <div class="form-group">
         <label for="telText">Telephone Number *</label>
     <input id="telText"type="tel" name="Phone" class="form-control" value size="60" aria-invalid="false" placeholder="Telephone Number *" required>
     </div>
     
     <!-- 寄件者email -->
     <div class="form-group">
         <label for="emailText">Email *</label>
     <input id="emailText" type="email" name="Email" class="form-control" value size="60" placeholder="Email *" required>
     </div>
     
     <!-- 郵件主旨 -->
     <div class="form-group">
         <label for="subText">Company / Restaurant name *</label>
     <input  id="subText" type="text" name="Subject" class="form-control" value size="60" aria-invalid="false" placeholder="Company / Restaurant name *" required>
     </div>        
     
     <!-- 郵件內容 -->
     <div class="form-group">
         <label for="bodyText">For more information (please briefly describe your requirements *)</label>
     <textarea id="bodyText" name="your-message" class="form-control" cols="40" rows="10"  aria-required="true" aria-invalid="false" placeholder="For more information (please briefly describe your requirements *)" required></textarea>
     </div>
     
     <!-- 傳送按鈕 -->
     <center>
     <div>
         <input class="btn" type="submit" value="Apply for a trial now" onClick="" />
         <a id="mailTo"></a>
     </div>
     </center>
 </form>
    </div>
</div>
</div>
<?php
            include_once('./template/footer.php');
        ?>
</body>
</html>