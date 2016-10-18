<?php
	include_once(dirname(__FILE__) . '/../../library/Bright/Bright.php');
?><!DOCTYPE html>
<html>
	<head>
		<!--
			Product van: Fur
			Bloemsingel 222
			9712 KZ Groningen
			www.wewantfur.com
			-->
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="AUTHOR" content="Fur" />
		<meta name="googlebot" content="noindex,noarchive,nofollow" />
		<meta name="robots" content="noindex,noarchive,nofollow" />
		
		<title>Bright CMS</title>
        <script type="text/javascript" src="/<?php echo CMSFOLDER;?>js/bright.js?ver=3.2"></script>
		<script type="text/javascript">
			var additionalplugins = [];
			var devplugins = [];
		<?php 
			$dir = BASEPATH . 'bright/site/plugins/tinymce/';
			if(is_dir($dir)) {
				$files = scandir($dir);
				foreach($files as $file) {
					if(strpos($file, '.') !== 0 && $file != '..' && $file != 'bright.js' && is_dir($dir . '/' . $file)) {
						echo "additionalplugins.push('$file');\r\n";	
					}
				}
			}
			if(!LIVESERVER) {
				echo "devplugins.push('lipsum');\r\n";
			}
		?>
		</script>
        <?php
            if(file_exists(BASEPATH . 'bright/site/plugins/bright.js')) {
        ?>
            <script type="text/javascript" src="/bright/site/plugins/bright.js"></script>
        <?php
            }
        ?>

		<!--[if lt IE 9]>
		<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script type="text/javascript" src="/<?php echo CMSFOLDER;?>tinymce/tiny_mce.js?v=3.5.0"></script>
		<script type="text/javascript" src="/<?php echo CMSFOLDER;?>js/popup.js?ver=2.20"></script>
	
		
		<style type="text/css">
			html, body, textarea, table.mceLayout, form, iframe {
				width: 100% !important; 
				height:100% !important;
			
			}
			html, body { 
				margin: 			0px; 
				padding:			0;
				overflow:			hidden;

				backround-color:	#50799b;
			}
			textarea {
				display: block;
			}
		</style>
	</head>
	<body>
		<form method="get" onsubmit="return submitForm()">
			<textarea id="rte" name="rte"></textarea>
		</form>
		<div id="temprepdiv"></div>
	</body>
</html>