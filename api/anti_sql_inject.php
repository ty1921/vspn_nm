<?php

//SQL过滤,防注入

$fuck_arr = array( "'","\\","+","script","and","where","select","insert","update","delete","union","into","create","alter","drop","truncate","table","database" );

$len = count($fuck_arr);

foreach($_GET as $key=>$value)
{
	for( $i=0;$i<$len;$i++)
	{
	  if( strpos( strtolower( urldecode($value) ),$fuck_arr[$i]) )
	  {
	  		$anti_info = "[".strftime("%Y-%m-%d %H:%M:%S")."] IP: ".$_SERVER["REMOTE_ADDR"]." |PAGE:".$_SERVER["PHP_SELF"]." |METHOD: ".$_SERVER["REQUEST_METHOD"]." |datas: ".$key."=".$value ;

	  		slog( $anti_info );

	    	exit("请立即停止攻击，已记录相关信息，并保留法律追责的权利。<hr>".$key."=".$value) ;
	  }
	}
}


function slog($logs)
{
	$toppath = '../logs/anti_safeSQL.log';

	$Ts 	 = fopen($toppath,"a+");

	fputs($Ts,$logs."\r\n");

	fclose($Ts);
}