<?php
/**
 * 前端API(赵思航用) 头部文件
 */

//error reporting

error_reporting(E_ALL && ~E_NOTICE); 
//error_reporting(E_ALL); 
//error_reporting(0);

ini_set('display_errors', TRUE);

ini_set('display_startup_errors', TRUE);

//encode
header('Content-type:application/javascript;charset=utf-8');

setlocale(LC_ALL, 'en_US.UTF8');


//header('Content-Type:text/html;charset=utf-8');

//timezone
date_default_timezone_set('PRC');


//session
session_start();

//update session for timelimit
$_SESSION['last_access'] = time();


//anti_sql_inject
require 'anti_sql_inject.php';

//include config file
require 'config.php';


//--------------------------------------------------------------------------------------
//debug log flag  true:open false:close.
$debug = false;

if( $debug )
{
    echo json_encode($_REQUEST,JSON_UNESCAPED_UNICODE);
}


/*
// token check start ----------------------------------------------------------------------
$token   = $_REQUEST["token"];

if( !empty($token) )
{
    $token_base64 = substr($token,5,10) . substr($token,0,5) . substr($token,15,strlen($token));

    $tokens = explode('|', base64_decode($token_base64) ) ;

    $user_id = $tokens[0];

    //print_r($tokens);

    if( empty($user_id) || empty($tokens[1]) || empty($tokens[2]) || $tokens[2]<666 || $tokens[2]>888 )
    {
        $res = array ('code'=>9011,'msg'=>'token error!','time'=>time() );

        exit( json_encode($res) );
    }
}
//check over ------------------------------------------------------------------------------

*/

//action log
// require '../comm/conn.php';

// $add_time = date('Y-m-d H:i:s');

// $pages 	 = preg_replace('/.*\//','',$_SERVER['PHP_SELF']) ;

// $sql  	 = " INSERT INTO `log`(`add_time`,`add_user`,`pages`,`action`) VALUES( '{$add_time}','{$_SESSION['user_id']}','{$pages}','{$_REQUEST["action"]}') ";

// $pdo->exec( $sql );



?>
