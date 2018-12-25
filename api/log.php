<?php

/**
 * 日志上报接口
 */

require './head_api.php';

$action = $_REQUEST["action"];

$addtime = date('Y-m-d H:i:s');

$back = $_REQUEST['callback'] .'(' ;

if( count($_REQUEST) <= 0 )
{
    $_REQUEST['error'] = 'no log data';
}

//===============================================================
//记录日志
$fd = fopen('./log.log',"a");

fwrite( $fd, "=============================================="
	         .PHP_EOL
	         ."[" 
	         . date('Y-m-d H:i:s') 
	         . '] get log data:' 
	         . json_encode( $_REQUEST, JSON_UNESCAPED_UNICODE ) . "\n\n" 
	   );

fclose( $fd );



$action = $_REQUEST["action"]; 

if( empty($action) ) 
{
    $res = array ('code'=>9000,'msg'=>'参数action丢失','time'=>time() );

    exit( $back . json_encode($res) . ')' );
}

require './conn.php';


//============================================================
//页面点击，等同pv
if( $action == 'Browse' )
{
    $type = (int)$_REQUEST['type'];
    
    $page_id = (int)$_REQUEST['page_id'];

    $page_name = $_REQUEST['page_name'];
    
    $code = $_REQUEST['code'];
    
    $userid = $_REQUEST['userid'];
    
    $refer = (int)$_REQUEST['refer'];

    $logtime = date('Y-m-d H:i:s');

    try
    {
        //取主播同系列，不足6条则其他视频补起
        $sql = "  INSERT INTO `log`(`type`,`page_id`,`page_name`,`action`,`code`,`userid`,`refer`,`logtime`)
                       VALUES ($type,$page_id,'{$page_name}','{$action}','{$code}','{$userid}',$refer,'{$logtime}')
               ";

        $pdo->exec( $sql );
        
        $id = $pdo->lastInsertId();
        
        if( $id > 0 )
        {
            $res = array ('code'=>1,'msg'=>'success','sql'=>$sql,'time'=>time() );

            exit( $back . json_encode($res) . ')' );
        }
        else
        {
            $res = array ('code'=>404,'msg'=>'report failed','time'=>time() );

            exit( $back . json_encode($res) . ')' );
        }
    }
    catch(PDOException $ex) 
    {
        $res = array ('code'=>9006,'msg'=>'report exception'.$ex->getMessage(),'time'=>time());
        
        exit( $back . json_encode($res) . ')' );
    }
}




//===============================================================
//action error!
$res = array ('code'=>9004,'msg'=>'请求错误','time'=>time() );

exit( $back . json_encode($res) . ')' );

