<?php

/**
 * 用户注册上报接口
 */

require './head_api.php';

$action = $_REQUEST["action"];

$addtime = date('Y-m-d H:i:s');

$back = $_REQUEST['callback'] .'(' ;



//===============================================================
//记录日志
$fd = fopen('./notify.log',"a");

fwrite( $fd, "=============================================="
	         .PHP_EOL
	         ."[" 
	         . date('Y-m-d H:i:s') 
	         . '] get notify data:' 
	         . json_encode( $_REQUEST, JSON_UNESCAPED_UNICODE ) . "\n\n" 
	   );

fclose( $fd );


//===============================================================
//1.0 新用户订购
if( $action == "reg" )
{
    $live = (int)$_REQUEST["live"]; 

    $code = $_REQUEST["code"];

    
    if( empty($code) ) 
    {
        $res = array ('code'=>9000,'msg'=>'参数code丢失','time'=>time() );

        exit( $back . json_encode($res) . ')' );
    }

	require './conn.php';

    try
    {
        if( $live > 0 )
        {
            //取主播同系列，不足6条则其他视频补起
            $sql = "    SELECT 'main' AS type,`code`,`game`,`img`,`title`,`desc`,`tag` FROM `video` 
                         WHERE `code` = '{$code}' 
                     UNION ALL 
                      ( SELECT 'more' ,`code`,`game`,`img`,`title`,'','' FROM `video` 
                         WHERE `code` <> '{$code}'
                           AND `live` IN (SELECT `live` FROM `video` WHERE `code` = '{$code}' )
                         LIMIT 6 )
                     UNION ALL 
                      ( SELECT 'more' ,`code`,`game`,`img`,`title`,'','' FROM `video` 
                         WHERE `code` <> '{$code}'
                           AND `live` NOT IN (SELECT `live` FROM `video` WHERE `code` = '{$code}' )
                      ORDER BY RAND()
                         LIMIT 6 )
                     LIMIT 7
                   ";
        }
        else
        {
            $sql = "    SELECT 'main' AS type,`code`,`game`,`img`,`title`,`desc`,`tag` FROM `video` 
                         WHERE `code` = '{$code}' 
                     UNION ALL 
                      ( SELECT 'more' ,`code`,`game`,`img`,`title`,'','' FROM `video` 
                         WHERE `code` <> '{$code}'
                           AND `game` IN (SELECT `game` FROM `video` WHERE `code` = '{$code}' )
                         LIMIT 6 )
                     LIMIT 7
                   ";
        }

        $stmt = $pdo->query( $sql );
        
        $row_count = $stmt->rowCount();
        
        if( $row_count > 0 )
        {
            //验证码存在，返回
            $row = $stmt->fetchALL(PDO::FETCH_ASSOC);

            $res = array ('code'=>1,'data'=>$row,'time'=>time() );

            exit( $back . json_encode($res) . ')' );
        }
        else
        {
            $res = array ('code'=>404,'msg'=>'视频不存在','time'=>time() );

            exit( $back . json_encode($res) . ')' );
        }
    }
    catch(PDOException $ex) 
    {
        $res = array ('code'=>9006,'msg'=>'效验异常：'.$ex->getMessage(),'time'=>time());
        
        exit( $back . json_encode($res) . ')' );
    }

}

//===============================================================
//action error!
$res = array ('code'=>9004,'msg'=>'请求错误','time'=>time() );

exit( $back . json_encode($res) . ')' );

