<?php 
    
    include 'head.php';

?>

<style type="text/css">

.new{
    width: 48%;
    float: left;
    margin-right:3%;
    margin-bottom:3%;
    border:2px solid transparent;
}

.new_r{
    margin-right:0 !important;
}

.area_new{
    top:30%;
    left: 5%;
    width: 90%;
    height: 60%;
    overflow: visible;
}

</style>

<div class="area area_new">

    <a class="area_img new "  href="./recommend.php?game=英雄联盟">
        <img src="./images/area2/n1.jpg"> 
    </a>

    <a class="area_img new new_r " href="./recommend.php?game=王者荣耀">
                <img src="./images/area2/n2.jpg"> 
            </a>

    <a class="area_img new" href="./recommend.php?game=绝地求生">
                <img src="./images/area2/n3.jpg"> 
            </a>
            
    <a class="area_img new new_r" href="./recommend.php?game=其他" >
                <img src="./images/area2/n4.jpg"> 
            </a>                

</div>

<!-- 
<div class="area">
    <ul class="area1">
        <li>
            <a class="area_img" href="./recommend.php?game=英雄联盟">
                <img src="./images/area2/1.jpg"> 
            </a>
        </li>

        <li>
            <a class="area_img" href="./recommend.php?game=王者荣耀">
                <img src="./images/area2/2.jpg"> 
            </a>
        </li>

        <li>
            <a class="area_img" href="./recommend.php?game=绝地求生">
                <img src="./images/area2/3.jpg"> 
            </a>
        </li>

        <li>
            <a class="area_img" href="./recommend.php?game=其他" >
                <img src="./images/area2/4.jpg"> 
            </a>
        </li>
     
    </ul>
    
<ul class="area2">
        <li>
            <a class="area_img" href="./recommend.php?game=英雄联盟">
                <img src="./images/area2/5.jpg"> 
            </a>
        </li>

        <li>
            <a class="area_img" href="./recommend.php?game=王者荣耀">
                <img src="./images/area2/6.jpg"> 
            </a>
        </li>

        <li>
            <a class="area_img" href="./recommend.php?game=其他">
                <img src="./images/area2/7.jpg"> 
            </a>
        </li>

        <li>
            <a class="area_img" href="./recommend.php?game=其他" >
                <img src="./images/area2/8.jpg"> 
            </a>
        </li>
     
    </ul>
    
</div> -->



<script type="text/javascript">

    

/*document.onkeydown=jumpPage;


function jumpPage() { 

    var width_x = parseInt( $('.area1').width() ) / 4;


    console.log( width_x );

    if (event.keyCode==37 || event.keyCode=="KEY_LEFT")//左 
        // $('.area1').scrollLeft(251);
        $('.area1').animate({scrollLeft: '-=' + width_x },500);

    if (event.keyCode==38 || event.keyCode=="KEY_UP")//上 
        $('.area1').scrollLeft(280);
    if (event.keyCode==39 || event.keyCode=="KEY_RIGHT" )//右 
        $('.area1').animate({scrollLeft:'+=' + width_x},500);
    if (event.keyCode==40 || event.keyCode=="KEY_DOWN" )//下 
        $('.area1').scrollLeft(251);

}
*/

function mousePosition(ev)
{ 
    if(ev.pageX || ev.pageY){ 
        return {x:ev.pageX, y:ev.pageY}; 
    } 

    return { 
        x:ev.clientX + document.body.scrollLeft - document.body.clientLeft, 
        y:ev.clientY + document.body.scrollTop - document.body.clientTop 
    }; 
} 


    //图片得到焦点后，检测焦点的位置，符合条件则强制位移
    $(".area_img").focus(function()
    {
        //得到自己的位置
        var offset = $(this).offset().left;

        //得到位移距离
        var width_x = $(this).width() / 0.92;

        //左侧小于0，向左修正
        if( offset < 0 )
        {
            $(this).parent().parent().animate({scrollLeft: '-=' + width_x },500);
        }

        //右侧显示不完全，向右修正
        if( offset + width_x > $(window).width() )
        {
            $(this).parent().parent().animate({scrollLeft: '+=' + width_x },500);
        }

    });


    //返回按键
    window.document.onkeypress = function(event){

        var val = (event.keyCode == undefined || event.keyCode == 0) ? event.which: event.keyCode;
        
        if(val==8)
        {
            window.location.href = './main.php';
        }


/*        $('area_img').blur(function()
        {
            console.log( this );

            this.scrollLeft(251);
        })
*/
    };

</script>



<?php 
    
    include 'foot.php';

?>