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

// $time = substr(time(),7,6).mt_rand(100,999);

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

    
<!-- <div style="position: absolute;top: 1%;right: 45%;font-size: 50px;">  <?php echo $time; ?> </div> -->

