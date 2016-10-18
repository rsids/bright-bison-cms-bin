<?php
	require_once(dirname(__FILE__) . '/../../../../library/Bright/Bright.php');
?><!DOCTYPE html>
<html>
<head>
	<title>{#linkchooser_dlg.title}</title>

	<script type="text/javascript">
		var flashvars = {gateway:"<?php echo GATEWAY;?>",
						fexpluginUrl:"/<?php echo CMSFOLDER;?>assets/plugins/plugin_explorer.swf?v=4.1.2&lib=1.5.2",
						lchpluginUrl:"/<?php echo CMSFOLDER;?>/assets/plugins/plugin_linkchooser.swf?v=3.1.2&lib=1.5.2"};
	</script>

	<script src="//ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js"></script>
	<script type="text/javascript" src="../../tiny_mce_popup.js"></script>
	<script type="text/javascript" src="js/dialog.js?v=3.1.2&lib=1.5.2"></script>
	<style>
		body, html {
			width:100%;
			height:100%;
			padding: 0;
			margin: 0;
			overflow:hidden;
		}

		#Linkchooser {
			z-index:10000000;
			width: 100%;
			height: 100%;
			padding: 0;
			margin: 0;
		}
		.mceActionPanel {
			padding: 0;
			margin: 0;
			width:100%;
			height:100%;
		}
	</style>
</head>
<body scroll="no">
	<div class="mceActionPanel">
		<div id="Linkchooser">
			<p>To use the Linkchooser, you need Adobe Flash Player<br/>
			<a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>
		</div>
	</div>

</body>
</html>