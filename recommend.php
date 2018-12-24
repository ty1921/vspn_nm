<?php 
    
    include 'head_recommend.php';

?>

    <style type="text/css">
        .rows_div{
            display: none;
        }
    </style>

    <!-- 左下角 广告 -->
    <img class="free" src="./images/free.jpg">

    <!-- 右侧内容 -->
    <div class="right" style="height: 62%;">
        
        <!-- line 1 -->
        <div class="r1_top_div">

            <a id='p0' class="rows_div r1_top3" style="width: 44% !important;" href="#">
                <img id='img1' src=''>
                <span id='title1' class="class_cover"></span>
            </a>
            
            <a id='p1' class="rows_div r1_top3" href="#">
                <img id='img2' src=''>
                <span id='title2' class="class_cover"></span>
            </a>
            
            <a id='p2' class="rows_div r1_top3" href="#">
                <img id='img3' src=''>
                <span id='title3' class="class_cover"></span>
            </a>
            
            <a id='p3' class="rows_div r1_top3 rows_last"" href="#">
                <img id='img4' src=''>
                <span id='title4' class="class_cover"></span>
            </a>
            
            <div class="clear"></div>
        </div>


        <!-- line 2 -->
        <div class="r1_bottom_div">
            <a id='p4' class="rows_div r1_mid3" href="#">
                <img id='img5' src=''>
                <span id='title5' class="class_cover"></span>
            </a>

            <a id='p5' class="rows_div r1_mid3" href="#">
                <img id='img6' src=''>
                <span id='title6' class="class_cover"></span> 
            </a>

            <a id='p6' class="rows_div r1_mid3 rows_last" href="#">
                
            </a>

            <div class="clear"></div>
        </div>

    </div>


</div>


<script type="text/javascript">

    //返回按键
    window.document.onkeypress = function(event){

        var val = (event.keyCode == undefined || event.keyCode == 0) ? event.which: event.keyCode;
        
        if(val==8)
        {
            window.location.href = './main.php';
        }
    };






window.onload = function(){ 

    var game = '<?php echo $game; ?>';

    $.ajax({
       url : "./api/recommend.php",
       data:{
            'action':'list',
            'game': game
        },
        type : "get",
        dataType : "jsonp",
        timeout: "8000",
        jsonp: "callback",
        jsonpCallback:"ty192100",
        success : function(json)
        {
            console.log( json );

            if( json.code == 1 )
            {
               var len = json.data.length;

               for (var i =0; i < len; i++) 
               {
                    $('#p' + i ).attr( "href", "./play.php?code=" + json.data[i].code );

                    $('#p' + i ).html( "<img src='"+json.data[i].img+"'> <span class='class_cover'>"+json.data[i].title+"</span>" );

                    $('#p' + i ).show();
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

</script>



<?php 
    
    include 'foot.php';

?>