<?php
header('Content-type:application/javascript;charset=utf-8');    //设置页面编码格式
header("Access-Control-Allow-Origin: *");   //后台解决跨域
error_reporting(E_ERROR | E_WARNING | E_PARSE);
date_default_timezone_set('PRC');    //设置脚本中所有日期/时间函数使用的默认时区
session_start();

require('./pdo.php');



$game_id = $_REQUEST['gameid'];
$user_id = $_REQUEST['userid'];

if( empty($game_id) || empty($user_id) )
{
	exit( json_encode(array('code'=>9002,'msg'=>'需要参数game_id、user_id')) );
}

$sql = " SELECT `user_name`,`user_icon` FROM `user` WHERE  `user_id`='$user_id' ";
$stmt = $pdo->query($sql);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$user_name = $row['user_name'];
$user_icon = $row['user_icon'];

$sql = " SELECT * FROM `game` WHERE `is_show`='1' AND `game_id`='$game_id' ";
$stmt = $pdo->query($sql);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$gameID = $row['id'];

if( !$gameID || !$user_name )
{
	exit( json_encode(array('code'=>9004,'msg'=>'参数错误')) );
}

$mode = array();		
if( $row['mode_single'] == 1 )
{
	$mode_text = '单人模式';
	$mode_link =  'swgame://saiweng.com/launchgame?gameid='.$game_id.'&gamename='.$row['name'].'&gamemode=single&userid='.$user_name;
	array_push($mode,array('mode'=>$mode_text,'link'=>$mode_link));
}

if( $row['mode_match'] == 1 )
{
	$mode_text = '对战模式';
	$mode_link =  'swgame://saiweng.com/launchgame?gameid='.$game_id.'&gamename='.$row['name'].'&gamemode=match&userid='.$user_name;
	array_push($mode,array('mode'=>$mode_text,'link'=>$mode_link));
}

if( $row['mode_race'] == 1 )
{
	$mode_text = '排位模式';
	$mode_link =  'swgame://saiweng.com/launchgame?gameid='.$game_id.'&gamename='.$row['name'].'&gamemode=race&userid='.$user_name;
	array_push($mode,array('mode'=>$mode_text,'link'=>$mode_link));
}

if( $row['mode_family'] == 1 )
{
	$mode_text = '家庭模式';
	$mode_link =  'swgame://saiweng.com/launchgame?gameid='.$game_id.'&gamename='.$row['name'].'&gamemode=family&userid='.$user_name;
	array_push($mode,array('mode'=>$mode_text,'link'=>$mode_link));
}


// 游戏详情
$details = array(
			'gamename' => $row['name'],
			'icon' => $row['game_icon'],
			'form' => $row['form'],
			'mode' => $mode,
			'desc' => $row['game_desc'],
			'imgs' => array_filter(array(
							$row['game_img_1'],
							$row['game_img_2']
					   )),
			'gamepkgname' => $row['gamepkgname'],
			'gameurl' => $row['gameurl'],
			'gamesize' => $row['gamesize'],
			'gamemd5' => $row['gamemd5'],
			'nickename' => $user_name,
			'headicon' => $user_icon
			);


// 游戏推荐
$sql = " SELECT `name`,`game_icon`,`game_id` FROM `game` WHERE `is_show`='1' ";
$stmt = $pdo->query($sql);

$game_list = array();
$i = 0;
while($row = $stmt->fetch(PDO::FETCH_ASSOC))
{
	if( $row['game_id'] != $game_id )
	{
		$game_list[$i] = $row;
    	$i = $i + 1;
	}
}
// print_r($game_list);
$recommend = array();
foreach (array_rand($game_list,3) as $val) 
{
	array_push($recommend,$game_list[$val]);
}

// 排行榜
$sql = " SELECT `id` FROM `user` WHERE `user_id`='$user_id' ";
$stmt = $pdo->query($sql);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$userID = $row['id'];

$sql = " SELECT gu.`score`,u.`user_name`,u.`user_id`,u.`user_icon` 
		 FROM `game_user` gu,`user` u 
		 WHERE gu.`userID`=u.`id`
		 AND `gameID`='$gameID' 
		 ORDER BY `score` 
		 DESC ";

$stmt = $pdo->query($sql);

$rank = array();
$my_rank = '';
$i = 0;
while( $row = $stmt->fetch(PDO::FETCH_ASSOC) )
{	
	$row['is_me'] = '0';
	if( $row['user_id'] == $user_id )
	{
		$row['is_me'] = '1';
	}
    $rank[$i]  = $row;
    $i = $i + 1;
}

exit( json_encode(array('code'=>1,'data'=>array('gameinfo'=>$details, 'recommend'=>$recommend, 'rank'=>$rank))) );


?>