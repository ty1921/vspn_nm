//===============================================================================

var epg_type = 1;//vspn=1, game=2

var log_aidlToken = localStorage.getItem('aidlToken', -1 );

var log_userID    = localStorage.getItem('userID', -1 );


//系统错误捕捉并打印到特定div
window.onerror = function ( msg, url, lineNo, columnNo, error) {

  var msg = 'Error: ' + msg + ' Script: ' + url + '\nPosition: ' + lineNo + ' / ' + columnNo
   + '\nStackTrace: ' +  error ;

  //模拟需要付费
  //window.location.href = './pay.php?code=' + obj.global_code + '&img=' + $('#img').attr('src') + '&title=' + $('.title').html() ;

  console.log( msg );

  //return false;
};


//===============================================================================
//获取令牌，过期时间2小时;并获取用户信息
function getToken()
{
    if( window.cs_interface )
    {
        //1 SP鉴权--------------------------------------
        var paramsAidlToken = JSON.stringify({
            "apkPackageName": "com.udte.launcher",
            "apkPackageVersion": "v1.0.0"
        });

        var aidlTokenStr = window.cs_interface.invokeCMD("SPAuth", paramsAidlToken);

        var objJson = JSON.parse(aidlTokenStr);

        console.log( 'aidlToken = '+objJson.aidlToken );

        log_aidlToken = objJson.aidlToken;

        localStorage.setItem('aidlToken', objJson.aidlToken );


        //2 取用户信息----------------------------------
        var paramsUser = JSON.stringify({
            "aidlToken": objJson.aidlToken
        });

        var userInfo = window.cs_interface.invokeCMD("getUserProfile", paramsUser);

        var objUser = JSON.parse(userInfo);

        if( objUser.code == 1 )
        {
            log_userID = objUser.userID;

            console.log( 'userID = '+ objUser.userID );

            localStorage.setItem('userID', objUser.userID );
        }
        else
        {
            //未能获取到用户信息
            console.log( 'get userinfo error：'+objUser.msg );
        }
    }
    else
    {
        //未能获取到用户信息，随机生成userID
        var chars = ['0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];

         var userID = "";
         for(var i = 0; i < 8 ; i ++) 
         {
             var id = Math.ceil(Math.random()*35);

             userID += chars[id];
         }

        log_aidlToken = userID;

        log_userID    = userID;

        localStorage.setItem('aidlToken', 'tmp_' + userID );

        localStorage.setItem('userID', 'tmp_' + userID );
    }
}


//===============================================================================
/**
 * [traceLogBrowse 界面浏览探针上报，每300秒的定时器]
 * @param  {[type]} id        [页面编号，自定义即可]
 * @param  {[type]} code      [详情页节目ID，列表页传页面编号]
 * @param  {[type]} refer  [上一页的页面编号，首页为空]
 * @return null          
 */
function traceLogBrowse( id, code, refer='' )
{
    //上报给我方平台
    $.ajax({
       url : "./api/log.php",
       data:{
            'type': epg_type, //1：vspn   2：game
            'action':'Browse',
            'page_id': id,  
            'page_name': document.title,
            'code': code,
            'refer': refer,
            'userid': log_userID
        },
        type : "get",
        dataType : "jsonp",
        timeout: "8000",
        jsonp: "callback",
        jsonpCallback:"ty" + parseInt( 1000 * Math.random() ),
        success : function(json)
        {
            console.log( json );
       },
       error:function()
       {
           console.log('数据上报错误');
       }
    });


    if( window.cs_interface )
    {
        //上报给ITV
        var paramsLog = JSON.stringify({
            "aidlToken": log_aidlToken,
            "mediacode": code,
            "pageId": id,
            "referType": "0",
            "refer_page_id": refer,
            "refer_pos_id": id + '||' + code,
            "refer_page_name": refer,
            "page_name": document.title,
            "medianame": code,
            "refer_pos_name": "",
            "path": ""
        });

        window.cs_interface.invokeCMD("traceLogPlayer", paramsLog);
    }
}


//===============================================================================
/**
 * [traceLogProgramClick 节目点击探针发送]
 * @param  {[type]} id        [页面编号，自定义即可]
 * @param  {[type]} code      [详情页节目ID，列表页传页面编号]
 * @param  {[type]} refer_id  [上一页的页面编号，首页为空]
 * @return null          
 */
function traceLogProgramClick( code )
{
    //上报给我方平台
    $.ajax({
       url : "./api/log.php",
       data:{
            'type': epg_type, //1：vspn   2：game
            'action':'Program',
            'page_id': id,  
            'page_name': document.title,
            'code': code,
            'refer': refer_id,
            'page_name': document.title,
            'userID': userID
        },
        type : "get",
        dataType : "jsonp",
        timeout: "8000",
        jsonp: "callback",
        jsonpCallback:"ty" + parseInt( 1000 * Math.random() ),
        success : function(json)
        {
            console.log( json );
       },
       error:function()
       {
           console.log('数据上报错误');
       }
    });

    if( window.cs_interface )
    {
        //上报给ITV
        var paramsLog = JSON.stringify({
            "aidlToken": log_aidlToken,
            "actionType": "vod_playing",
            "mediacode": code,
            "definition": "2",
            "startTime": "<?php echo $times; ?>",
            "referType": "2",
            "currentplaytime": "<?php echo $times; ?>"
        });

        window.cs_interface.invokeCMD("traceLogProgramClick", paramsLog);
    }
}


//===============================================================================
/**
 * [traceLogPlayer 视频播放日志]
 * @param  {[type]} code [description]
 * @return {[type]}      [description]
 */
function traceLogPlayer( id, code )
{
    //上报给我方平台
    $.ajax({
       url : "./api/log.php",
       data:{
            'type': epg_type, //1：vspn   2：game
            'action':'Play',
            'page_id': id,  
            'page_name': document.title,
            'code': code,
            'refer': refer,
            'userID': userID
        },
        type : "get",
        dataType : "jsonp",
        timeout: "8000",
        jsonp: "callback",
        jsonpCallback:"ty" + parseInt( 1000 * Math.random() ),
        success : function(json)
        {
            console.log( json );
       },
       error:function()
       {
           console.log('数据上报错误');
       }
    });

    if( window.cs_interface )
    {
        //上报给ITV
        var paramsLog = JSON.stringify({
            "aidlToken": log_aidlToken,
            "actionType": "vod_playing",
            "mediacode": obj.global_code,
            "definition": "2",
            "startTime": "<?php echo $times; ?>",
            "referType": "2",
            "currentplaytime": "<?php echo $times; ?>"
        });

        window.cs_interface.invokeCMD("traceLogPlayer", paramsLog);
    }
}