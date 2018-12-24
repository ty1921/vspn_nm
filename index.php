<?php

error_reporting( E_ALL && ~E_NOTICE );

?>

<!-- <div id='debug' style="position: absolute;width: 84%;height:400px;top:5%;right: 5%;padding:3%;border:1px solid red;">
<h1>正在鉴权，请稍候...</h1>
</div>
 -->
<style type="text/css">

html,body{
    background: #000000;
}

</style>



<script src="./js/jquery.min.js"></script>

<!-- 日志埋点 -->
<script src="./js/comm.js"></script>


<script type="text/javascript">

var backUrl = '<?php echo $_GET['backUrl'] ? $_GET['backUrl'] : './main.php'; ?>';



//系统错误捕捉并打印到特定div
window.onerror = function ( msg, url, lineNo, columnNo, error) {

    //$('#debug').html( $('#debug').html() + '<hr>Error: ' + msg + ' Script: ' + url + '\nPosition: ' + lineNo + ' / ' + columnNo + '\nStackTrace: ' +  error  + "<br><br><br><a href='./main.php'>继续访问</a>" );

    //3 跳转
    window.location.href = backUrl;

    return false;
};


$(document).ready(function(){

    //刷新令牌
    getToken();

    //3 跳转
    window.location.href = backUrl;

});
 
 </script>