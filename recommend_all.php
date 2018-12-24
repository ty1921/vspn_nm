<?php 
    
    include 'head_recommend.php';

?>

    
    <!-- 右侧内容 -->
    <div class="right">
        
        <div class="r2_div">

        </div>

    </div>


</div>


<script type="text/javascript">

    //返回按键
    window.document.onkeypress = function(event){

        var val = (event.keyCode == undefined || event.keyCode == 0) ? event.which: event.keyCode;
        
        if(val==8)
        {
            window.location.href = './recommend.php';
        }
    };



window.onload = function(){ 

    var game = '<?php echo $game; ?>';

    $.ajax({
       url : "./api/recommend.php",
       data:{
            'action':'list',
            'game': game,
            'all':1
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

                var html = '';

                var img_height = parseInt( $('.r2_div' ).width() * 0.14 );

                for (var i =0; i < len; i++) 
                {
                    var last = '';

                    if( (i + 1) % 4 == 0)
                    {
                        last = 'rows_last';

                        //console.log( 'i=' + i );
                    }

                    if( !json.data[i].img )
                    {
                        json.data[i].img = './images/nopic.jpg';
                    }

                    html += "   <a class='rows_div r1_mid4 "+ last +"' href='./play.php?code="+ json.data[i].code +"' style='height: " + img_height + "px;'>\
                                    <img src='"+ json.data[i].img +"'> \
                                        <span class='class_cover '>"+ json.data[i].title +"</span>\
                                </a>";

                    $('.r2_div' ).html( html + " <div class='clear'></div>" );
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