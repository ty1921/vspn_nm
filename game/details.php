<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8" />
	<title>details</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="renderer" content="webkit">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<meta name="baidu-site-verification" content="8X1bKAjuxm"/>
	<meta name="x5-fullscreen" content="true">
	<link rel="stylesheet" href="./main.css?v=<?php echo time();?>">
</head>
<body>
	
	<div class="main">
		
		<!-- 左 -->
		<div class="m-left inlineB">
			<a href="javascript:;" class="m-left-box">
				<p class="rank-icon">排行榜>></p>
				<ul id='rank-list'></ul>
				<div class="_my"></div>
			</a>
		</div>
		
		<!-- 中 -->
		<div class="center inlineB">
			
			<div class="c-header">
				<img class="img-user-header" src="./images/user-header.png" alt="">
				<div class="user-info inlineB">
					<p class="user-name">加载中...</p>
					<p class="user-rank">我的成绩：<span>加载中...</span></p>
					<p class="supplier">供应商：<span>加载中...</span></p>
					<p class="peoples">游戏人数：<span>加载中...</span></p>
				</div>
			</div>

			<div class="c-nav clear">
				<p class="left">游戏模式</p>
				<div class="nav-img-box right clear"></div>
			</div>
			
			<div class="c-text-box">
				<p class="c-title">游戏简介：</p>
				<p class="c-text num3">加载中...</p>
			</div>
			
			<div class="c-footer clear">
				<p class="left">游戏推荐</p>
				<div class="c-menu right"></div>
			</div>

		</div>
		
		<!-- 右 -->
		<div class="m-right inlineB">
			<p class="img-screenshot">游戏截图</p>
			<div class="imgs"></div>
		</div>

	</div>

	<!-- 左侧排行榜 -->
	<a href="javascript:;" class="ranks none">
		<div class="rank-box">
			<ul class="rank"></ul>
			<div class="rank clear">
				<span class="rank-num">0</span>
				<img class="rank-header" src="./images/user-header.png" alt="">
				<p class="rank-user num1">加载中...</p>
				<p class="rank-score num1">加载中...</p>
			</div>
		</div>
	</a>
	
	<!-- 截图全屏 -->
	<a href="javascript:;" class="bigs none">
		<img id='bigImg' src="" alt="">
	</a>
	
	<img class="loading" src="./images/loading.gif" alt="">
	
	<script src='./jquery.min.js'></script>
	<script>

		var user_id = window.localStorage.getItem('iptvUid') || '';

		// 点击排行榜
		$('.m-left-box').click(function(){
			if( $(this).hasClass('open') )
			{
				$('.ranks').removeClass('none').focus();
				$('.rank-box').addClass('active');
			}
			else
			{
				alert('暂无排行数据');
			}
		})

		// 关闭排行榜
		$('.ranks').click(function(){
			$('.ranks').addClass('none');
			$('.rank-box').removeClass('active');

			$('.m-left-box').focus();
		})

		var imgWH = $('.img-game-li').width() / $('.img-game-li').height();
		var bodyWH = document.body.clientWidth / document.body.clientHeight;
		
		// 点击看大图
		$('.m-right').on('click','.img-game-li',function(){
			imgWH > bodyWH 
			? 
			$('.bigs').addClass('w active').attr('data-cl',$(this).attr('data-cl')).removeClass('none').focus() 
			: 
			$('.bigs').addClass('h active').attr('data-cl',$(this).attr('data-cl')).removeClass('none').focus()

			$('#bigImg').attr('src',$(this).attr('data-src'))
		})

		// 关闭大图
		$('.bigs').click(function(){
			imgWH > bodyWH 
			? 
			$('.bigs').addClass('w none').removeClass('active')
			: 
			$('.bigs').addClass('h none').removeClass('active')

			$('.'+$(this).attr('data-cl')).focus();
		})
		
		var game_id = "<?php
						echo $game_id = isset($_REQUEST['game_id']) ? $_REQUEST['game_id'] : '';
					?>";

		details( game_id );
		function details(game_id)
		{
			$('.loading').fadeIn();
			$.ajax({
				url: './res/res.php?action=details',
				type: 'get',
				data: {
					'user_id': user_id,
					'game_id': game_id
				},
				dataType : "json",
				success: function(res)
				{	
					if( res.code == 1 )
					{
						$('.img-user-header').attr('src',res.data.details.icon)
						$('.user-name').text(res.data.details.name);
						$('.supplier span').text(res.data.details.form);
						$('.c-text').text(res.data.details.desc);

						$('div.rank .rank-header').attr('src',res.data.users.user_icon);
						$('div.rank .rank-user').text(res.data.users.user_name);

						var mRight = '';
						for (var i in res.data.details.imgs) 
						{
							mRight += '<a class="img-game-li img'+ i +'" data-cl="img'+ i +'" data-src="'+res.data.details.imgs[i]+'" href="javascript:;">\
											<img width="100%" height="100%" src="'+res.data.details.imgs[i]+'" alt="">\
										</a>';
						}
						$('.imgs').html(mRight);
						$('.imgs .img-game-li').height( $('.imgs .img-game-li').width()*.565 );

						var cMenu = '';
						for (var i in res.data.recommend) 
						{
							cMenu += '<a href="javascript:;" data-id="'+res.data.recommend[i].game_id+'" class="inlineB menu-li-3">\
										<img src="'+res.data.recommend[i].game_icon+'" alt="">\
										<p class="menu-li-text num1">'+res.data.recommend[i].name+'</p>\
									</a>;'
						}
						$('.c-menu').html(cMenu);
						$('.c-menu img').height( $('.c-menu img').width() );

						var navImg = '';
						for (var i in res.data.details.mode) 
						{
							navImg += '<a class="nav-img" data-mode="'+ res.data.details.mode[i].mode_status +'" href="'+res.data.details.mode[i].link+'">'+res.data.details.mode[i].mode+'</a>';
						}
						$('.nav-img-box').html(navImg).find('.nav-img').eq(0).focus();
					}
					else
					{
						alert('操作错误！');
					}
					$('.loading').fadeOut();
				},
				error:function()
				{
					console.log('res');
				}
			})
		}

		$('.nav-img-box').on('focus','.nav-img',function(){
			rank(game_id, $(this).attr('data-mode'))
		})
		

		function rank(game_id,mode)
		{
			$.ajax({
				url: './res/res.php?action=rank',
				type: 'get',
				data: {
					'user_id': user_id,
					'game_id': game_id,
					'mode': mode
				},
				dataType : "json",
				success: function(res)
				{	
					$('._my').addClass('none');
					if( res.code == 1 )
					{
						$('.user-rank span,div.rank .rank-num').text(0);
						$('div.rank .rank-score').text(0);

						var rank_4 = '',rank_6 = '',mH = '';
						if( res.data.rank.length > 0 )
						{
							$('.m-left-box').addClass('open');
							for (var i in res.data.rank) 
							{
								if( res.data.rank[i].is_me == '1' )
								{
									$('div.rank .rank-num').text( parseFloat(i)+1 );
									$('div.rank .rank-score,.user-rank span').text(res.data.rank[i].score);

									$('._my').removeClass('none');
									mH = '<span class="img-num">'+(parseFloat(i)+1)+'</span>\
												<img class="img-header" src="'+ res.data.rank[i].user_icon +'" alt="">\
											  <span class="my_mc" style="">我的名次</span>';
								}

								if( i < 3 )
								{
									rank_4 += '<li>\
													<span class="img-num">'+( parseFloat(i)+1 )+'</span>\
													<img class="img-header" src="'+ res.data.rank[i].user_icon +'" alt="">\
												</li>';
								}

								rank_6 += '<li class="clear">\
												<span class="rank-num">'+( parseFloat(i)+1 )+'</span>\
												<img class="rank-header" src="'+ res.data.rank[i].user_icon +'" alt="">\
												<p class="rank-user num1">'+ res.data.rank[i].user_name +'</p>\
												<p class="rank-score num1">'+ res.data.rank[i].score +'</p>\
											</li>';
							}
						}
						else
						{
							$('.m-left-box').removeClass('open');
						}
						$('.peoples span').text(res.data.rank.length);
						$('#rank-list').html(rank_4);
						$('ul.rank').html(rank_6);
						$('._my').html(mH);	
					}
				},
				error:function(){}
			})
		}

		
		$('body').on('click','.c-menu .menu-li-3',function(){
			game_id = $(this).attr('data-id');
			details( game_id );
		})

	</script>

</body>
</html>