<?php 
    
    include 'head.php';

?>


<!--2.1 left start ---------------------------------------->
<div class='left_div'>
    
    <!-- img -->
    <div class='left_img'  > 
        <img id='main_img' src='./images/index2/live.jpg'> 
    </div>
    
    <div class='clear'></div>
    

    <!-- text -->
    <div class='live_div'> 

        <a id='live_title' class='live_title' href='./play.php?code=04710001000000100000000000065948&refer=100'>
            最强王者
        </a>

        <a id='live_title' class='live_title live_title2' href='./play.php?code=04710001000000100000000000016823&refer=100'>
            小苍吃鸡萌新宝典
        </a>

        <a id='live_title' class='live_title' href='./play.php?code=04710001000000100000000000016830&refer=100'>
            全军出击天天贱
        </a>

        <a id='live_title' class='live_title live_title2' href='./play.php?code=04710001000000100000000000070663&refer=100'>
            夏明子解说
        </a>

        <a id='live_title' class='live_title' href='./play.php?code=04710001000000100000000000071281&refer=100'>
            英雄联盟S8全球小组赛 
        </a>
    
    </div>

</div>


<!-- 2.2 right start -------------------------------------- -->
<div class='right_div'>
    
    <div class='r_top_div'>
        <a class='r_top' href='./play.php?code=04710001000000100000000000070040&refer=100'>
            <img src='./images/index2/r1.jpg' /> 
            <span class='class_cover'>LPL夏季赛</span> 
        </a>


        <a class='r_top r_top_right' href='./play.php?code=04710001000000100000000000065948&refer=100'>
            <img src='./images/index2/r2.jpg' /> 
            <span class='class_cover'>最强王者</span> 
        </a>

        <div class='clear'></div>

    </div>

<style type="text/css">
.r_index{
    width: 22.7%;
    margin-right: 3%;
}

</style>

    <div class='r_mid_div'>
        <a class='r_mid r_index' href='./play.php?code=04710001000000100000000000071280&refer=100'>
            <img src='./images/index2/m1.jpg'> 
            <span class='class_cover'>英雄联盟S8全球入围赛</span> 
        </a>

        <a class='r_mid r_index' href='./play.php?code=04710001000000100000000000070434&refer=100'>
            <img src='./images/index2/m2.jpg'> 
            <span class='class_cover'>英雄联盟季中冠军杯</span> 
        </a>

        <a class='r_mid r_index' href='./play.php?code=04710001000000100000000000070007&refer=100'>
            <img src='./images/index2/m3.jpg'> 
            <span class='class_cover'>PCPI绝地求生中国赛</span> 
        </a>

        <a class='r_mid r_index r_mid_4' href='./play.php?code=04710001000000100000000000070015&refer=100'>
            <img src='./images/index2/m4.jpg'> 
            <span class='class_cover'>剑网3九周年发布会</span> 
        </a>

        <div class='clear'></div>
    </div>


    <a class='r_bottom'>
        <img class='r_bottom_img' src='./images/index2/bottom.jpg'> 
    </a>

</div> 



<script type="text/javascript">


//返回按键
window.document.onkeypress = function(event){

    var val = (event.keyCode == undefined || event.keyCode == 0) ? event.which: event.keyCode;
    
    if(val==8)
    {
        alert('当前处于大厅，无法返回了！');

        history.back();
    }
};

//首页左侧
$('.live_title').focus(function(){

    //移除所有on
    $('.on').removeClass('on');

    //图片选择
    //$('.left_img').addClass('on');

    //自身
    $(this).addClass('on');

});


//首页左侧
$('.r_top,.r_mid,.r_bottom').focus(function(){

    //移除所有on
    $('.on').removeClass('on');

    //自身
    $(this).addClass('on');

});


window.onload = function(){ 
    //300秒发送一次浏览日志
    traceLogBrowse( '100', '', 'main' );
    
    setInterval(function(){
        traceLogBrowse( '100', '', 'main' );
    },300000);
}

/*
//获取游戏推荐
$.ajax({
   url : "./json/index.json",
   type : "GET",
   dataType : "json",
   jsonp: "callback",
   jsonpCallback:"success_call3",
   {
   success : function(json)
        console.log( json );

        var html = '';

        var len = json.left.length;

        if( len > 0 )
        {
           var html='';

           var css1 = 'live_title';

           var live_icon = '';

           for( var i = 0; i < len; i++ )
           {
                if( i % 2 == 0 )
                {
                    css1 += ' live_title2';
                }

                if( json.left[i].live )
                {
                    css1 += ' live_title2';
                }

                html += "<a class='" + css1 + "' href='./play.php'> " 
                            + json.left[i].title 
                            + " <span class='icon_live'> " + json.left[i].id + " </span>\
                        </a>";
           }
           $('.gameList_box .swiper-wrapper').html(html);

           $('.gameList_box .swiper-slide img').height($('.gameList_box .swiper-slide').width());

       }
   },
   error:function()
   {
       console.log('数据获取错误');
   }
});
*/



</script>



<?php 
    
    include 'foot.php';

?>