<?php
	/**
	 * Uploadscript v3.3
	 * © 2013 Fur
	 * Bloemsingel 222
	 * Groningen
	 * www.wewantfur.com
	 * info@wewantfur.com
	 */
	ini_set('display_errors', '0'); // display errors in the HTML
	ini_set('track_errors', '0'); // creates php error variable
	ini_set('log_errors', '1'); // writes to the log file
	error_reporting(E_ALL|E_STRICT);

	// Check if neccessary postvars are set and valid
	if(!isset($_POST['action']) || $_POST['action'] != 'upload')
		throw new Exception('Invalid data 1');

	if(!isset($_POST['remotedir']))
		throw new Exception('Invalid data 2');

	if(!isset($_POST['remotename']))
		throw new Exception('Invalid data 3');

	// Remotedir may not contain dots (.);
	$remotedir = $_POST['remotedir'];
	if(strpos($remotedir, '.') != false)
		throw new Exception('Invalid data 4');

	// Remove first slash (it is added to prevent an empty string being send. An empty string results in the var not being send at all)
	if(strpos($remotedir, '/') === 0)
		$remotedir = substr($remotedir, 1);

	// Remotedir may not contain slashes (/, \);
	$remotename = strtolower($_POST['remotename']);
	if(strpos($remotename, '\\') != false)
		throw new Exception('Invalid data 5');

	if(strpos($remotename, '/') != false)
		throw new Exception('Invalid data 6');

	include_once(dirname(__FILE__) . '/../library/Bright/Bright.php');
	$path = BASEPATH . UPLOADFOLDER . $remotedir;

	$status = new StdClass();
	$status -> result = 'ERROR';

	if (!file_exists($path . $remotename)) {
		if(isset($_FILES) && isset($_FILES['file'])) {
			$file_temp 	= $_FILES['file']['tmp_name'];
			$filestatus = move_uploaded_file($file_temp, $path . $remotename);
		} else {
			
			$handle = @fopen($path . $remotename, 'w');
			if($handle) {
				$filestatus = fwrite($handle, base64_decode($_POST['filedata']));
				fclose($handle);
			} else {
				$filestatus = false;
				$status -> message = 'Cannot write file';
			}
		}

		if(!$filestatus) {
			//Error during upload
			$status -> result = 'ERROR';
			$status -> thefile = $remotename;
			$status -> thedir = $path;
			$status -> message = 'Error during upload';

		} else {
			$status -> result = 'OK';
			$status -> message = 'File uploaded';

			$path_parts 	= pathinfo($path . $remotename);
			$path_ext		= strtolower($path_parts['extension']);


		}
	} else {
		$status -> result = 'ERROR';
		$status -> message = 'File already exists';
		$status -> thefile = $remotename;
	}

    if($status -> result === 'OK' && class_exists('FileHook')) {
        $ph = new FileHook();
        if(method_exists($ph, 'uploadFile')) {
            $ph->uploadFile($remotename, $path);
        }
    }

	// Return status to flash
	echo json_encode($status);
