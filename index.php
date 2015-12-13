<!doctype html>
<html lang="en-US">
<head>

	<meta charset="utf-8">

	<title>5sing在线下载器 - 一款完全免费的5sing歌曲在线下载工具</title>
	
		<meta content="width=device-width,user-scalable=no" name="viewport">
	<script type="text/javascript" src="/jquery/jquery.js"></script>
	<script type="text/javascript" src="http://tajs.qq.com/stats?sId=49890973" charset="UTF-8"></script>
	<link rel="stylesheet" href="css/main.css">
	

	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	
	
</head>

<body>



<?php
    if ($_GET["add"] != "")
	{
		$text_add = $_GET["add"];
	}else
	{
		$text_add = "请输入5sing歌曲链接，以http://开头";
	}
?>

	<div id="main">

		<h2>5sing在线下载器</h2>

		<form method="get">

			<fieldset>

				<p><label for="add">5sing地址：</label></p>
				<p><input type="text" name="add" value="<?php echo $text_add;?>" onBlur="if(this.value=='')this.value='请输入5sing歌曲链接，以http://开头'" onFocus="if(this.value=='请输入5sing歌曲链接，以http://开头')this.value=''"></p> 
				
				</br>
				
				<?php
					function getSubstr($str, $leftStr, $rightStr)
					{
					//取文本中间过程
					$left = strpos($str, $leftStr);
					//echo '左边:'.$left;
					$right = strpos($str, $rightStr,$left);
					//echo '<br>右边:'.$right;
					if($left < 0 or $right < $left) return '';
					return substr($str, $left + strlen($leftStr), $right-$left-strlen($leftStr));
					}
					
				    if ($text_add != "请输入5sing歌曲链接，以http://开头")
					{
						echo '<div id="load" style="word-break: break-all;"><p>加载中，请稍候...</p></br></div>';
						
						
						//URL processing begin
						if (strpos($text_add,"/m/") != false)
						{//手机版网页
							$url_page = $text_add;
						}else
						{//电脑版网页
							if (strpos($text_add,"/down/") != false)
							{//下载页面
								$temp_code = @file_get_contents($text_add);
								$temp_url_short = getSubstr($temp_code , '<h1><a href="/', '</a></h1>');
								$song_type = mb_substr($temp_url_short,0,2,"UTF-8");
								$song_id = getSubstr($temp_url_short , $song_type.'/', '.html');
								$url_page = "http://5sing.kugou.com/m/detail/".$song_type."-".$song_id."-1.html";
							}else
							{//播放页面
								$temp_code = @file_get_contents($text_add);
								$temp_song_type = getSubstr($temp_code , 'var SongType', 'var SongName');
								$song_type = getSubstr($temp_song_type , '= "', '";');
								$song_id = getSubstr($temp_code, 'modules/static/share.html?id=', '&sk=');
								$url_page = "http://5sing.kugou.com/m/detail/".$song_type."-".$song_id."-1.html";								
							}
						}
						
						//URL processing end
						
						
						
						$code = @file_get_contents($url_page);
						$mp3_url = getSubstr($code , '<audio src="', '" preload="');
						
						if ($mp3_url == "")
						{//获取mp3失败
							echo '  <script type="text/javascript">
								$("#load").html("<p>抱歉，未找到该作品</br>请检查歌曲链接是否正确！</br>如有问题或疑问，请发送邮件至gdsgltc@gmail.com联系解决</br>感谢！</p></br>");
							    </script>';
						}else
						{//成功
					
							$mp3_tiele = getSubstr($code , '<h3 class="m_title">', '</h3>');
							$temp_mp3_singer = getSubstr($code , '<td width="50%"><span>演唱', '<td width="50%"><span>点击');
							$mp3_singer = getSubstr($temp_mp3_singer , '&nbsp;:&nbsp;', '</span></td>');
							echo '  <script type="text/javascript">
								$("#load").html("<p>作品：'.$mp3_tiele.'</br>演唱：'.$mp3_singer.'</br>下载地址：</br><a target=\"_blank\" href=\"'.$mp3_url.'\">'.$mp3_url.'</a></p></br>");
							    </script>';
						}
					}					
				?>
								
				<p><input type="submit" value="下载"></p>

			</fieldset>

		</form>

	</div> <!-- end main -->

<!--页尾begein-->
	<div id="foot">	
		<p>
		<a href="index.php" style="text-decoration:none;">首页</a>丨
		<a href="help.php" style="text-decoration:none;">不会下载？点我！</a>丨
		<a href="about.php" style="text-decoration:none;">关于</a>
		</br>
		<p>Copyright © 2015 5sing在线下载器</p>
		</p>
	</div>


<!--页尾end-->
</body>	
</html>