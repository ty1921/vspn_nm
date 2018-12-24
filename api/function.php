<?php

/**
 * [fnCheckParas 检测method的指定参数paras数组中的值是否为空]
 * @param  [arr]  $paras   [待检测的参数数组]
 * @param  integer $method [默认1=POST]
 * @return [bool]          
 */
function fnCheckParas( $paras,$method = 1 )
{   
    foreach( $paras as $k=>$v )
    {
        if( !isset($_REQUEST[$v]) )
        {
            $res = array ('code'=>9000,'msg'=>'parameter lost:'.$v.'='.$_REQUEST[$v],'time'=>time() );

            exit( json_encode($res) );
        }
    }
}



/**
 * [show_page 分页函数]
 * @param  [int]  $cnt       [数据库总条数]
 * @param  [int]  $page      [送入第几页]
 * @param  [int]  $page_size [每页长度]
 * @return [char]            [分页用到的拼接好的html code]
 */
function show_page($cnt,$page,$page_size){

    $page_count  = ceil($cnt/$page_size);  //计算得出总页数

    $init=1;
    $page_len=10;
    $max_p=$page_count;
    $pages=$page_count;

    //判断当前页码
    $page=(empty($page)||$page<0)?1:$page;
    //获取当前页url
    $url = $_SERVER['REQUEST_URI'];
    //去掉url中原先的page参数以便加入新的page参数
    $parsedurl=parse_url($url);
    $url_query = isset($parsedurl['query']) ? $parsedurl['query']:'';
    if($url_query != ''){
        $url_query = preg_replace("/(^|&)page=$page/",'',$url_query);
        $url = str_replace($parsedurl['query'],$url_query,$url);
        if($url_query != ''){
            $url .= '&';
        }
    } else {
        $url .= '&';
    }
     
    //分页功能代码
    $page_len = ($page_len%2)?$page_len:$page_len+1;  //页码个数
    $page_len = 5;
    //$pageoffset = ($page_len-1)/2;  //页码个数左右偏移量
    $pageoffset = 2;
    
    $navs='';
    if($pages != 0){
        if($page!=1){
            $navs.=" <li class='previous'><a href=\"".$url."page=1\">首页</a> ";        //第一页
            $navs.="<li><a href=\"".$url."page=".($page-1)."\">上页</a></li>"; //上一页
        } else {
            $navs .= "<li class='disabled'><a href='#'>首页</a></li>";
            $navs .= "<li class='disabled'><a href='#'>上页</a></li>";
        }
        if($pages>$page_len)
        {
            //如果当前页小于等于左偏移
            if($page<=$pageoffset){
                $init=1;
                $max_p = $page_len;
            }
            else  //如果当前页大于左偏移
            {    
                //如果当前页码右偏移超出最大分页数
                if($page+$pageoffset>=$pages+1){
                    $init = $pages-$page_len+1;
                }
                else
                {
                    //左右偏移都存在时的计算
                    $init = $page-$pageoffset;
                    $max_p = $page+$pageoffset;
                }
            }
        }
        
        for($i=$init;$i<=$max_p;$i++)
        {
            if($i==$page){$navs.="<li class='active'><a href='#'>".$i.'</a></li>';} 
            else {$navs.=" <li><a href=\"".$url."page=".$i."\">".$i."</a></li>";}
        }
        if($page!=$pages)
        {
            $navs.="<li class='next' ><a href=\"".$url."page=".($page+1)."\">下页</a></li>";//下一页
            $navs.="<li><a href=\"".$url."page=".$pages."\">末页</a></li>";    //最后一页
        } else {
            $navs .= "<li class='disabled'><a href='#'>下页</a></li>";
            $navs .= "<li class='disabled'><a href='#'>末页</a></li>";
        }
        return $navs;
    }
}


/**
 * [fnImgUpload 通用图片上传]
 * @param  [char] $type     [文件类型]
 * @param  [char] $tmp_name [临时文件名]
 * @param  [char] $name     [文件名]
 * @return [char]           [图片的线上地址]
 */
function fnImgUpload( $type, $tmp_name, $name )
{
    //1 上传错误检查
    if( $_FILES['file']['error'] > 0 )
    {
        if( $_FILES['file']['error'] <= 2 )
        {
            $res = array ('code'=>9004,'msg'=>'文件过大！','time'=>time() );
        }
        elseif( $_FILES['file']['error'] == 3 )
        {
            $res = array ('code'=>9004,'msg'=>'文件传输错误，有部分数据丢失！','time'=>time() );
        }
        elseif( $_FILES['file']['error'] == 4 )
        {
            $res = array ('code'=>9004,'msg'=>'没有文件被上传！','time'=>time() );
        }
        else
        {
            $res = array ('code'=>9004,'msg'=>'文件传输错误！','time'=>time() );
        }

        exit( json_encode($res) );
    }

    //2 路径检查
    $basedir  = dirname(__FILE__);
    
    $subpath  = '../images/upload/'.date('Ymd').'/';

    $subpath2 = './images/upload/'.date('Ymd').'/';
    
    $path     = $basedir.'/'.$subpath; 
    

    //检查是否有该文件夹，如果没有就创建，并给予权限
    if(!file_exists($path))
    {
        mkdir( "$path" );
        
        chmod( "$path" ,0700);
    }

    
    //3 图片类型检测
    $tp = array("image/gif","image/pjpeg","image/jpeg","image/jpg","image/png","image/bmp","image/x-png");
    
    if( !in_array( $type,$tp ) )
    {
        return false;
    }
    
    //4 拼接文件名，开始上传
    $newname  = date('YmdHis').mt_rand(1000,9999).substr( $name ,-4 );
    
    $newpath  = $path.$newname; //文件物理全路径
    
    $result   = move_uploaded_file( $tmp_name, $newpath );   //移动到指定位置
    
    if($result)
    {
        return $subpath2.$newname;
    }
    else
    {
        $res = array ('code'=>9004,'msg'=>'车身图片存储失败，请联系管理员！','time'=>time() );
        
        exit( json_encode($res) );
    }

}






/** 
*  数据导入 
* @param string $file excel文件的路径，tempname？
* @param string $sheet 
 * @return string   返回解析数据 
 * @throws PHPExcel_Exception 
 * @throws PHPExcel_Reader_Exception 
*/  
function importExecl($file='', $sheet=0)
{  
    $file = iconv("utf-8", "gb2312", $file);   //转码  

    if(empty($file) OR !file_exists($file)) 
    {  
        die('file not exists!');  
    }  

    include( __DIR__ . '/PHPExcel-1.8/Classes/PHPExcel.php');  //引入PHP EXCEL类  

    $objRead = new PHPExcel_Reader_Excel2007();   //建立reader对象  

    if(!$objRead->canRead($file))
    {  
        $objRead = new PHPExcel_Reader_Excel5();  

        if(!$objRead->canRead($file))
        {  
            die('No Excel!');  
        }  
    }  
  
    $cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');  
  
    $obj = $objRead->load($file);  //建立excel对象  

    $currSheet = $obj->getSheet($sheet);   //获取指定的sheet表  

    $columnH = $currSheet->getHighestColumn();   //取得最大的列号  

    $columnCnt = array_search($columnH, $cellName);  

    $rowCnt = $currSheet->getHighestRow();   //获取总行数  
  
    $data = array();  

    for($_row=1; $_row<=$rowCnt; $_row++)
    {  //读取内容  
        for($_column=0; $_column<=$columnCnt; $_column++)
        {  
            $cellId = $cellName[$_column].$_row;  

            $cellValue = $currSheet->getCell($cellId)->getValue();  

             //$cellValue = $currSheet->getCell($cellId)->getCalculatedValue();  #获取公式计算的值
             //  
            if($cellValue instanceof PHPExcel_RichText)
            {   
            	//富文本转换字符串  
                $cellValue = $cellValue->__toString();  
            }  
  
            $data[$_row][$cellName[$_column]] = $cellValue;  
        }  
    }  
  
    return $data;  
}




/**
 * [fnPush 下发地锁动作]
 * @param  [char] $client_id [网关ID]
 * @param  [char] $lock_no   [待操作的锁]
 * @param  [int]  $status    [待改变到的状态]
 * @return [int]             [1成功]
 */
function fnPush( $client_id, $lock_no, $status )
{
    $msg = '{ "action":"push", "client_id":"'.$client_id.'", "lock_no":"'.$lock_no.'", "status":"'.$status.'" }';
 
    // 建立连接，@see http://php.net/manual/zh/function.stream-socket-client.php
    $client = stream_socket_client('tcp://127.0.0.1:7273');

    if( !$client )
    {
        return 0;
    }
    else
    {
        $res = fwrite($client, $msg."\n");

        //$res = '{"device":"'.$lock_no.'","action":"'.$status.'"}';

        return 1;
    }

    // echo "<hr> send to: $client, msg: $msg <hr>";

    // print_r( $res );
}




/**
 * [DO_POST curl函数]
 * @param [type]  $url          [访问的URL]
 * @param string  $post         [post数据(不填则为GET)]
 * @param string  $cookie       [提交的$cookies]
 * @param integer $returnCookie [是否返回$cookies]
 */
 function fnCurl( $url,$post='',$cookie='', $returnCookie=0 )
 {
        //echo $url."||";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/6.0)');
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        
        if($post) 
        {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        }

        if($cookie) 
        {
            curl_setopt($curl, CURLOPT_COOKIE, $cookie);
        }

        curl_setopt($curl, CURLOPT_HEADER, $returnCookie);
        curl_setopt($curl, CURLOPT_TIMEOUT, 15);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        
        $data = curl_exec($curl);

        if (curl_errno($curl)) 
        {
            return curl_error($curl);
        }

        curl_close($curl);

        if($returnCookie)
        {
            list($header, $body) = explode("\r\n\r\n", $data, 2);
            preg_match_all("/Set\-Cookie:([^;]*);/", $header, $matches);
            $info['cookie']  = substr($matches[1][0], 1);
            $info['content'] = $body;
            return $info;
        }
        else
        {
            return $data;
        }
}

