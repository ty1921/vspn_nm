<?php 
    
    include 'head_recommend.php';

?>

    
    <!-- 右侧内容 -->
    <div class="right hot">
        
        <div class="hot_div">
            <a class="rows_div r2_mid5" href="#">
                <img src="./images/biggod/biggod04.png"> 
                    <span class="class_cover"> 零度 </span>
            </a>

            <a class="rows_div r2_mid5" href="#">
                <img src="./images/biggod/biggod03.jpg"> 
                    <span class="class_cover"> 瓶子 </span> 
            </a>

            <a class="rows_div r2_mid5" href="#">
                <img src="./images/biggod/biggod01.jpg"> 
                    <span class="class_cover">美人鱼头</span> 
            </a>

            <a class="rows_div r2_mid5" href="#">
                <img src="./images/biggod/biggod02.jpg"> 
                    <span class="class_cover"> 板娘 </span> 
            </a>

            <a class="rows_div r2_mid5 rows_last" href="#">
              <img src="./images/competition/hotCom01.jpg"> 
                  <span class="class_cover">王者荣耀全民赛</span>
          </a>

            <div class="clear"></div>
        </div>

        
        <div class="hot_div">
            <a class="rows_div r2_mid5" href="#">
                <img src="./images/competition/hotCom02.png"> 
                <span class="class_cover"> 2017王者高校联赛 </span>
            </a>

            <a class="rows_div r2_mid5" href="#">
                <img src="./images/competition/hotCom03.jpg"> 
                <span class="class_cover"> LPL职业联赛 </span> 
            </a>

            <a class="rows_div r2_mid5" href="#">
                <img src="./images/competition/hotCom04.jpg"> 
                <span class="class_cover">2018CFPL</span> 
            </a>

            <a class="rows_div r2_mid5" href="#">
                <img src="./images/competition/hotCom01.jpg"> 
                <span class="class_cover"> 王者荣耀全民赛 </span> 
            </a>

            <a class="rows_div r2_mid5 rows_last" href="#">
              <img src="./images/competition/hotCom06.jpg"> 
                <span class="class_cover">2018KPL春季赛</span>
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
            window.location.href = './recommend.php';
        }
    };

</script>


<?php 
    
    include 'foot.php';

?>