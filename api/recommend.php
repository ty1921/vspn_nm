<?php

require './head_api.php';

$action = $_REQUEST["action"];

$addtime = date('Y-m-d H:i:s');

$back = $_REQUEST['callback'] .'(' ;


//===============================================================
//1.0 获取验证码
if( $action == "list" )
{
    $game = $_REQUEST["game"];

    $all  = (int)$_REQUEST["all"]; 

    
    if( empty($game) ) 
    {
        $res = array ('code'=>9000,'msg'=>'参数game丢失','time'=>time() );

        exit( $back . json_encode($res) . ')' );
    }


	require './conn.php';

    try{

        if( $all > 0 )
        {
            //取该游戏下全部的视频
            if( $game == '其他')
            {
                //其他游戏
                $sql = " SELECT * FROM `video` WHERE `game` NOT IN ('英雄联盟','王者荣耀','绝地求生') ";
            }
            else
            {
                //某个游戏
                $sql = " SELECT * FROM `video` WHERE `game` = '{$game}' ";
            }
        }
        else
        {
            //取专区4大分区的7张图
            $condition = '';

            //取游戏同系列
            if( $game == '英雄联盟')
            {
                $condition = "  AND `location` < 20 ";
            }
            elseif( $game == '王者荣耀')
            {
                $condition = "  AND `location` > 20 AND `location` < 30 ";
            }
            elseif( $game == '绝地求生')
            {
                $condition = "  AND `location` > 30 AND `location` < 40 ";
            }
            else
            {
                $condition = "  AND `location` > 40 ";
            }

            $sql = " SELECT * FROM `video` WHERE `area` = 2 {$condition} ORDER BY `location` ";
        }

        //echo $sql;
        
        $stmt = $pdo->query( $sql );
        
        $row_count = $stmt->rowCount();
        
        if( $row_count > 0 )
        {
            //存在数据，返回
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

