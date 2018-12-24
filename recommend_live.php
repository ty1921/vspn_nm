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

  <!--           <a class="rows_div r2_mid5 rows_last">
      <img src="./images/biggod/rcmd02.jpg"> 
          <span class="class_cover class_cover_small">王者荣耀瓶子教学</span>
  </a> -->

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