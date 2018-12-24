
</div> 
<!-- content end -->

<!-- 日志埋点 -->
<script src="./js/comm.js"></script>

<script type="text/javascript">


var nav = '<?php echo $nav; ?>';

console.log('nav=' + nav);

if( !nav || nav == 0 || nav == 1 )
{
    $('#nav1').focus();

    console.log( 321 );
}
else
{
    $('#nav' + nav ).focus();
}


</script>

</body>
</html>