<?php 
    
    include 'head_live.php';

?>
    <!-- 专题图片，人物头像或赛事专题 -->
    <img class="logo2" src="./images/live/1.png">
    <div class="logo2_text"> <?php echo $_REQUEST['name'];?> </div>
    
    <!-- 右侧内容 -->
    <div class="right hot">
        
        <div class="hot_div">
            <a class="rows_div r2_mid5">
                <img src="./images/biggod/biggod04.png"> 
                    <span class="class_cover"> 零度 </span>
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
            window.location.href = './live.php';
        }
    };

</script>


<?php 
    
    include 'foot.php';

?>