<?php 
    
    include 'head_sub.php';

?>

<img src="./images/BG.jpg"> 

<!-- 导航 -->
<div class="my">
    <a href="./my.php?menu=1" class="my_nav <?php if($_GET['menu']==1 || empty($_GET['menu'] )) echo 'on'; ?> ">
        播放记录
    </a>

    <a href="./my.php?menu=2" class="my_nav <?php if($_GET['menu']==2 ) echo 'on'; ?> ">
        收藏专题
    </a>
</div>


<div class="area">
    <ul class="area1">
        <li>
            <a class="area_img" href="./recommend.php">
                <img src="./images/recommend/rcmd06.jpg"> 
            </a>
        </li>

        <li>
            <a class="area_img" href="./recommend.php">
                <img src="./images/recommend/rcmd06.jpg"> 
            </a>
        </li>

        <li>
            <a class="area_img" href="./recommend.php">
                <img src="./images/recommend/rcmd06.jpg"> 
            </a>
        </li>

        <li>
            <a class="area_img" href="./recommend.php">
                <img src="./images/recommend/rcmd06.jpg"> 
            </a>
        </li>

        <li>
            <a class="area_img" href="./recommend.php">
                <img src="./images/recommend/rcmd06.jpg"> 
            </a>
        </li>        
    </ul>
    

    <ul class="area2">
        <li>
            <a class="area_img" href="./recommend.php">
                <img src="./images/recommend/rcmd06.jpg"> 
            </a>
        </li>

        <li>
            <a class="area_img">
                <img src="./images/recommend/rcmd06.jpg"> 
            </a>
        </li>

        <li>
            <a class="area_img">
                <img src="./images/recommend/rcmd06.jpg"> 
            </a>
        </li>

        <li>
            <a class="area_img">
                <img src="./images/recommend/rcmd06.jpg"> 
            </a>
        </li>

        <li>
            <a class="area_img">
                <img src="./images/recommend/rcmd06.jpg"> 
            </a>
        </li>        
    </ul>
    
</div>





<?php 
    
    include 'foot.php';

?>