<?php 
    
    include 'head_sub.php';

    //订购参数
    
	/* 事务编号（发起方透传）必须每次请求唯一；
	 sp编码(8位)+平台标识（2位）+时间戳(yyyyMMddHHmmss 14位)+序号（16位随机字符串，不含特殊字符）；
	 sp编码由平台创建，并线下提供给SP厂商。
	 平台标识：01表示华为平台；02标识中兴平台
	关于sp编码：,8位,视听类直接传入99999999,即可,非视听类定义如下:
	如圣剑SJ000001,玩吧WB000002,聚精彩 JJC00003,路通LT000004,炫彩互动 XC000005
	例如：SJ00000101201711180000343248230563503351*/
    $transactionID = "99999999" . "01" . date('YmdHis') . mt_rand(10000000,99999999) . mt_rand(10000000,99999999);


?>

<style type="text/css">

div{
    /*border:1px solid red;*/
}

.pay_div{
    position: absolute;
    width: 100%;
    height: 30%;
    top:30%;
    left: 0;
    text-align: center;
}

.pay_sub{
    width: 13%;
    height: 100%;
    margin-right: 8%;
    display: inline-block;
    position: relative;
    vertical-align: middle;
}

.pay_sub img{
    display: block;
}

.pay_text{
    position: absolute;
    padding: 5px;
    left: 10%;
    width: 100%;
    height: 25%;
    font-size: 20px;
    text-align: left;
}

.pay_sub .t1{
    top:10%;
}

.pay_sub .t2{
    top:30%;
}

.pay_sub .t3{
    top:50%;
}

.pay_sub .t4{
    top:70%;
}

.pay1{
    margin-top: -3%;
}

.pay_title{
    display: block;
    font-size: 20px;
    margin-top:5%;
}

.pay_div .qrcode{
    margin-right: 0;
    vertical-align:middle;
    background-color: white;
}

.qrcode .iblock {
    display:inline-block;
    height:100%;
    width:0;
    vertical-align:middle;
}

.qrcode span {
    display:block;
    margin:5% auto;
    font-size: 16px;
    font-weight: bold;
    color: grey;
}

a:focus{
    border: 3px solid #EBD55E;
    box-sizing: border-box;
}


.qr_div{
    display: none;
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    text-align: center;
    background-color: white;
}

.qr_div img{
    width: 30%;
    margin-top: 10%;
    margin-left: 35%;
    display: block;
    margin-top: 0 auto;
}

</style>

<img src="./images/BG.jpg">

<div class="pay_div">
    
    <div class="pay_sub pay1">
        <img id="img" src="" style="width: 100%;height: 110%;">
        <span class="pay_title"></span>
    </div>
    
    <div class="pay_sub ">
        <div class="pay_text t1">订阅观看</div>
        <div class="pay_text t2">○ 包月：5元</div>
        <div class="pay_text t3">○ 包季：12元</div>
        <div class="pay_text t4">○ 包年：25元</div>
    
    </div>
    
    <!-- <a class="pay_sub qrcode" href="#" onclick="$('.qr_div').show();$('.qr_div').focus();"> -->
    <a class="pay_sub qrcode" href="#" onclick="order();">
        <img src="./images/pay_wx.jpg" >
        <span>按OK键可放大二维码</span>
        <i class="iblock"></i>
    </a>

    <a class="pay_sub  " href="#" onclick="window.location.reload();">
        重新加载本页
    </a>

</div>



<a class="qr_div" href="#" onclick="$(this).hide();$('.qrcode').focus();">
    <img src="./images/pay_wx.jpg" >
</a>


<textarea id='debug' style="position: absolute;width: 50%;height:100vh;top:0;left: 0;font-size: 23px;border:1px solid yellow;color:black;"><h1>调试信息</h1>
</textarea>



<!-- =============================================================== -->

<script type="text/javascript">

//系统错误捕捉并打印到特定div
window.onerror = function ( msg, url, lineNo, columnNo, error) {

  $('#debug').html( $('#debug').html() + '<hr>Error: ' + msg + ' Script: ' + url + '\nPosition: ' + lineNo + ' / ' + columnNo
   + '\nStackTrace: ' +  error );

  return false;
};

$('.qrcode').focus();


var title  = '<?php echo $_GET['title']; ?>';

var img  = '<?php echo $_GET['img']; ?>';


$('#img').attr("src",img);

$('.pay_title').html(title);


//返回按键
window.document.onkeypress = function(event){

    var val = (event.keyCode == undefined || event.keyCode == 0) ? event.which: event.keyCode;
    
    if(val==8)
    {
        alert('当前处于大厅，无法返回了！');

        window.location.href = './main.php';
    }
};


/**
 * [order 内蒙电信产品订购]
 * @return {[type]} [description]
 */
function order()
{
	//1 SP鉴权--------------------------------------
    var paramsAidlToken = JSON.stringify({
        "apkPackageName": "com.udte.client.testdemo",
        "apkPackageVersion": "v1.1.1"
    });

    var aidlTokenStr = window.cs_interface.invokeCMD("SPAuth", paramsAidlToken);

    var objJson = JSON.parse(aidlTokenStr);

    console.log( 'aidlToken = '+objJson.aidlToken );

    localStorage.setItem('aidlToken', objJson.aidlToken );
    
	var aidlToken = objJson.aidlToken;

	var code = '<?php echo $_GET['code']; ?>';

	code = '04710001000000010000000010571454';

	var transactionID  = '<?php echo $transactionID; ?>';

	var notifyUrl = 'apk'; // http://172.25.120.17/vspn/api/notify.php

	if( !aidlToken ){
		alert('aidlToken获取错误！');
	}

	if( !code ){
		alert('code获取错误！');
	}

	if( !transactionID ){
		alert('transactionID获取错误！');
	}

	//订购参数拼接 --------------------------------------
    var paramsAidlToken = JSON.stringify({
        "aidlToken": aidlToken,
        "ContentID": code,
        "Action": "1", //1订购 2退订
        "transactionID": transactionID,
        "orderContinueFlag": "1",
        "SPID": "99999999",
        "notifyUrl": notifyUrl,//非视听的SP接受通知notifyUrl传HTTP打头的；不接受通知传APK 。视听直接传apk。
    });

    $('#debug').html( $('#debug').html() + '<hr> 发起订购:paramsAidlToken=' + paramsAidlToken );

    var aidlTokenStr = window.cs_interface.invokeCMD("programOrder", paramsAidlToken);

    $('#debug').html( $('#debug').html() + '<hr> 订购返回 = ' + aidlTokenStr );

    //var objJson = JSON.parse(aidlTokenStr);
}


</script>


<?php 
    
    include 'foot.php';

?>