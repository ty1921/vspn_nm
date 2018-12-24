<?php
header('Content-type:application/javascript;charset=utf-8');    //设置页面编码格式
header("Access-Control-Allow-Origin: *");   //后台解决跨域
error_reporting(E_ERROR | E_WARNING | E_PARSE);
date_default_timezone_set('PRC');    //设置脚本中所有日期/时间函数使用的默认时区
session_start();

require('./pdo.php');

// 昵称数组
$name1 = array('赵','钱','孙','李','周','吴','郑','王','刘','廖','冯');
$name2 = array('一','二','三','四','五','六','七','八','九','十','百','千','万');
$name3 = array('建国','大扎','美女','男','女','皇帝','太监','宫女','少爷','疯子');

// 头像数组
$header = array(
		'http://www.oneh5.com/iptv/images/head/1.png',
		'http://www.oneh5.com/iptv/images/head/2.png',
		'http://www.oneh5.com/iptv/images/head/3.png',
		'http://www.oneh5.com/iptv/images/head/4.png',
		'http://www.oneh5.com/iptv/images/head/5.png',
		'http://www.oneh5.com/iptv/images/head/6.png',
		'http://www.oneh5.com/iptv/images/head/7.png',
		'http://www.oneh5.com/iptv/images/head/8.png',
		'http://www.oneh5.com/iptv/images/head/9.png'
	);

$action = $_REQUEST['action'];

switch ($action) 
{	
	// 封面（必须有10条数据）
	case 'cover':
		
		$user_id = $_REQUEST['user_id'];

		$sql = " SELECT `user_name`,`user_icon` FROM `user` WHERE  `user_id`='$user_id' ";
		$stmt = $pdo->query($sql);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		
		$users = array();
		if( $row )
		{
			$users['user_name'] = $row['user_name'];
			$users['user_id'] = $user_id;
			$users['user_icon'] = $row['user_icon'];
		}
		else
		{
			$user_name = $name1[ mt_rand(0,count($name1)-1) ].$name2[ mt_rand(0,count($name2)-1) ].$name3[ mt_rand(0,count($name3)-1) ];
			$user_id = randomkeys(8);
			$user_icon = $header[ mt_rand(0,count($header)-1) ];
			$ctime = date('YmdHis');

			$sql = " insert into `user` (`user_name`,`user_id`,`user_icon`,`ctime`) value ('$user_name ','$user_id','$user_icon','$ctime') ";
			$row = $pdo->exec($sql);
			if( $row > 0 )
			{
				$users['user_name'] = $user_name;
				$users['user_id'] = $user_id;
				$users['user_icon'] = $user_icon;
			}
		}
		

		$sql = "SELECT `game_status`,`name`,`game_cover`,`game_id` 
				FROM `game` 
				WHERE `is_show`='1' 
				AND `is_cover`='1'
				ORDER BY `sort` 
				DESC";;
		$stmt = $pdo->query($sql);

        $i = 0;
        $arr1 = array();
 

        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
        	$arr1[$i] = $row;
        		$i++;
        }
       	exit( json_encode(array('code'=>1,'users'=>$users,'data'=>$arr1)) );

	break;
	



	case 'cover_more':

		$sql = "SELECT `game_status`,`name`,`game_cover`,`game_id` 
				FROM `game` 
				WHERE `is_show`='1' 
				AND `is_cover`='1'
				ORDER BY `sort` 
				DESC";;
		$stmt = $pdo->query($sql);

        $i = 0;
        $arr1 = array();
 

        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
        	$arr1[$i] = $row;
        		$i++;
        }
       	exit( json_encode(array('code'=>1,'data'=>$arr1)) );

	break;




	// 游戏详情
	case 'details':
		
		$game_id = $_REQUEST['game_id'];//base64_decode($_REQUEST['game_id']);
		$user_id = $_REQUEST['user_id'];//base64_decode($_REQUEST['user_id']);

		if( empty($game_id) )
		{
			exit( json_encode(array('code'=>9004,'msg'=>'game_id为空')) );
		}

		$sql = " SELECT `user_name`,`user_icon` FROM `user` WHERE  `user_id`='$user_id' ";
		$stmt = $pdo->query($sql);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$user_name = $row['user_name'];
		$user_icon = $row['user_icon'];
		
		$users = array(
					'user_name'=>$user_name,
					'user_icon'=>$user_icon,
				);

		$sql = " SELECT * FROM `game` WHERE `is_show`='1' AND `game_id`='$game_id' ";
		$stmt = $pdo->query($sql);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		$gameID = $row['id'];

	
		$mode = array();		
		if( $row['mode_single'] == 1 )
		{
			$mode_text = '单人模式';
			$mode_status = '1';
			$mode_link =  'swgame://saiweng.game/launchgame?gameid='.$game_id.'&gamename='.urlencode($row['name']).'&gamemode=single&userid='.$user_id.'&gamepkg='.$row['gamepkgname'].'&roundId=10';
			array_push($mode,array('mode'=>$mode_text,'link'=>$mode_link,'mode_status'=>$mode_status));
		}

		if( $row['mode_match'] == 1 )
		{
			$mode_text = '对战模式';
			$mode_status = '2';
			$mode_link =  'swgame://saiweng.game/launchgame?gameid='.$game_id.'&gamename='.urlencode($row['name']).'&gamemode=match&userid='.$user_id.'&gamepkg='.$row['gamepkgname'].'&roundId=10';
			array_push($mode,array('mode'=>$mode_text,'link'=>$mode_link,'mode_status'=>$mode_status));
		}

		if( $row['mode_race'] == 1 )
		{
			$mode_text = '排位模式';
			$mode_status = '3';
			$mode_link =  'swgame://saiweng.game/launchgame?gameid='.$game_id.'&gamename='.urlencode($row['name']).'&gamemode=race&userid='.$user_id.'&gamepkg='.$row['gamepkgname'].'&roundId=10';
			array_push($mode,array('mode'=>$mode_text,'link'=>$mode_link,'mode_status'=>$mode_status));
		}

		if( $row['mode_family'] == 1 )
		{
			$mode_text = '家庭模式';
			$mode_status = '4';
			$mode_link =  'swgame://saiweng.game/launchgame?gameid='.$game_id.'&gamename='.urlencode($row['name']).'&gamemode=family&userid='.$user_id.'&gamepkg='.$row['gamepkgname'].'&roundId=10';
			array_push($mode,array('mode'=>$mode_text,'link'=>$mode_link,'mode_status'=>$mode_status));
		}

		
		// 游戏详情
		$details = array(
					'name' => $row['name'],
					'icon' => $row['game_icon'],
					'form' => $row['form'],
					'mode' => $mode,
					'desc' => $row['game_desc'],
					'imgs' => array_filter(array(
									$row['game_img_1'],
									$row['game_img_2']
							   ))
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

		$recommend = array();
		foreach (array_rand($game_list,3) as $val) 
		{
			array_push($recommend,$game_list[$val]);
		}

		exit( json_encode(array('code'=>1,'data'=>array('users'=>$users,'details'=>$details, 'recommend'=>$recommend))) );

	break;




	// 排行榜
	case 'rank':

		$user_id = $_REQUEST['user_id'];
		$game_id = $_REQUEST['game_id'];

		if( !isset($user_id) || !isset($game_id) )
		{
			exit( json_encode(array('code'=>9002,'msg'=>'Missing parameters !')) );
		}

		$sql = " SELECT `id` FROM `user` WHERE `user_id`='$user_id' ";
		$stmt = $pdo->query($sql);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$userID = $row['id'];

		if( !$userID )
		{
			exit( json_encode(array('code'=>9004,'msg'=>'user_id is error !' )) );
		}


		$sql = " SELECT `id` FROM `game` WHERE `is_show`='1' AND `game_id`='$game_id' ";
		$stmt = $pdo->query($sql);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$gameID = $row['id'];

		if( !$gameID )
		{
			exit( json_encode(array('code'=>9004,'msg'=>'game_id is error !' )) );
		}

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
        // print_r($rank);

        $rank_new = array();
        foreach ($rank as $k => $v) 
        {
		    if (array_key_exists($v['user_id'], $rank_new)) 
		    {
		        $rank_new[$v['user_id']]['score'] += $v['score'];
		    } 
		    else 
		    {
		        $rank_new[$v['user_id']] = $v;
		    }
		}
		$rank_new = array_values($rank_new);

		array_multisort(array_column($rank_new,'score'),SORT_DESC,$rank_new);
		
        exit( json_encode(array('code'=>1,'data'=>array('rank'=>$rank_new))) );
        
	break;













	case 'rank22':

		$user_id = $_REQUEST['user_id'];
		$game_id = $_REQUEST['game_id'];
		$mode = $_REQUEST['mode'];

		if( !isset($user_id) || !isset($game_id) || !isset($mode) )
		{
			exit( json_encode(array('code'=>9002,'msg'=>'Missing parameters !')) );
		}

		$modes = array('1','2','3','4');
		if( !in_array($mode,$modes) )
		{
			exit( json_encode(array('code'=>9004,'msg'=>'mode is error !' )) );
		}

		$sql = " SELECT `id` FROM `user` WHERE `user_id`='$user_id' ";
		$stmt = $pdo->query($sql);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$userID = $row['id'];

		if( !$userID )
		{
			exit( json_encode(array('code'=>9004,'msg'=>'user_id is error !' )) );
		}


		$sql = " SELECT `id` FROM `game` WHERE `is_show`='1' AND `game_id`='$game_id' ";
		$stmt = $pdo->query($sql);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$gameID = $row['id'];

		if( !$gameID )
		{
			exit( json_encode(array('code'=>9004,'msg'=>'game_id is error !' )) );
		}


		$sql = " SELECT gu.`score`,u.`user_name`,u.`user_id`,u.`user_icon` 
				 FROM `game_user` gu,`user` u 
				 WHERE gu.`userID`=u.`id`
				 AND `gameID`='$gameID' 
				 AND `mode`='$mode' 
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

        exit( json_encode(array('code'=>1,'data'=>array('rank'=>$rank))) );
        
	break;



}



function randomkeys($length) 
{ 
   $pattern = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';
    for($i=0;$i<$length;$i++) 
    { 
        $key .= $pattern{mt_rand(0,51)}; 
    } 
    return $key; 
}



?>