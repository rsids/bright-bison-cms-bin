<?php
	require_once(dirname(__FILE__) . '/../../../../library/Bright/Bright.php');
?><!DOCTYPE html>
<html>
<head>
	<title>{#fileexplorer_dlg.title}</title>
	<script type="text/javascript">
		var urlwrap, tagwrap;
	<?php
		if(defined('RTE_IMGURLWRAP') && RTE_IMGURLWRAP != '') {
			echo 'urlwrap="' . addslashes(RTE_IMGURLWRAP) . '";' . "\r\n";
		}
		if(defined('RTE_IMGTAGWRAP') && RTE_IMGTAGWRAP != '') {
			echo 'tagwrap="' . addslashes(RTE_IMGTAGWRAP) . '";' . "\r\n";
		}

	?>
		var flashvars = {gateway:"<?php echo GATEWAY;?>",
						fexpluginUrl:"/<?php echo CMSFOLDER;?>assets/plugins/plugin_explorer.swf?v=4.1.2&lib=1.5.2",
						lchpluginUrl:"/<?php echo CMSFOLDER;?>/assets/plugins/plugin_linkchooser.swf?v=3.1.2&lib=1.5.2"};
	</script>
	<script src="//ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js"></script>
	<script type="text/javascript" src="../../tiny_mce_popup.js"></script>
	<script type="text/javascript" src="js/dialog.js?v=4.1.2&lib=1.5.3"></script>
	<style>
		#FileExplorer3 {
			z-index:1000;
		}
		body, html,
		#FileExplorer3,
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
		<div id="FileExplorer3">
		</div>
	</div>

</body>
</html>