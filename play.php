<?php 
    
  include 'head_sub.php';

  //视频对应编码
  $code = $_REQUEST['code'];

  $live = (int)$_REQUEST['live'];

  $refer = (int)$_REQUEST['refer'];

  $times = time() . mt_rand(100,999);
?>

<!-- 通用二级播放页面 -->

<div class="play">
    
    <!-- 上左 -->
    <a class="play_left"  href="#" onclick="getPlayURL(obj);">

        <img id='img' src="" >

        <div style="background:url('./images/video_mask.png');opacity: 0.85;width: 100%;height: 100%;position: absolute;top:0;left:0;text-align: center;">
          <img id='img' src="./images/play.png" style="width: 100px;height:100px;position: absolute;top:50%;margin-top: -50px;margin-left:-50px;">
        </div>
        
        <input type="hidden" id="code" vale=''>
    </a>
    
    <!-- 上右 -->
    <div class="play_right">
        <div class="title"> &nbsp;   </div>
        <div class="desc">  &nbsp; </div>
        <div class="tag"> &nbsp;  </div>
        <!-- <div> 
            <a class="btn" href="#" onclick="tips();">
                <img src="./images/play/btn1.jpg" />
            </a>
        
            <a class="btn" href="#" onclick="tips();">
                <img src="./images/play/btn2.jpg" />
            </a>
        </div> -->

        <div>
          <a class="btn" href="#" onclick="getPlayURL(obj);">
              <button class="play_btn">播放</button>
          </a>
        </div>
    </div>


    <div class="play_select">
      <span class="select1">更多推荐</span>
    </div>

    <div class="play_select_div">
          <!-- 图文开始 -->
    </div> 

    <!-- 选集 -->
  <!--   <div class="play_select">
      <span class="select1">选集</span>
      <a class="rows" href="#"> 1-6 </a>
      <a class="rows" href="#"> 7-12 </a>
      <a class="rows" href="#"> 13-18 </a>
      <a class="rows" href="#"> 19-24 </a>
      <a class="rows" href="#"> 25-30 </a>
      <a class="rows" href="#"> 31-36 </a>
      <a class="rows" href="#"> 37-42 </a>
      <a class="rows" href="#"> 43-48 </a>
      <a class="rows" href="#"> 49-54 </a>
      <a class="rows" href="#"> 55-60 </a>
      <a class="rows" href="#"> 61-66 </a>
      <a class="rows" href="#"> 67-72 </a>
      <a class="rows" href="#"> 73-78 </a>
      <a class="rows" href="#"> 79-84 </a>
      <a class="rows" href="#"> 85-90 </a>
      <a class="rows" href="#"> 91-96 </a>
      <a class="rows" href="#" style="text-align: right;"> 97-102 </a>
  
      <div class="clear"></div>
  </div>
  
  
  选集对应的6个动态内容
  <div class="play_select_div">
  
      中部，按钮滚动
      <div class="match_mid_l " style="margin-right: -5%;"> </div>
  
      <div class="match_mid_r" style="margin-right: -5%;"> </div>
      
          图文开始
          <a href="#" class="select_div">
              <img src="./images//sai_22.jpg"> 
              <div class="more_text">【破冰英雄】 盘点 第12期：那些 英   【破冰英雄】 盘点 第12期：那些英</div>
          </a>
  
          <a href="#" class="select_div">
              <img src="./images//sai_22.jpg"> 
              <div class="more_text">【破冰英雄】 盘点 第12期：那些 英   【破冰英雄】 盘点 第12期：那些英</div>
          </a>
  
          <a href="#" class="select_div last">
              <img src="./images//sai_22.jpg"> 
              <div class="more_text">【破冰英雄】 盘点 第12期：那些 英   【破冰英雄】 盘点 第12期：那些英</div>
          </a>
  
          <a href="#" class="select_div">
              <img src="./images//sai_22.jpg"> 
              <div class="more_text">【破冰英雄】 盘点 第12期：那些 英   【破冰英雄】 盘点 第12期：那些英</div>
          </a>
  
          <a href="#" class="select_div">
              <img src="./images//sai_22.jpg"> 
              <div class="more_text">【破冰英雄】 盘点 第12期：那些 英   【破冰英雄】 盘点 第12期：那些英</div>
          </a>
  
          <a href="#" class="select_div last">
              <img src="./images//sai_22.jpg"> 
              <div class="more_text">【破冰英雄】 盘点 第12期：那些 英   【破冰英雄】 盘点 第12期：那些英</div>
          </a>
  
  
  </div> -->

</div>



<!-- <div id='debug' style="position: absolute;width: 50%;height:100vh;top:0;right: 0;font-size: 23px;border:0px solid yellow;color:yellow;"><h1>调试信息</h1></div> -->





<!-- js核心逻辑 开始 ---------------------------------------------->
<script type="text/javascript">

var refer = '<?php echo $refer; ?>';

//var code = '<?php echo $code ?>';

$('#debug').html( $('#debug').html() + '<hr>js开始');

var obj = new Object();

obj.global_code = '<?php echo $code ?>';  //$('#code').val();

$('#debug').html( $('#debug').html() + '<hr>播放视频：' + obj.global_code );



/**
1、获取节目code；
2、根据节目code获取播放地址；
3、替换播放地址，rtsp替换为http;
4、组合播放参数；
5、将播放参数传入播放器；
6、调用播放方法*/
function getPlayURL(obj) 
{
    var aidlToken = localStorage.getItem('aidlToken', -1 );

    traceLogPlayer( '109', obj.global_code, refer );

    var mediaType="live";

    var ProgramType="0";

    var paramsLiveUrl = JSON.stringify({
        "aidlToken": aidlToken,
        "tid": obj.global_code,
        "cid": obj.global_code,
        "supercid": '',
        "userID": '',
        "userToken": ''
        // "mediaType":mediaType,
        // "ProgramType":ProgramType,
    });


    $('#debug').html( $('#debug').html() + '<hr>token='+aidlToken+'，code=' + obj.global_code  );

    var pxayUrl = window.cs_interface.invokeCMD("getPlayURL", paramsLiveUrl);

    $('#debug').html( $('#debug').html() + '<hr>url = ' + pxayUrl );
    
    pxayUrl = JSON.parse(pxayUrl);

    if( pxayUrl.code == 0 )
    {
        var iid = pxayUrl.URL;

       var str1 = iid.replace('igmp', 'http');
     
       // showCurTitle(obj);
       
       $('#debug').html( $('#debug').html() + '<hr>开始播放 ');

       play(str1);
    }
    else
    {
        $('#debug').html( $('#debug').html() + '<hr>获取url错误： ' + pxayUrl.msg );

        window.location.href = "./pay.php?code=" + obj.global_code + "&img=" + $('#img').attr('src') + "&title=" + $('.title').html();
        
        $('#debug').html( $('#debug').html() + "<a href='./pay.php?code=" + obj.global_code + "&img=" + $('#img').attr('src') + "&title=" + $('.title').html() +"'>继续支付</a>");
    }

}

function initMediaStr(url) {
    var mediaStr = '[{mediaUrl:"' + url + '",';
    mediaStr += 'mediaCode: "jsoncode1",';
    mediaStr += 'mediaType:2,';
    mediaStr += 'audioType:1,';
    mediaStr += 'videoType:1,';
    mediaStr += 'streamType:1,';
    mediaStr += 'drmType:1,';
    mediaStr += 'fingerPrint:0,';
    mediaStr += 'copyProtection:1,';
    mediaStr += 'allowTrickmode:1,';
    mediaStr += 'startTime:0,';
    mediaStr += 'endTime:20000,';
    mediaStr += 'entryID:"jsonentry1"}]';
    return mediaStr;
}

function initMediaPlay(_left, _top, _width, _height) {
    var instanceId = mp.getNativePlayerInstanceID();
    var playListFlag = 0;
    var videoDisplayMode = 1,
        useNativeUIFlag = 1;
    var height = 0,
        width = 0,
        left = 0,
        top = 0;
    var muteFlag = 0;
    var subtitleFlag = 0;
    var videoAlpha = 0;
    var cycleFlag = 0;
    var randomFlag = 0;
    var autoDelFlag = 0;
    mp.initMediaPlayer(instanceId, playListFlag, videoDisplayMode, height, width, left, top, muteFlag, useNativeUIFlag, subtitleFlag, videoAlpha, cycleFlag, randomFlag, autoDelFlag);
    mp.setAllowTrickmodeFlag(0);
    mp.setNativeUIFlag(0);
    mp.setAudioTrackUIFlag(0);
    mp.setMuteUIFlag(0);
    mp.setAudioVolumeUIFlag(0);
    mp.setVideoDisplayArea(_left, _top, _width, _height);
    mp.setVideoDisplayMode(0);
    mp.refreshVideoDisplay();
}

function destoryMP() {
    try {
        var instanceId = mp.getNativePlayerInstanceID();
        mp.stop();
        mp.releaseMediaPlayer(instanceId);
    } catch (e) {}

}

function play(playUrl) {
    mp.setSingleMedia(initMediaStr(playUrl));
    mp.playFromStart(); 
    //=============================================
}

// 快进
function fastforward() {
    mp.fastForward(1);
}
// 快退
function fastRewind() {
    mp.fastRewind(1);
}
// 暂停
function pause() {
    //  mp.pause();
}
// 按时间播放
function playByTime() {
    mp.playByTime(1, 65000, 1);
}
// 获取当前音量
function getVolume() {
    var _volume = mp.getVolume();
    document.getElementById("_test").innerHTML = "当前音量：" + _volume; // 测试代码，显示当前音量值
    return _volume;
}
// 设置当前音量
function setVolume(volume) {
    mp.setVolume(volume);
    document.getElementById("_test").innerHTML = "当前音量：" + mp.getVolume(); // 测试代码，显示当前音量值
}



//返回按键,返回上一页
window.document.onkeypress = function(event){

    var val = (event.keyCode == undefined || event.keyCode == 0) ? event.which: event.keyCode;
    
    if(val==8)
    {
        if ( refer == 109 || document.referrer == '' || document.referrer.indexOf("play.php")>-1 ) 
        {
          window.location.href = './';
        }
        else
        {
          history.back();
        }
    }
};





window.onload = function(){ 

    var code = '<?php echo $code; ?>';

    var live = '<?php echo $live; ?>';

    //300秒发送一次浏览日志
    traceLogBrowse( '109', code, refer );

    setInterval(function(){
        traceLogBrowse( '109', code, refer );
    },300000);
        

    $.ajax({
       url : "./api/code.php",
       data:{
            'action':'info',
            'code': code,
            'live': live
        },
        type : "get",
        dataType : "jsonp",
        timeout: "8000",
        jsonp: "callback",
        jsonpCallback:"ty192100",
        success : function(json)
        {
            console.log( json );

            if( json.code == 1 && json.data[0].type == 'main' )
            {
                if( json.data[0].title ) $('.title').html( json.data[0].title );

                if( json.data[0].desc ) $('.desc').html( '简介：' + json.data[0].desc );

                if( json.data[0].tag ) $('.tag').html( 'Tag：' + json.data[0].tag );

                if( json.data[0].img ) 
                {
                    $('#img').attr('src', json.data[0].img );
                }
                else
                {
                    $('#img').attr('src', './images/novideo.jpg' );
                }

                //默认焦点在图片上
                $('.play_left').focus();

                
                if( json.data[0].code ) $('#code').val( json.data[0].code );



                for(var i = 1; i < json.data.length; i++) 
                {
                    var last = '';

                    if( i == 3 || i == 6 )
                    {
                        last = 'last';
                    }

                    if( !json.data[i].img )
                    {
                        json.data[i].img = './images/nopic.jpg';
                    }

                    $('.play_select_div').html( $('.play_select_div').html() + 

                     "<a href='./play.php?refer=109&code=" + json.data[i].code + "' class='select_div " + last + "'> \
                        <img src='" + json.data[i].img + "'> \
                        <div class='more_text'> " + json.data[i].title + " </div> \
                      </a>");
                }
        }
           else
           {
                alert('视频信息错误，请返回重试！');

                history.back();
           }
       },
       error:function()
       {
           console.log('数据获取错误');
       }
    });

} 


function tips(){
   alert('功能开发中，敬请期待');
}



//300秒发送一次浏览日志
setInterval(function(){
    
},300000);


</script>


<!-- js核心逻辑 结束 ---------------------------------------------->





<?php 
    
    include 'foot.php';

?>