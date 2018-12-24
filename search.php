<?php 
    
    include 'head_sub.php';

?>

<style type="text/css">

.clear{
    clear: both;
}

div{
    /*border:1px solid red;*/
    /*text-align: center;*/
}


.search_div{
    position: absolute;
    width: 90%;
    height: 80%;
    top:15%;
    left: 5%;
    text-align: center;
}

.search_sub{
    height: 100%;
    display: inline-block;
    position: relative;
    vertical-align: middle;
    border:1px solid grey;
    box-sizing: border-box; 
}

.s1{
    width: 35%;
}

.s2{
    width: 37%;
}

.s3{
    width: 22.5%;
    margin-left: 2%;
}

.s1_title{
    box-sizing: border-box; 
    margin:0 3% 2% 2%;
    padding: 2%;
    margin-bottom: 2%;
    text-align: left;
    font-size: 1.5rem;
    height: 7%;
    border-bottom: 1px solid rgb(45,60,80);
}

.s1_word{
    width: 90%;
    padding: 0 5%;
}


.words{
    display: inline-block;
    border:1px solid grey;
    width: 13%;
    padding: 3.5% 0;
    margin:1%;
    font-size: 1.3rem;
    color: rgb(170,170,190);
}

.s1_word .do{
    width: 30%;
}

.s1_word .do_space{
    width: 29%;
    border:0;
}

.s1_desc{
    padding: 5% 7%;
    font-size: 0.9rem;
    color: grey;
    text-align: left;
}


/*middle*/
.s2_title{
    margin:0 3% 2% 2%;
    padding: 2%;
    margin-bottom: 2%;
    text-align: left;
    font-size: 1.2rem;
    /*border-bottom: 1px solid rgb(45,60,80);*/
    border:2px solid green;
    box-sizing: border-box; 
}


.s2_title1{
    text-align: left;
    display: inline-block;
    font-size: 1.2rem;
    margin-right: 3%;
}

.s2_title2{
    text-align: left;
    display: inline-block;
    font-size: 1rem;
    color: rgb(170,170,190);
}


/*左侧视频的标题*/
.item{
    margin-top: 5px;
    margin-left: 5%;
    display: block;
    width: 90%;
    height: 10%;
    text-align: left;
    /* margin: 1%; */
    padding: 2.5% 0.6rem;
    font-size: 20px;
    color:  rgb(170,170,190);
    white-space:nowrap;
    overflow:hidden;
    background-color: rgba(120, 130, 150, 0.33);
    box-sizing: border-box; 
}

.item_more{
    height: 15%;
}

.item_process{
    font-size: 0.8rem;
    margin-top: 2%;
    color:  rgb(170,170,190);
}

.s2_roll{
    /*border:1px solid red;*/
    height: 88%;
    overflow: scroll;
}

.item2{
    background-color: rgba(59, 73, 99, 0.34);
}

.item:focus, .item.on{
    background-color: #EBD55E;
    color: #000 !important;
}

/*right*/
.s3_title{
    margin: 0 0 2% 0;
    padding: 3% 0;
    margin-bottom: 2%;
    text-align: left;
    font-size: 1.2rem;
    /*border-bottom: 1px solid rgb(45,60,80);*/
    border:2px solid green;
    box-sizing: border-box; 
}

.r_img_div{
    border: 2px solid transparent;
    position: relative;
    width: 100%;
    margin-top: 7%;
}


/*特效开始*/
.words:focus, .words:hover{
    border:1px solid #EBD55E;
    /*border-color: #EBD55E;*/
    color:#EBD55E;
    font-weight: bold;
}

.item:focus, .item:hover{
    border:2px solid #EBD55E;
    color:#EBD55E;
}

.item:focus .item_process, .item:hover .item_process{
    color:#EBD55E;
}


.r_img_div:focus, .r_img_div:hover{
    border:2px solid #EBD55E;
}

.r_img_div:focus .class_cover, .r_img_div:hover .class_cover{
    background: #EBD55E;
    color:#000000;
}


</style>

<img src="./images/BG.jpg">

<div class="search_div">
    
    <!-- 左侧 -->
    <div class="search_sub s1">

        <div class="s1_title">请输入关键词</div>

        <div class="s1_word">
            <a class="words" onclick="fnSearch('A');" href="#"> A </a>
            <a class="words" onclick="fnSearch('B');" href="#"> B </a>
            <a class="words" onclick="fnSearch('C');" href="#"> C </a>
            <a class="words" onclick="fnSearch('D');" href="#"> D </a>
            <a class="words" onclick="fnSearch('E');" href="#"> E </a>
            <a class="words" onclick="fnSearch('F');" href="#"> F </a>
            <a class="words" onclick="fnSearch('G');" href="#"> G </a>
            <a class="words" onclick="fnSearch('H');" href="#"> H </a>
            <a class="words" onclick="fnSearch('I');" href="#"> I </a>
            <a class="words" onclick="fnSearch('J');" href="#"> J </a>
            <a class="words" onclick="fnSearch('K');" href="#"> K </a>
            <a class="words" onclick="fnSearch('L');" href="#"> L </a>
            <a class="words" onclick="fnSearch('M');" href="#"> M </a>
            <a class="words" onclick="fnSearch('N');" href="#"> N </a>
            <a class="words" onclick="fnSearch('O');" href="#"> O </a>
            <a class="words" onclick="fnSearch('P');" href="#"> P </a>
            <a class="words" onclick="fnSearch('Q');" href="#"> Q </a>
            <a class="words" onclick="fnSearch('R');" href="#"> R </a>
            <a class="words" onclick="fnSearch('S');" href="#"> S </a>
            <a class="words" onclick="fnSearch('T');" href="#"> T </a>
            <a class="words" onclick="fnSearch('U');" href="#"> U </a>
            <a class="words" onclick="fnSearch('V');" href="#"> V </a>
            <a class="words" onclick="fnSearch('W');" href="#"> W </a>
            <a class="words" onclick="fnSearch('X');" href="#"> X </a>
            <a class="words" onclick="fnSearch('Y');" href="#"> Y </a>
            <a class="words" onclick="fnSearch('Z');" href="#"> Z </a>
            <a class="words" onclick="fnSearch('1');" href="#"> 1 </a>
            <a class="words" onclick="fnSearch('2');" href="#"> 2 </a>
            <a class="words" onclick="fnSearch('3');" href="#"> 3 </a>
            <a class="words" onclick="fnSearch('4');" href="#"> 4 </a>
            <a class="words" onclick="fnSearch('5');" href="#"> 5 </a>
            <a class="words" onclick="fnSearch('6');" href="#"> 6 </a>
            <a class="words" onclick="fnSearch('7');" href="#"> 7 </a>
            <a class="words" onclick="fnSearch('8');" href="#"> 8 </a>
            <a class="words" onclick="fnSearch('9');" href="#"> 9 </a>
            <a class="words" onclick="fnSearch('0');" href="#"> 0 </a>

            <a class="words do"  onclick="fnInit();" href="#"> 清空 </a>
            <a class="words do_space">  </a>
            <a class="words do"  onclick="fnDel();" href="#"> 删除 </a>
        </div>

        <div class="s1_desc">
            请输入视频 / 专辑的首字母进行搜索
            <br>
            例如：“英雄联盟”输入“YXLM”
        </div>

    </div>
    


    <!-- 中间部分 -->
    <div class="search_sub s2">
        
        <div class="s1_title">
            <div class="s2_title1">全部</div>
            <div class="s2_title1 s2_title2"> 搜索结果 <span class="cnt"> 10 </span> 个 </div>
            <div class="clear"></div>
        </div>

        <div class="s2_roll">
            <a class="item" href="#"> 2018王者荣耀KPL春季赛1 </a>

            <a class="item item_more item2" href="#"> 
                2018 KPL【英雄麦克风】2
                <div class="item_process"> 更新至56期 </div>
            </a>

            <a class="item" href="#"> 2018王者荣耀KPL春季赛3 </a>

            <a class="item item2" href="#"> 2018王者荣耀KPL春季赛 </a>

            <a class="item" href="#"> 2018王者荣耀KPL春季赛4 </a>

            <a class="item item_more item2" href="#"> 
                2018 KPL【英雄麦克风】6
                <div class="item_process"> 更新至56期 </div>
            </a>

            <a class="item" href="#"> 2018王者荣耀KPL春季赛6 </a>

            <a class="item item2" href="#"> 2018王者荣耀KPL春季赛 </a>

            <a class="item" href="#"> 2018王者荣耀KPL春季赛7 </a>

            <a class="item item_more item2" href="#"> 
                2018 KPL【英雄麦克风】8
                <div class="item_process"> 更新至56期 </div>
            </a>

            <a class="item" href="#"> 2018王者荣耀KPL春季赛9 </a>

            <a class="item item2" href="#"> 2018王者荣耀KPL春季赛 </a>

            <a class="item" href="#"> 2018王者荣耀KPL春季赛10 </a>


        </div>

    </div>
    


    <!-- 右侧 -->
    <div class="search_sub s3" href="#" >

        <div class="s1_title" >
            大家正在看
        </div>


        <a class='r_img_div' href='./play.php'>
            <img src='./images/rec/rechead_03.png' /> 
            <span class='class_cover'>2018 KPL春季赛常规赛</span> 
        </a>


        <a class='r_img_div ' href='./play.php'>
            <img src='./images/rec/rechead_03.png' /> 
            <span class='class_cover'>2018 KPL春季赛常规赛222</span> 
        </a>

        <a class='r_img_div' href='./play.php'>
            <img src='./images/rec/rechead_03.png' /> 
            <span class='class_cover'>2018 KPL春季赛常规赛</span> 
        </a>

    </div>

</div>



<script type="text/javascript">

var s = '';

function fnSearch( key ) 
{
    s = $('.s1_title').html();

    if( s == '请输入关键词' )
    {
        $('.s1_title').html( key );
    }
    else
    {
        $('.s1_title').html( s + key );
    }

    //ajax请求开始
    
    //获得ajax结果
    
    //结果展示
}

function fnInit( ) 
{
    $('.s1_title').html( '请输入关键词' );

    $('.s2_roll').html( '' );

    $('.cnt').html( 0 );
}

function fnDel()
{
    s = $('.s1_title').html();

    $('.s1_title').html( s.substring(0, s.length-1) );

    if( s.length <= 1 )
    {
        $('.s1_title').html( '请输入关键词' );
    }
}



//返回按键
window.document.onkeypress = function(event){

    var val = (event.keyCode == undefined || event.keyCode == 0) ? event.which: event.keyCode;
    
    if(val==8)
    {
        alert('当前处于大厅，无法返回了！');

        window.location.href = './main.php';
    }
};


</script>


<?php 
    
    include 'foot.php';

?>