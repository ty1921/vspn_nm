<?php
header('Content-type:application/javascript;charset=utf-8');    //设置页面编码格式
header("Access-Control-Allow-Origin: *");   //后台解决跨域
error_reporting(E_ERROR | E_WARNING | E_PARSE);
date_default_timezone_set('PRC');    //设置脚本中所有日期/时间函数使用的默认时区
session_start();

require('./pdo.php');

$game_id = $_REQUEST['game_id'];
$user_id = $_REQUEST['user_id'];
$score = $_REQUEST['score'];
$mode = $_REQUEST['mode'];
$ctime = date('YmdHis');


if( !isset($game_id) || !isset($user_id) || !isset($score) || !isset($mode) )
{
	exit( json_encode(array('code'=>9002,'msg'=>'Missing parameters !')) );
}

$modes = array('1','2','3','4');  //单人 对战 排位 家庭
if( !in_array($mode,$modes) )
{
	exit( json_encode(array('code'=>9004,'msg'=>'mode is error !' )) );
}

// 1胜+5  2负-5 3平+0
$scores = array('1','2','3');
if( !in_array($score,$scores) )
{
	exit( json_encode(array('code'=>9004,'msg'=>'score is error !' )) );
}


$sql = "SELECT `id` 
		FROM `user` 
		WHERE `user_id`='$user_id'";
$stmt = $pdo->query($sql);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if( !$row['id'] )
{
	exit( json_encode(array('code'=>9004,'msg'=>'Can not find userid !' )) );
}
$userID = $row['id'];


$ms = array('1'=>'mode_single','2'=>'mode_match','3'=>'mode_race','4'=>'mode_family');
$sql = "SELECT `id` 
		FROM `game` 
		WHERE `game_id`='$game_id' 
		AND $ms[$mode] = '1'";
$stmt = $pdo->query($sql);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if( !$row['id'] )
{
	exit( json_encode(array('code'=>9004,'msg'=>'Can not find gameid or gameid&mode !' )) );
}
$gameID = $row['id'];



// 记录分数日志
$sql = "INSERT INTO `score_log` (`userID`,`gameID`,`result`,`mode`,`ctime`) 
		VALUES ( '$userID','$gameID','$score','$mode','$ctime')";
$affected_rows=$pdo->exec($sql);



$sql = "SELECT `id`,`score` 
		FROM `game_user` 
		WHERE `userID` = '$userID' 
		AND `gameID` = '$gameID' 
		AND `mode` = '$mode'";
$stmt = $pdo->query($sql);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if( $score == '1' ) //胜
{
	$score = $row['score'] + 5;
}
else if( $score == '2' ) //负
{
	$score = $row['score'] - 5;
}
else //平
{
	$score = $row['score'];
}


if ( $row['id'] )
{
	$sql = "UPDATE `game_user` 
			SET `score` = '$score',`mtime` = '$ctime'  
			WHERE `userID`='$userID' 
			AND `gameID`='$gameID' 
			AND `mode` = '$mode'";
	$affected_rows=$pdo->exec($sql);

	exit( json_encode(array('code'=>1,'msg'=>'score update success !' )));
}
else
{
	$sql = "INSERT INTO `game_user` (`userID`,`gameID`,`score`,`mode`,`ctime`,`mtime`) 
			VALUES ( '$userID','$gameID','$score','$mode','$ctime','$ctime')";
	$affected_rows=$pdo->exec($sql);
	
	exit( json_encode(array('code'=>1,'msg'=>'score insert success !' )) );
}


?>