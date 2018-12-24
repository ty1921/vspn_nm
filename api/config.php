<?php

//-------------------------------------------------------------------------------
//参数定义 

//定义跟根录
define('ROOTDIR',realpath(__DIR__) );   

//定义根域名
$host = 'http://192.168.14.133/iptv/api'; 

//定义默认的图片拼接地址
$host_pic = 'http://192.168.14.133/iptv/images/';  

//分页默认15条每页
$page_num = 15;


//首页菜单项
$menu_list = array
(
  "推荐" => './main.php',
  "专区" => './area.php',
  "赛事" => './match.php',
  "主播" => './live.php',
  "游戏" => './game/'
);

