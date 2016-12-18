<?php
  @session_start();
  @include("../configdb.php");
  error_reporting(0);
    $id=$_GET['id'];
    $conn = mysql_connect( "$host", "$user", "$pass");
    mysql_select_db("t-shirt");
    $strSQL = "select * from products where product_id='$id'";
    $objParse = mysql_query($strSQL, $conn);
    $objResult = mysql_fetch_array($objParse);
    $name=$objResult['product_name'];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>สินค้า | T-Shirt</title>

    <!-- Bootstrap -->
    <link href="../css/bootstrap.css" rel="stylesheet">
    <!-- mystyle -->
    <link href="../css/mystyle.css" rel="stylesheet">
    <link href="../css/dataTables.bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/etalage.css">

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
                <li><a href="product.php">สินค้าทั้งหมด</a></li>
                <li><a href="newproduct.php">สินค้าใหม่</a></li>
                <li><a href="saleproduct.php">สินค้าลดราคา</a></li>
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
                    $strSQLL = "SELECT * FROM stock join products on stock.product_id=products.product_id join picture on picture.product_id=stock.product_id WHERE stock_id = '".$_SESSION["strProductID"][$i]."' ";
                    $objQueryy = mysql_query($strSQLL)  or die(mysql_error());
                    $objResultt = mysql_fetch_array($objQueryy);
                    $Total = $_SESSION["strQty"][$i] * $objResultt["product_price"];
                    $SumTotal = $SumTotal + $Total;

                ?>
                  <tbody>
                    <tr>
                      <td><img src="../order/ViewImage.php?id=<?php echo $objResultt['product_id'];?>" width="80px"></td>
                      <td><strong style="color:#555"><?php echo $objResultt["product_name"];?></strong><br>รายละเอียด<br><?php echo $_SESSION["strQty"][$i];?>&nbsp;x&nbsp;<?php echo "฿".$objResult["product_price"];?></td>
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


    <div class="list">
      <div class="container">
        <ol class="breadcrumb" style="padding-top:100px;">
          <li><a href="../index.php">หน้าหลัก</a></li>
          <li><a href="product.php">สินค้า</a></li>
          <li class="active"><?php echo $name;?></li>
        </ol>
      </div>
    </div>

    <div class="container" style="padding:20px;">
      <div class="row">
        <?php
        if($_GET['over']=='true'){
        echo '<div class="alert alert-danger" role="alert">ผิดพลาด! ปริมาณที่สินค้ามีไม่เพียงพอ สำหรับปริมาณที่สินค้าที่คุณกรอกเมื่อซักครู่</div>';
        }
        ?>
      <div class="col-md-8" style="float:left;padding:10px;">
        <ul id="show">
          <?php
            $strSQL1 = "select * from picture where product_id='$id'";
            $objParse1 = mysql_query($strSQL1, $conn);
            while($objResult1 = mysql_fetch_array($objParse1)){
          ?>
          <li>
            <img class="etalage_thumb_image" src="ViewImage.php?id=<?php echo $objResult1['pic_id'];?>">
    				<img class="etalage_source_image" src="ViewImage.php?id=<?php echo $objResult1['pic_id'];?>">
    			</li>
          <?php
            }
          ?>
    		</ul>
        <div class="row">
          <div class="col-xs-9 col-sm-12">
            <div class="title">
              <h2 class="filter-title" style="text-align:left">
                <span class="content" style="font-size:16px;letter-spacing:1px;background-color: #fff;padding: 20px;display: inline;"><strong>สินค้าที่คุณอาจสนใจ</strong></span>
              </h2><br><br>
            </div>
            <table width="30%" align="left" style="text-align:center">
                  <tr>
                    <?php
                    $id1=$id+1;
                    $id2=$id+2;
                    $id3=sprintf("%04d",$id1);
                    $id4=sprintf("%04d",$id2);
                    $strSQL = "select * from products where product_id between '$id3' and '$id4'";
                    $query = mysql_query($strSQL, $conn);
                    while ($result = mysql_fetch_array($query)) {
                     ?>
                   <td width="50%">
                     <a href="detailproduct.php?id=<?php echo $result['product_id'];?>"><img src="ViewImage1.php?id=<?php echo $result['product_id'];?>" width="300px"></a>
                     <a href="detailproduct.php?id=<?php echo $result['product_id'];?>"><?php echo $result['product_name']; ?></a>
                     <h4 style="color:#555"><strong><?php echo "฿".$result['product_price']; ?></strong></h4>
                   </td>
                   <?php
                    }
                    ?>
                 </tr>
            </table>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <h2 class="title" style="color:#555"><strong><?php echo $objResult['product_name'];?></strong></h2>
        <h1 class="title"><strong>฿<?php echo $objResult['product_price'];?></strong></h1><br>
        <p><strong style="color:#666">สถานะของสินค้า : </strong>
          <?php
            $strSQL2 = "SELECT * FROM products JOIN stock ON stock.product_id = products.product_id where products.product_id='$id'";
            $objParse2 = mysql_query($strSQL2, $conn);
            $sum=0;
            while($objResult2 = mysql_fetch_array($objParse2)){
              $sum+=$objResult2['stock_amount'];
            }

            if($sum==0) echo '<strong style="color:#FF0000">สินค้าหมด</strong>';
            else echo '<strong style="color:#6f8000">สินค้าพร้อมส่ง</strong>';
          ?>
        </p>
        <?php
          if($sum<=20) echo '<p style="color:#FF0000;font-size:small">*สินค้าเหลือ '.$sum.' ชิ้น</p>';
        ?>
        <p><strong>เลือกไซส์</strong></p>
        <?php
          $strSQL2 = "select * from stock where product_id='$id' and stock_amount!=0";
          $objParse2 = mysql_query($strSQL2, $conn);
          while($objResult2 = mysql_fetch_array($objParse2)){
        ?>
        <form action="../order/order.php" method="POST">
        <div class="radio">
          <label>
            <input type="radio" name="size" id="size" value="<?php echo $objResult2['stock_size'];?>" checked>
            <p class="text-uppercase"><?php echo $objResult2['stock_size'];?></p>
          </label>
        </div>
        <?php
          }
        ?>
        <br><br><br>
        <hr>
        <input type="hidden" value="<?php echo $objResult['product_id'];?>" name="id" >
        <div class="form-inline">
          <div class="form-group">
            จำนวน&nbsp;<input type="number" name="quantity" class="form-control" value="1" style="width:60px;" min="1">&nbsp;ชื้น&nbsp;&nbsp;
          <button type="submit" class="btn btn-default btn-success">หยิบลงตระกร้า</button>
          </div>
        </form>
        </div>
        <hr>
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true" style="padding-top:10px">
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
              <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                  SIZE CHARTS
                </a>
              </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">
                <strong>วิธีวัดขนาดเสื้อ</strong><br>
                  <p style="font-size:small">1. นำเสื้อที่เราใส่ประจำมาวัดความกว้างของเสื้อบริเวณใต้รักแร้ว่ากว้างเท่าไหร่</p>
                  <p style="font-size:small">2. นำความกว้างมา คูณ 2 ก็จะได้ขนาดของ รอบอก (หน่วยเป็นนิ้ว)</p>
                  <p style="font-size:small">3. วิธีวัดความยาว ให้วัดจากคอเสื้อบนสุด ถึง ชายเสื้อล่างสุด</p>
                  <p style="font-size:small">4. นำขนาดที่ได้มาเทียบกับตาราง ก็จะรู้ว่าเราควรเลืือก Size ไหน</p>
                  <img src="../img/size.jpg" width="320px">
              </div>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingTwo">
              <h4 class="panel-title">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  SHIPPING & RETURN
                </a>
              </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
              <div class="panel-body">
                <strong>การเปลี่ยนหรือคืนสินค้า</strong><br>
                <p style="font-size:small">ความพึงพอใจของลูกค้าถือเป็นสิ่งสำคัญที่ทางเราใส่ใจเป็นอย่างมาก พบสินค้ามีตำหนิหรือไม่ถึงพอใจ สามารถเปลี่ยนสินค้าได้ ภายใน 3 วัน หลังได้รับสินค้า โดยสินค้าจะต้องอยู่ในสภาพเดิม ไม่ผ่านการซัก ไม่ผ่านการรีด ไม่ผ่านการใช้งานใดๆมาก่อนโดยติดต่อหาเราได้</p>
            </div>
          </div>
        </div>
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
                                  <a href="../member/login.php">เข้าสู่ระบบและสมัครสมาชิก</a>
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
    <script src="../js/jquery.etalage.min.js"></script>
    <script src="../js/search.js"></script>

    <script>
			$(document).ready(function(){

				$('#show').etalage({
					smallthumbs_position: 'left',
					thumb_image_width: 500,
					thumb_image_height: 500,
					source_image_width: 1200,
					source_image_height: 1200,
					zoom_area_width: 500,
					zoom_area_height: 500,
          autoplay: false,
          smallthumb_hide_single: false
				});

			});
		</script>

    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>

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
