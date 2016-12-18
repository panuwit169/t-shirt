<?php
  @session_start();
  error_reporting(0);
  @include("configdb.php");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>T-Shirt</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- mystyle -->
    <link href="css/mystyle.css" rel="stylesheet">
    <link href="css/owl.carousel.css" rel="stylesheet">
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
            <a href="index.php"><img src="img/logo.png" /></a>
          </div>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="navbar-brand-centered">
          <ul class="nav navbar-nav">
            <li><a href="index.php">หน้าหลัก</a>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">สินค้า <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="product/product.php">สินค้าทั้งหมด</a></li>
                <li><a href="product/newproduct.php">สินค้าใหม่</a></li>
                <li><a href="product/saleproduct.php">สินค้าลดราคา</a></li>
              </ul>
            </li>
            <li><a href="payment/confirm-payment.php">แจ้งการชำระเงิน</a>
            </li>
            <li><a href="contact/contact.php">ติดต่อเรา</a>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <?php
              if($_SESSION['id']!=""){
                echo '<li><a href="member/account.php">บัญชีผู้ใช้งาน</a><li>';
                echo '<li><a href="member/logout.php">ออกจากระบบ</a><li>';
              }
              else {
                echo '<li><a href="member/login.php">บัญชีผู้ใช้งาน</a><li>';
                echo '<li><a href="member/login.php">เข้าสู่ระบบ</a><li>';
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
                      <td><img src="order/ViewImage.php?id=<?php echo $objResult['product_id'];?>" width="80px"></td>
                      <td><strong style="color:#555"><?php echo $objResult["product_name"];?></strong><br>รายละเอียด<br><?php echo $_SESSION["strQty"][$i];?>&nbsp;x&nbsp;<?php echo "฿".$objResult["product_price"];?></td>
                    </tr>

                  <?php
              	  }
                }
                ?>
                <tr>
                  <td colspan="2" align="center"><h4 style="color:#555">ยอดรวม:</h4><h4><?php echo "฿".number_format($SumTotal,2);?></h4><br><a href="order/show.php"><button class="btn btn-default">ดูรถเข็น</button></a><a href="order/checkout.php"><button class="btn btn-default">สั่งซื้อสินค้า</button></a></td>
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
          <form action="search/search.php" method="POST" role="search">
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



    <div style="padding-top:90px;">
        <!-- Jssor Slider Begin -->
        <!-- To move inline styles to css file/block, please specify a class name for each element. -->
        <!-- ================================================== -->
        <div id="slider1_container" style="visibility: hidden; position: relative; margin: 0 auto;
        top: 0px; left: 0px; width: 1300px; height: 500px; overflow: hidden;">
            <!-- Loading Screen -->
            <div u="loading" style="position: absolute; top: 0px; left: 0px;">
                <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block;
                top: 0px; left: 0px; width: 100%; height: 100%;">
                </div>
                <div style="position: absolute; display: block; background: url(../img/loading.gif) no-repeat center center;
                top: 0px; left: 0px; width: 100%; height: 100%;">
                </div>
            </div>
            <!-- Slides Container -->
            <div u="slides" style="position: absolute; left: 0px; top: 0px; width: 1300px; height: 500px; overflow: hidden;">
                <div>
                    <img u="image" src="img/slider1.jpg" />
                </div>
                <div>
                    <img u="image" src="img/slider2.jpg" />
                </div>
                <div>
                    <img u="image" src="img/slider3.jpg" />
                </div>
            </div>

            <!--#region Bullet Navigator Skin Begin -->
            <!-- Help: http://www.jssor.com/tutorial/set-bullet-navigator.html -->
            <style>
                /* jssor slider bullet navigator skin 21 css */
                /*
                .jssorb21 div           (normal)
                .jssorb21 div:hover     (normal mouseover)
                .jssorb21 .av           (active)
                .jssorb21 .av:hover     (active mouseover)
                .jssorb21 .dn           (mousedown)
                */
                .jssorb21 {
                    position: absolute;
                }
                .jssorb21 div, .jssorb21 div:hover, .jssorb21 .av {
                    position: absolute;
                    /* size of bullet elment */
                    width: 19px;
                    height: 19px;
                    text-align: center;
                    line-height: 19px;
                    color: white;
                    font-size: 12px;
                    background: url(../img/b21.png) no-repeat;
                    overflow: hidden;
                    cursor: pointer;
                }
                .jssorb21 div { background-position: -5px -5px; }
                .jssorb21 div:hover, .jssorb21 .av:hover { background-position: -35px -5px; }
                .jssorb21 .av { background-position: -65px -5px; }
                .jssorb21 .dn, .jssorb21 .dn:hover { background-position: -95px -5px; }
            </style>
            <!-- bullet navigator container -->
            <div u="navigator" class="jssorb21" style="bottom: 26px; right: 6px;">
                <!-- bullet navigator item prototype -->
                <div u="prototype"></div>
            </div>
            <!--#endregion Bullet Navigator Skin End -->

            <!--#region Arrow Navigator Skin Begin -->
            <!-- Help: http://www.jssor.com/tutorial/set-arrow-navigator.html -->
            <style>
                /* jssor slider arrow navigator skin 21 css */
                /*
                .jssora21l                  (normal)
                .jssora21r                  (normal)
                .jssora21l:hover            (normal mouseover)
                .jssora21r:hover            (normal mouseover)
                .jssora21l.jssora21ldn      (mousedown)
                .jssora21r.jssora21rdn      (mousedown)
                */
                .jssora21l, .jssora21r {
                    display: block;
                    position: absolute;
                    /* size of arrow element */
                    width: 55px;
                    height: 55px;
                    cursor: pointer;
                    background: url(../img/a21.png) center center no-repeat;
                    overflow: hidden;
                }
                .jssora21l { background-position: -3px -33px; }
                .jssora21r { background-position: -63px -33px; }
                .jssora21l:hover { background-position: -123px -33px; }
                .jssora21r:hover { background-position: -183px -33px; }
                .jssora21l.jssora21ldn { background-position: -243px -33px; }
                .jssora21r.jssora21rdn { background-position: -303px -33px; }
            </style>
            <!-- Arrow Left -->
            <span u="arrowleft" class="jssora21l" style="top: 123px; left: 8px;">
            </span>
            <!-- Arrow Right -->
            <span u="arrowright" class="jssora21r" style="top: 123px; right: 8px;">
            </span>
            <!--#endregion Arrow Navigator Skin End -->
            <a style="display: none" href="http://www.jssor.com">Bootstrap Carousel</a>
        </div>
        <!-- Jssor Slider End -->
    </div>

    <div style="padding-top:30px;padding-bottom:30px;background-color: #eee;">
      <div class="container">
        <div class="title">
          <h2 class="filter-title">
            <span class="content" style="font-size:30px;letter-spacing:5px;background-color: #eee;padding: 20px;display: inline;"><strong>Our Service</strong></span>
          </h2><br><br>
        </div>
        <div class="col-md-4">
            <center><img src="img/rgb.png"width="30%"></img></center>
            <h3 class="title text-center">
              งานดีไซน์
            </h3><br>
            <p class="text-center"> รูปทรงเรขาคณิตอยู่แทรกซึมในชีวิตประจำวันเราเกือบทุกอย่างดังนั้นจึงเป็นรูปลักษณ์ที่คุ้นตา สื่อสารเข้าใจง่าย และเราได้นำรูปทรงเรขาคณิตมาอยู่ในลายเสื้อ ดีไซน์กราฟฟิคที่เราถนัด ได้ความรู้สึกทันสมัย เน้นความแตกต่าง จึงทำให้ Geometry มีลวดลายที่ไม่ซ้ำใคร</p>
        </div>
        <div class="col-md-4">
          <center><img src="img/quality.png"width="30%"></img></center>
          <h3 class="title text-center">
            คุณภาพ
          </h3><br>
            <p class="text-center">เราคัดสรรเนื้อผ้าจากโรงงานโดยตรง เป็น Cotton 100% เนื้อผ้าไม่หนา สัมผัสนุ่ม ใส่สบาย เหมาะกับอากาศร้อนอย่างเมืองไทยของเรา มีการตัดเย็บด้วยช่างมืออาชีพ มีความละเอียดในการตัดเย็บและสกรีนเสื้อด้วยสีที่สวยงาม</p>
        </div>
        <div class="col-md-4">
          <center><img src="img/trucking.png"width="30%"></img></center>
          <h3 class="title text-center">
            การจัดส่ง
          </h3><br>
            <p class="text-center">มีบริการจัดส่งสินค้าในรูปแบบการไปรษณีย์ไทย ไม่ว่าลูกค้าจะอยู่พื้นที่ไหน ก็สามารถรับสินค้าจากทางร้านได้อย่างสะดวก</p>
        </div>
      </div>
    </div>

    <div class="banner">
      <img src="img/banner.jpg" width="100%" >
    </div>

    <div style="padding-top:30px;background-color: #fff;">
      <div class="container">
        <div class="title">
          <h2 class="filter-title">
            <span class="content" style="font-size:16px;letter-spacing:5px;background-color: #fff;padding: 20px;display: inline;"><strong>NEW ARRIVALS</strong></span>
          </h2>
        </div>
          <div id="new" class="owl-carousel owl-theme">
            <?php
              $conn = mysql_connect( "$host", "$user", "$pass");
              mysql_select_db("t-shirt");
              $strSQL = "select * from products where product_tag='new'";
              $query = mysql_query($strSQL, $conn);
              while ($result = mysql_fetch_array($query)) {
            ?>
            <div class="item">
              <a href="product/detailproduct.php?id=<?php echo $result['product_id'];?>">
                <img src="product/ViewImage1.php?id=<?php echo $result['product_id'];?>" width="280px">
              </a>
              <a href="product/detailproduct.php?id=<?php echo $result['product_id'];?>" class="smooth"><?php echo $result['product_name']; ?></a>
              <h4 style="color:#333;"><?php echo "฿".$result['product_price']; ?></h4>
            </div>
            <?php
              }
            ?>
          </div>
      </div>
    </div>
    <div style="padding-bottom:30px;background-color: #fff;">
      <div class="container">
        <div class="title">
          <h2 class="filter-title">
            <span class="content" style="font-size:16px;letter-spacing:5px;background-color: #fff;padding: 20px;display: inline;"><strong>Sales</strong></span>
          </h2>
          <div id="sales" class="owl-carousel owl-theme">
            <?php
              $conn = mysql_connect( "$host", "$user", "$pass");
              mysql_select_db("t-shirt");
              $strSQL = "select * from products where product_tag='sale'";
              $query = mysql_query($strSQL, $conn);
              while ($result = mysql_fetch_array($query)) {
            ?>
            <div class="item">
              <a href="product/detailproduct.php?id=<?php echo $result['product_id'];?>">
                <img src="product/ViewImage1.php?id=<?php echo $result['product_id'];?>" width="280px">
              </a>
              <a href="product/detailproduct.php?id=<?php echo $result['product_id'];?>" class="smooth"><?php echo $result['product_name']; ?></a>
              <h4 style="color:#333;"><?php echo "฿".$result['product_price']; ?></h4>
            </div>
            <?php
              }
            ?>
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
                                    <a href="etc/about.php">เกี่ยวกับเรา</a></li>
                                <li>
                                    <a href="contact/contact.php">ติดต่อเรา</a>
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
                                    <a href="member/login.php">เข้าสู่ระบบและสมัครสมาชิก</a>
                                </li>
                                <li>
                                    <a href="etc/how-to-order.php">ขั้นตอนการสั่งซื้อ</a>
                                </li>
                                <li>
                                    <a href="etc/shipping.php">การจัดส่งสินค้า</a>
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
    <script src="js/owl.carousel.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <!-- /.myjs -->
    <script src="js/myjs.js"></script>
    <script src="js/search.js"></script>
    <script src="่js/docs.min.js"></script>
    <script src="js/ie10-viewport-bug-workaround.js"></script>
    <!-- use jssor.slider.debug.js for debug -->
    <script type="text/javascript" src="js/jssor.slider.mini.js"></script>
    <script>
        jQuery(document).ready(function ($) {

            var options = {
                $FillMode: 2,                                       //[Optional] The way to fill image in slide, 0 stretch, 1 contain (keep aspect ratio and put all inside slide), 2 cover (keep aspect ratio and cover whole slide), 4 actual size, 5 contain for large image, actual size for small image, default value is 0
                $AutoPlay: true,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                $Idle: 4000,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                $PauseOnHover: 1,                                   //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1

                $ArrowKeyNavigation: true,   			            //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
                $SlideEasing: $JssorEasing$.$EaseOutQuint,          //[Optional] Specifies easing for right to left animation, default value is $JssorEasing$.$EaseOutQuad
                $SlideDuration: 800,                               //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
                $MinDragOffsetToSlide: 20,                          //[Optional] Minimum drag offset to trigger slide , default value is 20
                //$SlideWidth: 600,                                 //[Optional] Width of every slide in pixels, default value is width of 'slides' container
                //$SlideHeight: 300,                                //[Optional] Height of every slide in pixels, default value is height of 'slides' container
                $SlideSpacing: 0, 					                //[Optional] Space between each slide in pixels, default value is 0
                $Cols: 1,                                  //[Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
                $ParkingPosition: 0,                                //[Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.
                $UISearchMode: 1,                                   //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
                $PlayOrientation: 1,                                //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1
                $DragOrientation: 1,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $Cols is greater than 1, or parking position is not 0)

                $BulletNavigatorOptions: {                          //[Optional] Options to specify and enable navigator or not
                    $Class: $JssorBulletNavigator$,                 //[Required] Class to create navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 1,                                 //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 1,                                      //[Optional] Steps to go for each navigation request, default value is 1
                    $Rows: 1,                                      //[Optional] Specify lanes to arrange items, default value is 1
                    $SpacingX: 8,                                   //[Optional] Horizontal space between each item in pixel, default value is 0
                    $SpacingY: 8,                                   //[Optional] Vertical space between each item in pixel, default value is 0
                    $Orientation: 1,                                //[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
                    $Scale: false                                   //Scales bullets navigator or not while slider scale
                },

                $ArrowNavigatorOptions: {                           //[Optional] Options to specify and enable arrow navigator or not
                    $Class: $JssorArrowNavigator$,                  //[Requried] Class to create arrow navigator instance
                    $ChanceToShow: 1,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 2,                                 //[Optional] Auto center arrows in parent container, 0 No, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 1                                       //[Optional] Steps to go for each navigation request, default value is 1
                }
            };

            var jssor_slider1 = new $JssorSlider$("slider1_container", options);

            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizing
            function ScaleSlider() {
                var bodyWidth = document.body.clientWidth;
                if (bodyWidth)
                    jssor_slider1.$ScaleWidth(Math.min(bodyWidth, 1920));
                else
                    window.setTimeout(ScaleSlider, 30);
            }
            ScaleSlider();

            $(window).bind("load", ScaleSlider);
            $(window).bind("resize", ScaleSlider);
            $(window).bind("orientationchange", ScaleSlider);
            //responsive code end
        });
    </script>
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/th_TH/sdk.js#xfbml=1&version=v2.8";
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
    </script>
    <style>
    .item{
        padding: 30px 0px;
        margin: 10px;
        color: #FFF;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        text-align: center;
        width: 300px;
        height: 400px;
    }
    </style>
    <script>
      $(document).ready(function() {

        var owl1 = $("#new");
        var owl2 = $("#sales");

        owl1.owlCarousel({

        items : 4, //10 items above 1000px browser width
        itemsDesktop : [1000,5], //5 items between 1000px and 901px
        itemsDesktopSmall : [900,3], // 3 items betweem 900px and 601px
        itemsTablet: [600,2], //2 items between 600 and 0;
        itemsMobile : false, // itemsMobile disabled - inherit from itemsTablet option
        autoPlay : 5000,
        stopOnHover : true
        });

        owl2.owlCarousel({

        items : 4, //10 items above 1000px browser width
        itemsDesktop : [1000,5], //5 items between 1000px and 901px
        itemsDesktopSmall : [900,3], // 3 items betweem 900px and 601px
        itemsTablet: [600,2], //2 items between 600 and 0;
        itemsMobile : false, // itemsMobile disabled - inherit from itemsTablet option
        autoPlay : 5000,
        stopOnHover : true
        });

      });
    </script>


  </body>
</html>
