<?php

/**
 * 用户注册上报接口
 */

require './head_api.php';


//===============================================================
//记录日志
$fd = fopen('./reg.log',"a");

fwrite( $fd, "=============================================="
	         .PHP_EOL
	         ."[" 
	         . date('Y-m-d H:i:s') 
	         . '] get reg data:' 
	         . json_encode( $_REQUEST, JSON_UNESCAPED_UNICODE ) . "\n\n" 
	   );

fclose( $fd );


//===============================================================
//1.0 新用户
$mac 	  = $_REQUEST["mac"];

$deviceid = $_REQUEST["deviceid"];

$channel  = $_REQUEST["channel"];

$pid 	  = $_REQUEST["pid"];

$version  = $_REQUEST["version"];

$addtime = date('Y-m-d H:i:s');


if( empty($channel) || empty($deviceid)  ) 
{
    $res = array ('status'=>9000,'msg'=>'参数丢失','time'=>time() );

    exit( json_encode($res) );
}

require './conn.php';

try
{
	//生成临时id
	$userid = '玩家' . str_rand();

	$avatar = 'http://www.oneh5.com/iptv/images/avatar.jpg';

	$token  = md5( $userid );


    $sql = "  INSERT INTO `member`(`token`,`nickname`,`avatar`,`gender`,`mac`,`deviceid`,`channel`,`pid`,`regtime`)
                   VALUES ('$token','$nickname','{$avatar}',{$gender},'{$mac}','{$deviceid}','{$channel}','{$pid}','{$regtime}')
           ";

    $pdo->exec( $sql );
    
    $userid = $pdo->lastInsertId();

    $data = array(	'avatar' =>$avatar , 
    				'deviceid' =>$deviceid , 
    				'gender' =>$gender , 
    				'mac' =>$mac , 
    				'nickname' =>$nickname , 
    				'regtime' =>$regtime , 
    				'token' =>$token , 
    				'userid' =>$userid
    			 );
    
    if( $id > 0 )
    {
        $res = array ('status'=>0,'data'=>$data );

        exit( json_encode($res) );
    }
    else
    {
        $res = array ('status'=>1,'msg'=>'reg failed','time'=>time() );

        exit( json_encode($res) );
    }
}
catch(PDOException $ex) 
{
    $res = array ('code'=>9006,'msg'=>'Exception:'.$ex->getMessage(),'time'=>time());
    
    exit( json_encode($res) );
}



/*
 * 生成随机字符串
 * @param int $length 生成随机字符串的长度
 * @param string $char 组成随机字符串的字符串
 * @return string $string 生成的随机字符串
 */
function str_rand($length = 8, $char = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') {
    if(!is_int($length) || $length < 0) {
        return false;
    }

    $string = '';
    for($i = $length; $i > 0; $i--) {
        $string .= $char[mt_rand(0, strlen($char) - 1)];
    }

    return $string;
}