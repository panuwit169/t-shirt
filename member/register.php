<?php
  @session_start();
  error_reporting(0);
  @include("../configdb.php");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>สมัครสมาชิก | T-Shirt</title>

    <!-- Bootstrap -->
    <link href="../css/bootstrap.css" rel="stylesheet">
    <!-- mystyle -->
    <link href="../css/mystyle.css" rel="stylesheet">

  </head>
  <body>

    <nav class="navbar navbar-default navbar-fixed-top navbar-bootsnipp animate" role="navigation">
      <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-brand-centered">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <div class="navbar-brand">
            <a href="../index.php"><img src="../img/logo.png" /></a>
          </div>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="navbar-brand-centered">
          <ul class="nav navbar-nav">
            <li><a href="../index.php">หน้าหลัก</a>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">สินค้า <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="../product/product.php">สินค้าทั้งหมด</a></li>
                <li><a href="../product/newproduct.php">สินค้าใหม่</a></li>
                <li><a href="../product/saleproduct.php">สินค้าลดราคา</a></li>
              </ul>
            </li>
            <li><a href="../payment/confirm-payment.php">แจ้งการชำระเงิน</a>
            </li>
            <li><a href="../contact/contact.php">ติดต่อเรา</a>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <?php
              if($_SESSION['id']!=""){
                echo '<li><a href="../member/account.php">บัญชีผู้ใช้งาน</a><li>';
                echo '<li><a href="../member/logout.php">ออกจากระบบ</a><li>';
              }
              else {
                echo '<li><a href="../member/login.php">บัญชีผู้ใช้งาน</a><li>';
                echo '<li><a href="../member/login.php">เข้าสู่ระบบ</a><li>';
              }
            ?>
            <li class="visible-xs">
              <form action="#" method="POST" role="search">
                <div class="input-group">
                  <input type="text" class="form-control" name="q" placeholder="ค้นหา...">
                  <span class="input-group-btn">
                    <button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                    <button class="btn btn-danger" type="reset"><span class="glyphicon glyphicon-remove"></span></button>
                  </span>
                </div>
              </form>
            </li>
            <li class="hidden-xs"><a href="#toggle-search" class="animate"><span class="glyphicon glyphicon-search"></span></a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span></a>
              <ul class="dropdown-menu">
                <?php
                  if(!isset($_SESSION["intLine"])||$_SESSION["count"]==0)
                  {
                ?>
                    <p align="center" style="padding-top:20px;padding-left:20px;padding-right:20px">คุณยังไม่มีสินค้าในรถเข็น</p>
                  <?php
                  }
                  else
                  {
                ?>
                <table class="table">
                  <thead>
                    <tr>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                <?php
                mysql_connect("$host","$user","$pass");
                mysql_select_db("t-shirt");
                for($i=0;$i<=(int)$_SESSION["intLine"];$i++)
                {
                  if($_SESSION["strProductID"][$i] != "")
                  {
                    $strSQL = "SELECT * FROM stock join products on stock.product_id=products.product_id join picture on picture.product_id=stock.product_id WHERE stock_id = '".$_SESSION["strProductID"][$i]."' ";
                    $objQuery = mysql_query($strSQL)  or die(mysql_error());
                    $objResult = mysql_fetch_array($objQuery);
                    $Total = $_SESSION["strQty"][$i] * $objResult["product_price"];
                    $SumTotal = $SumTotal + $Total;

                ?>
                  <tbody>
                    <tr>
                      <td><img src="../order/ViewImage.php?id=<?php echo $objResult['product_id'];?>" width="80px"></td>
                      <td><strong style="color:#555"><?php echo $objResult["product_name"];?></strong><br>รายละเอียด<br><?php echo $_SESSION["strQty"][$i];?>&nbsp;x&nbsp;<?php echo "฿".$objResult["product_price"];?></td>
                    </tr>

                  <?php
                  }
                }
                ?>
                <tr>
                  <td colspan="2" align="center"><h4 style="color:#555">ยอดรวม:</h4><h4><?php echo "฿".number_format($SumTotal,2);?></h4><br><a href="../order/show.php"><button class="btn btn-default">ดูรถเข็น</button></a><a href="../order/checkout.php"><button class="btn btn-default">สั่งซื้อสินค้า</button></a></td>
                </tr>
                </tbody>
                </table>
                <?php
                  }
                ?>
              </ul>
            </li>
            </li>
          </ul>
        </div>
        <!-- /.navbar-collapse -->
      </div>
      <!-- /.container-fluid -->
      <div class="bootsnipp-search animate">
        <div class="container">
          <form action="../search/search.php" method="POST" role="search">
            <div class="input-group">
              <input type="text" class="form-control" name="q" placeholder="ค้นหา...">
              <span class="input-group-btn">
                <button class="btn btn-danger" type="reset"><span class="glyphicon glyphicon-remove"></span></button>
              </span>
            </div>
          </form>
        </div>
      </div>
    </nav>


    <div style="padding-top:120px;padding-bottom:60px;background-color: #fff;">
      <div class="container">
        <div class="title">
          <h2 class="filter-title" style="text-align:left">

            <span class="content" style="font-size:16px;letter-spacing:1px;background-color: #fff;padding: 20px;display: inline;"><strong>สมัครสมาชิก</strong></span>
          </h2><br>
          <div class="col-md-12">
            <form action="saveregister.php" method="POST">
            <h4>ข้อมูลส่วนตัว</h4><br>
              <div class="col-xs-6" >
                  <label for="name">ชื่อ</label>
                  <input type="text" class="form-control" id="name" name="name" required maxlength="30">
              </div>
              <div class="col-xs-6" style="padding-bottom:10px">
                <label for="lname">นามสกุล</label>
                <input type="text" class="form-control" id="lname" name="lname" required maxlength="30">
              </div>
              <div class="col-xs-12" style="padding-bottom:30px">
                <label for="email">อีเมล์</label>
                <input type="email" class="form-control" id="email" name="email" required maxlength="20">
              </div>
              <h4>ข้อมูลการเข้าสู่ระบบ</h4>
                <div class="col-xs-12" style="padding-bottom:20px">
                  <label for="password">รหัสผ่าน</label>
                  <input type="password" class="form-control" id="password" name="password" required maxlength="10">
                </div>
                <div class="form-group" style="padding-right:15px">
                <button type="submit" class="btn btn-default pull-right">ยืนยัน</button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>


    <footer class="footer footer-big footer-color-black">
        <div class="container">
            <div class="row">
                <div class="col-md-2 col-sm-3">
                    <div class="info">
                        <h5 class="title">ABOUT</h5>
                        <nav>
                            <ul>
                              <li>
                                  <a href="../etc/about.php">เกี่ยวกับเรา</a></li>
                              <li>
                                  <a href="../contact/contact.php">ติดต่อเรา</a>
                              </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-md-3 col-md-offset-1 col-sm-3">
                    <div class="info">
                        <h5 class="title"> บริการลูกค้า</h5>
                         <nav>
                            <ul>
                              <li>
                                  <a href="login.php">เข้าสู่ระบบและสมัครสมาชิก</a>
                              </li>
                              <li>
                                  <a href="../etc/how-to-order.php">ขั้นตอนการสั่งซื้อ</a>
                              </li>
                              <li>
                                  <a href="../etc/shipping.php">การจัดส่งสินค้า</a>
                              </li>
                              <li>
                                  <a href="http://track.thailandpost.co.th/tracking/default.aspx" target="_blank">ตรวจสอบสถานะสินค้า</a>
                              </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="info">
                        <nav>
                          <div class="fb-page" data-href="https://www.facebook.com/facebook"data-width="500" data-hide-cover="false"data-show-facepile="true" data-show-posts="false"></div>
                        </nav>
                    </div>
                </div>
            </div>
            <hr style="border-top: 1px solid #333;">
            <div class="copyright">
                 <script> document.write(new Date().getFullYear()) </script> <a href="https://www.facebook.com/groups/InformationTechnology/?fref=ts">IT@KMUTNB</a>, <a href="https://www.facebook.com/mildpanuwit.ynwa">Panuwit Sattayawatanagul</a>
            </div>
        </div>
    </footer>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../js/bootstrap.min.js"></script>
    <!-- /.myjs -->
    <script src="../js/myjs.js"></script>
    <script src="../js/jquery-1.9.1.min.js"></script>
    <script src="../js/search.js"></script>
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/th_TH/sdk.js#xfbml=1&version=v2.8";
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
    </script>
  </body>
</html>
