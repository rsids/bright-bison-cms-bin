<?php 
	require_once(dirname(__FILE__) . '/../../../../library/Bright/Bright.php');
	require_once('Bright/template/Template.php');
	
	$template = new Template();
	$tpl = $template -> getUserTemplate();
	
?><!DOCTYPE html>
<html>
<head>
	<title>{#macro_dlg.title}</title>
	
	
	<script type="text/javascript" src="../../tiny_mce_popup.js"></script>
	<script type="text/javascript" src="js/dialog.js?v=0.1"></script>
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
		<h1>Choose a macro</h1>
		<ul>
			<li><a href="javascript:callbackfn('[email]')">E-mail address</a></li>
			<?php 
				if($tpl) {
					foreach($tpl -> fields as $field) {
						echo '<li><a href="javascript:callbackfn(\'[' . $field -> label . ']\')">' . $field -> displaylabel . '</a></li>'. "\r\n";
					}
				}
			?>
		</ul>
	</div>

</body>
</html>