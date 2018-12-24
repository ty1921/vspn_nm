<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8" />
	<title>iptv</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="renderer" content="webkit">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />  
	<meta name="baidu-site-verification" content="8X1bKAjuxm"/>
	<meta name="x5-fullscreen" content="true">
	<link rel="stylesheet" href="./main.css?v=<?php echo time();?>">
</head>
<body>
	<!-- 头部 -->
	<div class="clear header">
		<div class="left">
			<img class="user-header" src="./images/user-header.png" alt="">
			<div class="user-info">
				<p class="user-name">加载中...</p>
				<p class="user-id">ID：<span>加载中...</span></p>
			</div>
		</div>
		<img class="right logo" src="./images/logo.png" alt="">
	</div>
	
	<!-- 菜单分类 -->
	<div class="menu"></div>

		
	<img class="loading" src="./images/loading.gif" alt="">

	<script src='./jquery.min.js'></script>
	<script>

		$('.loading').fadeIn();

		var user_id = window.localStorage.getItem('iptvUid') || '';

		$.ajax({
			url: './res/res.php',
			data:{
				'action':'cover',
				'user_id':user_id
			},
			type: 'get',
			dataType : "json",
			success: function(res)
			{
				if( res.code == 1 )
				{
					window.localStorage.setItem('iptvUid',res.users['user_id']);
					
					$('.user-header').attr('src',res.users['user_icon']);
					$('.user-name').text(res.users['user_name']);
					$('.user-id span').text(res.users['user_id']);
					
					var menu = '<div class="menu-li">\
									<a href="./details.php?game_id='+ res.data[0].game_id +'" class="inlineB menu-li-1 frist-list fc">\
										<img src="'+ res.data[0].game_cover +'" alt="">\
										<p class="menu-li-text num1">'+ res.data[0].name +'</p>\
									</a>\
									<a href="./details.php?game_id='+ res.data[1].game_id +'" class="inlineB menu-li-1 fc">\
										<img src="'+ res.data[1].game_cover +'" alt="">\
										<p class="menu-li-text num1">'+ res.data[1].name +'</p>\
									</a>\
								</div>\
								<div class="menu-li">\
									<div class="menu-li-2-box">\
										<a href="./details.php?game_id='+ res.data[2].game_id +'" class="inlineB menu-li-2 fc">\
											<img src="'+ res.data[2].game_cover +'" alt="">\
											<p class="menu-li-text num1">'+ res.data[2].name +'</p>\
										</a>\
										<a href="./details.php?game_id='+ res.data[3].game_id +'" class="inlineB menu-li-2 fc">\
											<img src="'+ res.data[3].game_cover +'" alt="">\
											<p class="menu-li-text num1">'+ res.data[3].name +'</p>\
										</a>\
									</div>\
									<div class="menu-li-3-box">\
										<a href="./details.php?game_id='+ res.data[4].game_id +'" class="inlineB menu-li-3 fc">\
											<img src="'+ res.data[4].game_cover +'" alt="">\
											<p class="menu-li-text num1">'+ res.data[4].name +'</p>\
										</a>\
										<a href="./details.php?game_id='+ res.data[5].game_id +'" class="inlineB menu-li-3 fc">\
											<img src="'+ res.data[5].game_cover +'" alt="">\
											<p class="menu-li-text num1">'+ res.data[5].name +'</p>\
										</a>\
										<a href="./details.php?game_id='+ res.data[6].game_id +'" class="inlineB menu-li-3 fc">\
											<img src="'+ res.data[6].game_cover +'" alt="">\
											<p class="menu-li-text num1">'+ res.data[6].name +'</p>\
										</a>\
										<a href="./details.php?game_id='+ res.data[7].game_id +'" class="inlineB menu-li-3 fc">\
											<img src="'+ res.data[7].game_cover +'" alt="">\
											<p class="menu-li-text num1">'+ res.data[7].name +'</p>\
										</a>\
									</div>\
								</div>\
								<div class="menu-li" style="margin-right:1%;">\
									<a href="./details.php?game_id='+ res.data[8].game_id +'" class="inlineB menu-li-1 fc">\
										<img src="'+ res.data[8].game_cover +'" alt="">\
										<p class="menu-li-text num1">'+ res.data[8].name +'</p>\
									</a>\
									<a href="./details.php?game_id='+ res.data[9].game_id +'" class="inlineB menu-li-1 fc">\
										<img src="'+ res.data[9].game_cover +'" alt="">\
										<p class="menu-li-text num1">'+ res.data[9].name +'</p>\
									</a>\
								</div>';

						$('.menu').html(menu);
						$('.menu-li-3-box img').height( $('.menu-li-3-box img').width() );

						$('.menu .frist-list').focus();
				}
				// $('.loading').fadeOut();
			}
		})

		$.ajax({
			url: './res/res.php?action=cover_more',
			type: 'get',
			dataType : "json",
			success: function(res)
			{
				if( res.code == 1 )
				{	
					var m = '';
					for ( var i in res.data )
					{
						 m += '<a style="margin-right:.5%;" href="./details.php?game_id='+ res.data[i].game_id +'" class="inlineB menu-list fc">\
								<img width="100%" height="100%" src="'+ res.data[i].game_cover +'" alt="">\
								<p class="menu-li-text num1">'+ res.data[i].name +'</p>\
							</a>'
					}
					$('.menu').append(m);
				}
				$('.loading').fadeOut();
			}
		})


		$('body').on('focus','.fc',function(e){

			var W = $(this).width()/(1-0.05);

			if( $(this).offset().left + W	 > ($('.menu').width()-50) )
			{
				$('.menu').animate({'scrollLeft':'+=' + 	W	},500)
			}

			if( $(this).offset().left < 0 )
			{
				$('.menu').animate({'scrollLeft':'-=' + W},500)
			}			
		})
	</script>
</body>
</html>