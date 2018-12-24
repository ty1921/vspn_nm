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

$time = substr(time(),8,2).mt_rand(100,999);

$rec = (int)$_GET['rec'];

$game = $_REQUEST['game'] ? $_REQUEST['game'] : '其他';



?>
<!DOCTYPE HTML>
<html>
<head>
    <title> VSPN </title>
    <meta name="page-view-size" content="1920*1080">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
    <meta name="author" content="ty1921@gamil.com" />  
    <meta name="Copyright" content="" /> 
    
    <link rel="stylesheet" href="./css/recommend.css?v=<?php echo $time; ?>">

    <script src="./js/jquery.min.js"></script>

</head>

<body>

    
<div style="position: absolute;top: 1%;right: 5%;font-size: 50px;color: yellow">  测试<?php echo $time; ?> </div>


<!-- 通用 专区页 -->

<div class="recommend">
    
    <!-- 上logo -->
    <img class="logo" src="./images/recommend/logo.png">

    <!-- 左侧nav -->
    <div class="navs">
        <a id="rec1" href="./recommend.php?rec=1&game=<?php echo $game;?>" > <span> 热门推荐 </span> </a>
        <a id="rec2" href="./recommend_all.php?rec=2&game=<?php echo $game;?>" > <span> 所有视频 </span> </a>
<!--         <a id="rec3" href="./recommend_hot.php?rec=3" > <span> 热门赛事 </span> </a>
        <a id="rec4" href="./recommend_live.php?rec=4" > <span> 主播大神 </span> </a>
        <a id="rec5" href="./recommend_album.php?rec=5" > <span> 精选专辑 </span> </a> -->
    </div> 


<script type="text/javascript">



$(document).ready(function()
{
    /*推荐页*/
    var rec = '<?php echo $rec; ?>';

    console.log('rec=' + rec);

    if( !rec || rec == 0 || rec == 1 )
    {
        $('#rec1').focus();

        console.log( 321 );
    }
    else
    {
        $('#rec' + rec ).focus();
    }
})

</script>