<?php 
/**
 * Created by ty1921@gmail.com
 * Date: 2018-11-5
*/
 
//1 session
//session_start();
 
 
//2 display_errors
ini_set('display_errors', TRUE);

ini_set('display_startup_errors', TRUE);
 

error_reporting(E_ALL && ~E_NOTICE);    //normal

//3 debug mode
if( $_REQUEST['debug'] ==1 )
{
    error_reporting(E_ALL);                 //debug mode
     
    print_r($_REQUEST);
     
    print_r($_SESSION);
}
 
 
//4 encode
//header('Content-type:application/javascript;charset=utf-8');    
header("Content-Type:text/html;charset=utf-8");              
 
//5 no cache
header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');

header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
  
//6 timezone
date_default_timezone_set("PRC");

$time = substr(time(),8,2).mt_rand(10,99);

$nav = (int)$_GET['nav'];

?>
<!DOCTYPE HTML>
<html>
<head>
    <title> VSPN </title>
    <meta name="page-view-size" content="1920*1080">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
    <meta name="author" content="ty1921@gamil.com" />  
    <meta name="Copyright" content="" /> 

    <link rel="stylesheet" href="./css/main.css?v=<?php echo $time; ?>">
    
    <script src="./js/jquery.min.js"></script>

</head>

<body>


<!-- main frame -->
<div class="content">

    <!-- <div style="position: absolute;top: 1%;right: 1%;font-size: 25px;color: yellow">  测试<?php echo $time; ?> </div> -->

    <!--1 nav start ------------------------------------------>
    <div class="nav_div">

        <a id="nav1" href='main.php?nav=1' class="nav <?php if($nav==1) echo 'now'; ?> " >  推荐 </a>
        
        <a id="nav2" href='area.php?nav=2' class="nav <?php if($nav==2) echo 'now'; ?> ">  专区 </a>

        <a id="nav3" href='match.php?nav=3' class="nav <?php if($nav==3) echo 'now'; ?> ">  赛事 </a>

        <a id="nav4" href='live.php?nav=4' class="nav <?php if($nav==4) echo 'now'; ?> ">  主播 </a>

        <!-- <a id="nav5" href='team.php?nav=5' class="nav ">  战队 </a> -->

        <!-- <a id="nav6" href='search.php?nav=6' class="nav ">  搜索 </a> -->

        <!-- <a id="nav7" href='http://oneh5.com/iptv/' class="nav ">  游戏 </a> -->

        <!-- <a id="nav7" href='./pay.php?code=04710001000000100000000000016823&img=./images/area2/a3/4.jpg&title=小苍吃鸡萌新宝典#' class="nav ">  鉴权 </a> -->

        <div class="clear"></div>

    </div>