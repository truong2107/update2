
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>DMTD FOOD - Quản lý tài khoản</title>
    
      <link href="../img/DMTD-Food-Logo.jpg" rel="shortcut icon" type="image/x-icon" />
    <link href="../../img/DMTD-Food-Logo.jpg" rel="shortcut icon" type="image/x-icon"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"/>
       <link rel="stylesheet" href="/web/view/user/css/404error.css">
       <script src="js/modal.js"></script>
    
</head>
<body>



        <div class="out">
        </div>
        <div class="content">
        <div class="main">
            <h1 ><strong>404 Error</strong></h1>
            <img src="/web/view/img/cry.png" alt="">
            <h3><p style="font-size:30px;">Oops! Page Not Found</p>
            <p>Sorry, the page you're looking for doesn't exist. Check your url or network.</p></h3>
            <?php $url=$_SERVER['REQUEST_URI'];
                  if(strstr($url,"admin")){
                    echo '<a href="/web/view/admin/accountManage.php"><button class="btn">Return Home</button></a>';
                  } 
                  else{
                    echo '<a href="/web/view/user/home.php"><button class="btn">Return Home</button></a>';
                  } 
            ?>
        </div>
        </div>

</body>
</html>

