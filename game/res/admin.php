<?php
header('Content-type:application/javascript;charset=utf-8');    //设置页面编码格式
header("Access-Control-Allow-Origin: *");   //后台解决跨域
error_reporting(E_ERROR | E_WARNING | E_PARSE);
date_default_timezone_set('PRC');    //设置脚本中所有日期/时间函数使用的默认时区
session_start();

require('./pdo.php');

$action = $_REQUEST['action'];


switch ($action) 
{	
	// 游戏数据回显
	case 'game_show':

		$sql = "SELECT *
				FROM `game` 
				ORDER BY `sort` 
				DESC";
		$stmt = $pdo->query($sql);

        $i = 0;
        $arr = [];

        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
        	$arr[$i] = $row;
        		$i++;
        }
       	exit( json_encode(array('code'=>1,'data'=>$arr)) );

	break;


	// 用户数据回显
	case 'user_show':
		
		$sql = "SELECT *
				FROM `user`";
		$stmt = $pdo->query($sql);

        $i = 0;
        $arr = [];

        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
        	$arr[$i] = $row;
        		$i++;
        }
       	exit( json_encode(array('code'=>1,'data'=>$arr)) );

	break;




    // 删除游戏数据
    case 'game_dele':
        
        $game_id = $_REQUEST['game_id'];
        $sql = "DELETE FROM game WHERE `game_id`='$game_id'";
        $row = $pdo->exec($sql);
        if( $row > 0 )
        {
            exit( json_encode(array('code'=>1,'msg'=>'delete success')) );
        }

    break;


}



?>