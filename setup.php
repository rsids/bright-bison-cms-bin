<?php 
	if(file_exists(dirname(__FILE__) . '/../site/config/Constants.php')) {
		exit;
	}
	$baseview = 'PD9waHANCnJlcXVpcmVfb25jZSgnRnJvbnRlbmQvQnJpZ2h0LnBocCcpOw0KcmVxdWlyZV9vbmNlKCdGcm9udGVuZC9HZW5lcmFsVmlldy5waHAnKTsNCi8qKg0KICogRWFjaCB2aWV3IG11c3QgZXh0ZW5kcyB0aGlzIG9yIEdlbmVyYWxWaWV3PGJyLz4NCiAqIGFkZCBjdXN0b20gbG9naWMgdG8gdGhpcyBjbGFzcywgbm90IHRvIEdlbmVyYWxWaWV3PGJyLz4NCiAqIEBhdXRob3IgRnVyDQogKiBAdmVyc2lvbiAxLjANCiAqIEBwYWNrYWdlIHNpdGUudmlld3MNCiAqLw0KY2xhc3MgQmFzZVZpZXcgZXh0ZW5kcyBHZW5lcmFsVmlldyB7DQoJDQoJLyoqDQoJICogSG9sZHMgdGhlIG1haW4gbmF2aWdhdGlvbg0KCSAqIEB2YXIgc3RyaW5nDQoJICovDQoJcHJvdGVjdGVkICRuYXZpZ2F0aW9uOw0KCQ0KCWZ1bmN0aW9uIEJhc2VWaWV3KCRwYWdlRGF0YSkgew0KCQlwYXJlbnQ6Ol9fY29uc3RydWN0KCRwYWdlRGF0YSk7DQoJCSRicmlnaHQgPSBuZXcgQnJpZ2h0KCk7DQoJCSR0aGlzIC0+IG5hdmlnYXRpb24gPSAkYnJpZ2h0IC0+IGdldE5hdmlnYXRpb24oMSwgMCwgJHRoaXMgLT4gcGFnZURhdGEsIHRydWUpOw0KCX0NCn0=';

	$default = new StdClass();
	$default -> uploadfolder = 'files/';
	$default -> smtp = 'localhost';
	$default -> smtpport = '25';

	$errarr = array();
	$infoarr = array();
	$okarr = array();
	$config = new StdClass();
	$config -> dbname = '';
	$config -> dbuser = '';
	$config -> dbpass = '';
	$config -> dbserver = 'localhost';
	
	$config -> sitename = '';
	$config -> availablelang = '';
	$config -> uploadfolder = 'files/';
	$config -> useprefix = '';
	$config -> logo = '';
	
	$config -> baseurl = '';
	$config -> mailingfrom = '';
	$config -> mailingbounce = '';
	$config -> sysmail = '';
	$config -> smtp = 'localhost';
	$config -> smtpport = '25';
	$config -> transport = '';
	$config -> googlemapsapikey = '';
	$config -> additionalmodules = '';
	$config -> loginpage = '';
	$config -> activationpage = '';
	$config -> activationpage = '';
	$config -> deactivationpage = '';
	$config -> runimport = '';
	
	
	$basepath = dirname(__FILE__);
	$basepatha = explode(DIRECTORY_SEPARATOR, $basepath);
	array_pop($basepatha);
	array_pop($basepatha);
	$config -> basepath = str_replace('//', '/', implode('/', $basepatha) . '/');
	
	$writeconfig = true;
	
	if(isset($_SERVER['HTTP_HOST'])) {
		$config -> baseurl = 'http://' . $_SERVER['HTTP_HOST'] . '/';
	}
	
	if(isset($_POST['submit_btn'])) {
		// I am not going to sanitize the input, since this is a CONFIGURATION SCRIPT,
		// it should NOT be callable / exist on your prodcution server
		
		foreach($_POST as $key => $value) {
			$config -> {$key} = $value;
		}
		if(!isset($_POST['dbuser']) || $_POST['dbuser'] == '')			$errarr[] = 'Database user cannot be empty';
		if(!isset($_POST['dbpass']) || $_POST['dbpass'] == '')			$infoarr[] = 'No database password specified';
		if(!isset($_POST['dbserver']) || $_POST['dbserver'] == '')		$errarr[] = 'Database server cannot be empty';
		if(!isset($_POST['dbname']) || $_POST['dbname'] == '')			$errarr[] = 'Please specify the database name';
		
		if(!isset($_POST['sitename']) || $_POST['sitename'] == '')		$infoarr[] = 'No sitename was specified';
		if(!isset($_POST['availablelang']) || $_POST['availablelang'] == '')	$errarr[] = 'Enter at least one language';

		if(!isset($_POST['baseurl']) || $_POST['baseurl'] == '')		$errarr[] = 'Please enter the base url';
		
		if(preg_match('/[^A-z,]/', $config -> availablelang)) 			$errarr[] = 'Available languages contains illegal characters';
		
		if(count($errarr) == 0) {
			$dbaccess = true;
			$conn = new mysqli($config -> dbserver, $config -> dbuser, $config -> dbpass, $config -> dbname);
			
			if(mysqli_connect_error()) {
				$dbaccess = false;
				$errarr[] = 'Could not connect to the database';
			} else {
				$okarr[] = 'Database connection: OK';
				
				if(isset($_POST['runimport'])) {
					$sqlfile = base64_decode('RFJPUCBUQUJMRSBJRiBFWElTVFMgYGFkbWluaXN0cmF0b3JwZXJtaXNzaW9uc2A7DQpDUkVBVEUgVEFCTEUgSUYgTk9UIEVYSVNUUyBgYWRtaW5pc3RyYXRvcnBlcm1pc3Npb25zYCAoIGBpZGAgaW50KDExKSBOT1QgTlVMTCBBVVRPX0lOQ1JFTUVOVCwgYGFkbWluaXN0cmF0b3JJZGAgaW50KDExKSBOT1QgTlVMTCwgYHBlcm1pc3Npb25gIHZhcmNoYXIoMzApIE5PVCBOVUxMLCBQUklNQVJZIEtFWSAoYGlkYCkgKSBFTkdJTkU9TXlJU0FNICBERUZBVUxUIENIQVJTRVQ9dXRmODsNCklOU0VSVCBJTlRPIGBhZG1pbmlzdHJhdG9ycGVybWlzc2lvbnNgIChgYWRtaW5pc3RyYXRvcklkYCwgYHBlcm1pc3Npb25gKSBWQUxVRVMgKDEsICdNQU5BR0VfRUxFTUVOVFMnKSwgKDEsICdNQU5BR0VfQ0FMRU5EQVJTJyksICgxLCAnTUFOQUdFX1RFTVBMQVRFJyksICgxLCAnTUFOQUdFX1NFVFRJTkdTJyksICgxLCAnTUFOQUdFX1VTRVInKSwgKDEsICdERUxFVEVfRklMRScpLCAoMSwgJ1VQTE9BRF9GSUxFJyksICgxLCAnTU9WRV9QQUdFJyksICgxLCAnRURJVF9QQUdFJyksICgxLCAnREVMRVRFX1BBR0UnKSwgKDEsICdDUkVBVEVfUEFHRScpLCAoMSwgJ01BTkFHRV9BRE1JTicpLCAoMSwgJ0lTX0FVVEgnKSwgKDEsICdNQU5BR0VfTUFJTElOR1MnKSwgKDEsICdNQU5BR0VfTUFQUycpOw0KRFJPUCBUQUJMRSBJRiBFWElTVFMgYGFkbWluaXN0cmF0b3JzYDsNCkNSRUFURSBUQUJMRSBJRiBOT1QgRVhJU1RTIGBhZG1pbmlzdHJhdG9yc2AgKCBgaWRgIGludCgxMSkgTk9UIE5VTEwgQVVUT19JTkNSRU1FTlQsIGBuYW1lYCB2YXJjaGFyKDI1NSkgTk9UIE5VTEwsIGBlbWFpbGAgdmFyY2hhcigyNTUpIE5PVCBOVUxMLCBgcGFzc3dvcmRgIHZhcmNoYXIoMjU1KSBOT1QgTlVMTCwgYHZpc2libGVDb2x1bW5zYCB2YXJjaGFyKDI1NSkgTk9UIE5VTEwsIGBkZWZhdWx0U29ydGAgaW50KDExKSBOT1QgTlVMTCwgUFJJTUFSWSBLRVkgKGBpZGApICkgRU5HSU5FPU15SVNBTSAgREVGQVVMVCBDSEFSU0VUPXV0Zjg7DQpJTlNFUlQgSU5UTyBgYWRtaW5pc3RyYXRvcnNgIChgaWRgLCBgbmFtZWAsIGBlbWFpbGAsIGBwYXNzd29yZGAsIGB2aXNpYmxlQ29sdW1uc2AsIGBkZWZhdWx0U29ydGApIFZBTFVFUyAoMSwgJ0FkbWluaXN0cmF0b3InLCAnYWRtaW5pc3RyYXRvckBicmlnaHRjbXMuY29tJywgJzBkOTc4Nzc5MWUyZjA2YTE4YzFjNzE0ZGIyYjc4Mjc2ODBmNThkOGMnLCAnMCwxLDIsMyw0LDUsNiw3LDgsOScsIDApOw0KRFJPUCBUQUJMRSBJRiBFWElTVFMgYGFkbWlubGFiZWxzYDsNCkNSRUFURSBUQUJMRSBJRiBOT1QgRVhJU1RTIGBhZG1pbmxhYmVsc2AgKCBgcGFnZUlkYCBpbnQoMTEpIE5PVCBOVUxMLCBgYWRtaW5JZGAgaW50KDExKSBOT1QgTlVMTCwgYGNvbG9yYCB2YXJjaGFyKDEwKSBOT1QgTlVMTCApIEVOR0lORT1NeUlTQU0gREVGQVVMVCBDSEFSU0VUPXV0Zjg7DQpEUk9QIFRBQkxFIElGIEVYSVNUUyBgYmFja3VwYDsNCkNSRUFURSBUQUJMRSBJRiBOT1QgRVhJU1RTIGBiYWNrdXBgICggYGlkYCBpbnQoMTEpIE5PVCBOVUxMIEFVVE9fSU5DUkVNRU5ULCBgcGlkYCBpbnQoMTEpIE5PVCBOVUxMLCBgY29udGVudGAgdGV4dCBOT1QgTlVMTCwgYGRhdGVgIGRhdGV0aW1lIE5PVCBOVUxMLCBQUklNQVJZIEtFWSAoYGlkYCkgKSBFTkdJTkU9TXlJU0FNICBERUZBVUxUIENIQVJTRVQ9dXRmODsNCkRST1AgVEFCTEUgSUYgRVhJU1RTIGBjYWxlbmRhcmA7DQpDUkVBVEUgVEFCTEUgSUYgTk9UIEVYSVNUUyBgY2FsZW5kYXJgICggYHBhZ2VJZGAgaW50KDExKSBOT1QgTlVMTCwgYHJlY3VyYCB2YXJjaGFyKDI1NSkgTk9UIE5VTEwsIGB1bnRpbGAgaW50KDExKSBOT1QgTlVMTCwgYGFsbGRheWAgdGlueWludCgxKSBOT1QgTlVMTCBERUZBVUxUICcwJywgUFJJTUFSWSBLRVkgKGBwYWdlSWRgKSApIEVOR0lORT1NeUlTQU0gREVGQVVMVCBDSEFSU0VUPWxhdGluMTsNCkRST1AgVEFCTEUgSUYgRVhJU1RTIGBjYWxlbmRhcmV2ZW50c2A7DQpDUkVBVEUgVEFCTEUgSUYgTk9UIEVYSVNUUyBgY2FsZW5kYXJldmVudHNgICggYHBhZ2VJZGAgaW50KDExKSBOT1QgTlVMTCwgYHN0YXJ0dGltZWAgaW50KDExKSBOT1QgTlVMTCwgYGVuZHRpbWVgIGludCgxMSkgTk9UIE5VTEwsIEtFWSBgcGFnZUlkYCAoYHBhZ2VJZGApICkgRU5HSU5FPU15SVNBTSBERUZBVUxUIENIQVJTRVQ9bGF0aW4xOw0KRFJPUCBUQUJMRSBJRiBFWElTVFMgYGNvbnRlbnRgOw0KQ1JFQVRFIFRBQkxFIElGIE5PVCBFWElTVFMgYGNvbnRlbnRgICggYGNvbnRlbnRJZGAgaW50KDExKSBOT1QgTlVMTCBBVVRPX0lOQ1JFTUVOVCwgYHBhZ2VJZGAgaW50KDExKSBOT1QgTlVMTCwgYGxhbmdgIHZhcmNoYXIoMykgTk9UIE5VTEwgREVGQVVMVCAnQUxMJywgYGZpZWxkYCB2YXJjaGFyKDIwKSBOT1QgTlVMTCwgYHZhbHVlYCBsb25ndGV4dCBOT1QgTlVMTCwgYGluZGV4YCBpbnQoMTEpIE5PVCBOVUxMIERFRkFVTFQgJzAnLCBgc2VhcmNoYWJsZWAgdGlueWludCg0KSBOT1QgTlVMTCBERUZBVUxUICcxJywgUFJJTUFSWSBLRVkgKGBjb250ZW50SWRgKSwgS0VZIGBsYW5nYCAoYGxhbmdgLGBmaWVsZGApLCBLRVkgYHBhZ2VJZGAgKGBwYWdlSWRgKSwgRlVMTFRFWFQgS0VZIGB2YWx1ZWAgKGB2YWx1ZWApICkgRU5HSU5FPU15SVNBTSAgREVGQVVMVCBDSEFSU0VUPXV0Zjg7DQpEUk9QIFRBQkxFIElGIEVYSVNUUyBgZmllbGR0eXBlc2A7DQpDUkVBVEUgVEFCTEUgSUYgTk9UIEVYSVNUUyBgZmllbGR0eXBlc2AgKCBgaWRgIGludCgxMSkgTk9UIE5VTEwgQVVUT19JTkNSRU1FTlQsIGB0eXBlYCB2YXJjaGFyKDI1NSkgTk9UIE5VTEwsIGBhdmFpbGFibGVwcm9wZXJ0aWVzYCB0ZXh0IE5PVCBOVUxMLCBgY29udGVudHR5cGVgIHZhcmNoYXIoMjU1KSBOT1QgTlVMTCBERUZBVUxUICdzdHJpbmcnLCBQUklNQVJZIEtFWSAoYGlkYCkgKSBFTkdJTkU9TXlJU0FNICBERUZBVUxUIENIQVJTRVQ9dXRmODsNCklOU0VSVCBJTlRPIGBmaWVsZHR5cGVzYCAoYHR5cGVgLCBgYXZhaWxhYmxlcHJvcGVydGllc2AsIGBjb250ZW50dHlwZWApIFZBTFVFUyAoICdzdHJpbmcnLCAnW1sicmVzdHJpY3QiLCJzdHJpbmciXSxbIm1heENoYXJzIiwibnVtYmVyIl0sWyJyZXF1aXJlZCIsImJvb2xlYW4iXV0nLCAnc3RyaW5nJyksICggJ3RleHQnLCAnW1sicmVzdHJpY3QiLCJzdHJpbmciXSxbIm1heENoYXJzIiwibnVtYmVyIl0sWyJyZXF1aXJlZCIsImJvb2xlYW4iXV0nLCAnc3RyaW5nJyksICggJ2h0bWwnLCAnW1sicmVzdHJpY3QiLCJzdHJpbmciXSxbIm1heENoYXJzIiwibnVtYmVyIl0sWyJyZXF1aXJlZCIsImJvb2xlYW4iXV0nLCAnc3RyaW5nJyksICggJ251bWJlcicsICdbWyJtaW5pbXVtIiwibnVtYmVyIl0sWyJtYXhpbXVtIiwibnVtYmVyIl0sWyJzdGVwU2l6ZSIsIm51bWJlciJdXScsICdzdHJpbmcnKSwgKCAnYm9vbGVhbicsICdbWyJyZXF1aXJlZCIsImJvb2xlYW4iXV0nLCAnc3RyaW5nJyksICggJ2xpc3QnLCAnW1sibWluaW11bSIsIm51bWJlciJdLFsibWF4aW11bSIsIm51bWJlciJdLFsiZGlyZWN0aW9uIiwic3RyaW5nIl0sWyJkaXNwbGF5QXNUYWJzIiwiYm9vbGVhbiJdLFsiZGVmaW5pdGlvbmlkcyIsImFycmF5Il1dJywgJ2FycmF5JyksICggJ2RhdGUnLCAnJywgJ3N0cmluZycpLCAoICdmaWxlJywgJ1tbImZpbHRlciIsImFycmF5Il0sWyJyZXF1aXJlZCIsImJvb2xlYW4iXSxbImRpc3BsYXlBc1RodW1iIiwiYm9vbGVhbiJdXScsICdzdHJpbmcnKSwgKCAnbGluaycsICdbWyJyZXF1aXJlZCIsImJvb2xlYW4iXSxbImludGVybmFsT25seSIsICJib29sZWFuIl1dJywgJ3N0cmluZycpLCAoICdmb2xkZXInLCAnW1sicmVxdWlyZWQiLCJib29sZWFuIl1dJywgJ3N0cmluZycpLCAoICdlbnVtJywgJ1tbInJlcXVpcmVkIiwiYm9vbGVhbiJdLFsidmFsdWVzIiwiYXJyYXkiXV0nLCAnc3RyaW5nJyksICggJ2FkdmFuY2VkX2ZpbGUnLCAnW1siZmlsdGVyIiwiYXJyYXkiXSxbInJlcXVpcmVkIiwiYm9vbGVhbiJdLFsiZGlzcGxheUFzVGh1bWIiLCJib29sZWFuIl1dJywgJ2pzb24nKSwgKCAnYWR2YW5jZWRfdGV4dCcsICcnLCAnanNvbicpLCAoICd0YWJsaXN0JywgJ1tbIm1pbmltdW0iLCJudW1iZXIiXSxbIm1heGltdW0iLCJudW1iZXIiXSxbImRlZmluaXRpb25pZHMiLCJhcnJheSJdXScsICdhcnJheScpLCAoICdhZHZhbmNlZF9saW5rJywgJ1tbInJlcXVpcmVkIiwiYm9vbGVhbiJdLFsiaW50ZXJuYWxPbmx5IiwgImJvb2xlYW4iXV0nLCAnc3RyaW5nJyksICggJ2FkdmFuY2VkX2xpc3QnLCAnW1sibWluaW11bSIsIm51bWJlciJdLFsibWF4aW11bSIsIm51bWJlciJdLFsiZGVmaW5pdGlvbmlkcyIsImFycmF5Il1dJywgJ2FycmF5JyksICggJ2VsZW1lbnQnLCAnW1sicmVxdWlyZWQiLCAiYm9vbGVhbiJdLCBbImZpbHRlciIsICJhcnJheSJdLCBbIm11bHRpcGxlIiwgImJvb2xlYW4iXV0nLCAnZWxlbWVudHMnKSwgKCAnZ21hcHMnLCAnW1siYWxsb3dtYXJrZXJzIiwgICJib29sZWFuIl0sIFsiYWxsb3dsaW5lcyIsICAiYm9vbGVhbiJdLCBbImFsbG93c2hhcGVzIiwgICJib29sZWFuIl0sIFsiYXBpa2V5IiwgInN0cmluZyJdLCBbImRlZmF1bHRsYXQiLCAic3RyaW5nIl0sIFsiZGVmYXVsdGxuZyIsICJzdHJpbmciXSwgWyJkZWZhdWx0em9vbSIsICJudW1iZXIiXV0nLCAnZ21hcHMnKTsNCkRST1AgVEFCTEUgSUYgRVhJU1RTIGBnbV9sYXllcnNgOw0KQ1JFQVRFIFRBQkxFIElGIE5PVCBFWElTVFMgYGdtX2xheWVyc2AgKCBgbGF5ZXJJZGAgaW50KDExKSBOT1QgTlVMTCBBVVRPX0lOQ1JFTUVOVCwgYGluZGV4YCBpbnQoMSkgTk9UIE5VTEwsIGBsYWJlbGAgdmFyY2hhcigyNTUpIE5PVCBOVUxMLCBgY29sb3JgIGRvdWJsZSBOT1QgTlVMTCBERUZBVUxUICcxNjczNzc5MicsIGBkZWxldGVkYCB0aW55aW50KDQpIE5PVCBOVUxMIERFRkFVTFQgJzAnLCBgbW9kaWZpY2F0aW9uZGF0ZWAgaW50KDExKSBOT1QgTlVMTCwgUFJJTUFSWSBLRVkgKGBsYXllcklkYCkgKSBFTkdJTkU9TXlJU0FNICBERUZBVUxUIENIQVJTRVQ9dXRmODsNCkRST1AgVEFCTEUgSUYgRVhJU1RTIGBnbV9sYXllcl9jb250ZW50YDsNCkNSRUFURSBUQUJMRSBJRiBOT1QgRVhJU1RTIGBnbV9sYXllcl9jb250ZW50YCAoIGBjb250ZW50SWRgIGludCgxMSkgTk9UIE5VTEwgQVVUT19JTkNSRU1FTlQsIGBsYXllcklkYCBpbnQoMTEpIE5PVCBOVUxMLCBgZmllbGRgIHZhcmNoYXIoMzApIE5PVCBOVUxMLCBgbGFuZ2AgdmFyY2hhcigzKSBOT1QgTlVMTCwgYHZhbHVlYCB0ZXh0IE5PVCBOVUxMLCBQUklNQVJZIEtFWSAoYGNvbnRlbnRJZGApLCBLRVkgYGxheWVySWRgIChgbGF5ZXJJZGApLCBLRVkgYGZpZWxkYCAoYGZpZWxkYCxgbGFuZ2ApICkgRU5HSU5FPU15SVNBTSAgREVGQVVMVCBDSEFSU0VUPXV0Zjg7DQpEUk9QIFRBQkxFIElGIEVYSVNUUyBgZ21fbWFya2Vyc2A7DQpDUkVBVEUgVEFCTEUgSUYgTk9UIEVYSVNUUyBgZ21fbWFya2Vyc2AgKCBgbWFya2VySWRgIGludCgxMSkgTk9UIE5VTEwgQVVUT19JTkNSRU1FTlQsIGBwYWdlSWRgIGludCgxMSkgTk9UIE5VTEwsIGBsYXRgIGRvdWJsZSBOT1QgTlVMTCwgYGxuZ2AgZG91YmxlIE5PVCBOVUxMLCBgbGF5ZXJgIGludCgxMSkgTk9UIE5VTEwsIGBjb2xvcmAgaW50KDExKSBOT1QgTlVMTCwgYGljb25gIHZhcmNoYXIoMjU1KSBOT1QgTlVMTCwgYGljb25zaXplYCB0aW55aW50KDQpIE5PVCBOVUxMIERFRkFVTFQgJzE2JywgYHVzZWxheWVyY29sb3JgIHRpbnlpbnQoMSkgTk9UIE5VTEwgREVGQVVMVCAnMScsIGBsYWJlbGAgdmFyY2hhcigyNTUpIE5PVCBOVUxMLCBgZGVsZXRlZGAgdGlueWludCg0KSBOT1QgTlVMTCBERUZBVUxUICcwJywgUFJJTUFSWSBLRVkgKGBtYXJrZXJJZGApLCBLRVkgYGxheWVyYCAoYGxheWVyYCksIEtFWSBgcGFnZUlkYCAoYHBhZ2VJZGApICkgRU5HSU5FPU15SVNBTSBERUZBVUxUIENIQVJTRVQ9dXRmODsNCkRST1AgVEFCTEUgSUYgRVhJU1RTIGBnbV9wb2x5cG9pbnRzYDsNCkNSRUFURSBUQUJMRSBJRiBOT1QgRVhJU1RTIGBnbV9wb2x5cG9pbnRzYCAoIGBwb2ludElkYCBpbnQoMTEpIE5PVCBOVUxMIEFVVE9fSU5DUkVNRU5ULCBgcG9seUlkYCBpbnQoMTEpIE5PVCBOVUxMLCBgbGF0YCBkb3VibGUgTk9UIE5VTEwsIGBsbmdgIGRvdWJsZSBOT1QgTlVMTCwgYGluZGV4YCBpbnQoMTEpIE5PVCBOVUxMLCBQUklNQVJZIEtFWSAoYHBvaW50SWRgKSwgS0VZIGBwb2x5SWRgIChgcG9seUlkYCkgKSBFTkdJTkU9TXlJU0FNIERFRkFVTFQgQ0hBUlNFVD1sYXRpbjE7DQpEUk9QIFRBQkxFIElGIEVYSVNUUyBgZ21fcG9seXNgOw0KQ1JFQVRFIFRBQkxFIElGIE5PVCBFWElTVFMgYGdtX3BvbHlzYCAoIGBwb2x5SWRgIGludCgxMSkgTk9UIE5VTEwgQVVUT19JTkNSRU1FTlQsIGBwYWdlSWRgIGludCgxMSkgTk9UIE5VTEwsIGBsYXllcmAgaW50KDExKSBOT1QgTlVMTCwgYGNvbG9yYCBpbnQoMTEpIE5PVCBOVUxMLCBgdXNlbGF5ZXJjb2xvcmAgdGlueWludCgxKSBOT1QgTlVMTCBERUZBVUxUICcxJywgYGxhYmVsYCB2YXJjaGFyKDI1NSkgTk9UIE5VTEwsIGBpc1NoYXBlYCBpbnQoNCkgTk9UIE5VTEwsIGBkZWxldGVkYCB0aW55aW50KDQpIE5PVCBOVUxMIERFRkFVTFQgJzAnLCBQUklNQVJZIEtFWSAoYHBvbHlJZGApLCBLRVkgYGxheWVyYCAoYGxheWVyYCksIEtFWSBgcGFnZUlkYCAoYHBhZ2VJZGApICkgRU5HSU5FPU15SVNBTSBERUZBVUxUIENIQVJTRVQ9dXRmODsNCkRST1AgVEFCTEUgSUYgRVhJU1RTIGBpdGVtZGVmaW5pdGlvbnNgOw0KQ1JFQVRFIFRBQkxFIElGIE5PVCBFWElTVFMgYGl0ZW1kZWZpbml0aW9uc2AgKCBgaWRgIGludCgxMSkgTk9UIE5VTEwgQVVUT19JTkNSRU1FTlQsIGBpdGVtVHlwZWAgaW50KDExKSBOT1QgTlVMTCwgYGxhYmVsYCB2YXJjaGFyKDI1NSkgTk9UIE5VTEwsIGBkaXNwbGF5bGFiZWxgIHZhcmNoYXIoMjU1KSBOT1QgTlVMTCwgYGluZGV4YCBpbnQoMTEpIE5PVCBOVUxMLCBgZmllbGRUeXBlYCB2YXJjaGFyKDMwKSBOT1QgTlVMTCwgYGNvbnRlbnR0eXBlYCB2YXJjaGFyKDIwKSBOT1QgTlVMTCwgYGRhdGFgIHRleHQgTk9UIE5VTEwsIGBzZWFyY2hhYmxlYCB0aW55aW50KDEpIE5PVCBOVUxMIERFRkFVTFQgJzEnLCBQUklNQVJZIEtFWSAoYGlkYCksIEtFWSBgaXRlbVR5cGVgIChgaXRlbVR5cGVgKSwgS0VZIGBmaWVsZFR5cGVgIChgZmllbGRUeXBlYCkgKSBFTkdJTkU9TXlJU0FNICBERUZBVUxUIENIQVJTRVQ9dXRmODsNCkRST1AgVEFCTEUgSUYgRVhJU1RTIGBpdGVtdHlwZXNgOw0KQ1JFQVRFIFRBQkxFIElGIE5PVCBFWElTVFMgYGl0ZW10eXBlc2AgKCBgaXRlbUlkYCBpbnQoMTEpIE5PVCBOVUxMIEFVVE9fSU5DUkVNRU5ULCBgbGFiZWxgIHZhcmNoYXIoMjU1KSBOT1QgTlVMTCwgYGRpc3BsYXlsYWJlbGAgdmFyY2hhcigyNTUpIE5PVCBOVUxMLCBgaWNvbmAgdmFyY2hhcigyNTUpIE5PVCBOVUxMLCBgbGlmZXRpbWVgIHZhcmNoYXIoNTApIE5PVCBOVUxMIERFRkFVTFQgJzEgbWludXRlJyBDT01NRU5UICdMaWZldGltZSBvZiBjYWNoZSwgZWc6ICcnMSB5ZWFyJycnLCBgcHJpb3JpdHlgIGludCgyKSBOT1QgTlVMTCwgYG1heGNoaWxkcmVuYCBkb3VibGUgTk9UIE5VTEwgREVGQVVMVCAnLTEnLCBgdmlzaWJsZWAgdGlueWludCgxKSBOT1QgTlVMTCBERUZBVUxUICcxJywgYHRlbXBsYXRldHlwZWAgaW50KDExKSBOT1QgTlVMTCBERUZBVUxUICcwJywgYHBhcnNlcmAgaW50KDQpIE5PVCBOVUxMIERFRkFVTFQgJzAnIENPTU1FTlQgJzA6IERlZmF1bHQsIDE6IENhbGVuZGFyJywgUFJJTUFSWSBLRVkgKGBpdGVtSWRgKSApIEVOR0lORT1NeUlTQU0gIERFRkFVTFQgQ0hBUlNFVD11dGY4Ow0KSU5TRVJUIElOVE8gYGl0ZW10eXBlc2AgKGBsYWJlbGAsIGBkaXNwbGF5bGFiZWxgLCBgaWNvbmAsIGBsaWZldGltZWAsIGBwcmlvcml0eWAsIGBtYXhjaGlsZHJlbmAsIGB2aXNpYmxlYCwgYHRlbXBsYXRldHlwZWAsIGBwYXJzZXJgKSBWQUxVRVMgKCdob21lcGFnZScsICdIb21lcGFnZScsICdob3VzZScsICcxIGRheScsIDEsIC0xLCAxLCAwLCAwKTsNCkRST1AgVEFCTEUgSUYgRVhJU1RTIGBtYWlscXVldWVgOw0KQ1JFQVRFIFRBQkxFIElGIE5PVCBFWElTVFMgYG1haWxxdWV1ZWAgKCBgaWRgIGludCgxMSkgTk9UIE5VTEwgQVVUT19JTkNSRU1FTlQsIGBwYWdlSWRgIGludCgxMSkgTk9UIE5VTEwsIGBncm91cHNgIHZhcmNoYXIoMjU1KSBDSEFSQUNURVIgU0VUIHV0ZjggTk9UIE5VTEwsIGBkYXRlYWRkZWRgIGRhdGV0aW1lIE5PVCBOVUxMLCBgaXNzZW5kYCB0aW55aW50KDQpIE5PVCBOVUxMIERFRkFVTFQgJzAnLCBQUklNQVJZIEtFWSAoYGlkYCkgKSBFTkdJTkU9TXlJU0FNIERFRkFVTFQgQ0hBUlNFVD1sYXRpbjE7DQpEUk9QIFRBQkxFIElGIEVYSVNUUyBgcGFnZWA7DQpDUkVBVEUgVEFCTEUgSUYgTk9UIEVYSVNUUyBgcGFnZWAgKCBgcGFnZUlkYCBpbnQoMTEpIE5PVCBOVUxMIEFVVE9fSU5DUkVNRU5ULCBgaXRlbVR5cGVgIGludCgxMSkgTk9UIE5VTEwsIGBsYWJlbGAgdmFyY2hhcigyNTUpIE5PVCBOVUxMLCBgcHVibGljYXRpb25kYXRlYCBkYXRldGltZSBOT1QgTlVMTCwgYGV4cGlyYXRpb25kYXRlYCBkYXRldGltZSBOT1QgTlVMTCwgYG1vZGlmaWNhdGlvbmRhdGVgIHRpbWVzdGFtcCBOT1QgTlVMTCBERUZBVUxUIENVUlJFTlRfVElNRVNUQU1QIE9OIFVQREFURSBDVVJSRU5UX1RJTUVTVEFNUCwgYGFsbHdheXNwdWJsaXNoZWRgIHRpbnlpbnQoMSkgTk9UIE5VTEwsIGBzaG93aW5uYXZpZ2F0aW9uYCB0aW55aW50KDEpIE5PVCBOVUxMIERFRkFVTFQgJzEnLCBQUklNQVJZIEtFWSAoYHBhZ2VJZGApLCBLRVkgYGl0ZW1UeXBlYCAoYGl0ZW1UeXBlYCkgKSBFTkdJTkU9TXlJU0FNICBERUZBVUxUIENIQVJTRVQ9dXRmODsNCklOU0VSVCBJTlRPIGBwYWdlYCAoYGl0ZW1UeXBlYCwgYGxhYmVsYCwgYHB1YmxpY2F0aW9uZGF0ZWAsIGBleHBpcmF0aW9uZGF0ZWAsIGBtb2RpZmljYXRpb25kYXRlYCwgYGFsbHdheXNwdWJsaXNoZWRgLCBgc2hvd2lubmF2aWdhdGlvbmApIFZBTFVFUyAoMSwgMSwgJ2hvbWUnLCAnMTk3MC0wMS0wMSAwMDowMDowMCcsICcxOTcwLTAxLTAxIDAwOjAwOjAwJywgJzE5NzAtMDEtMDEgMDA6MDA6MDAnLCAxLCAxKTsNCkRST1AgVEFCTEUgSUYgRVhJU1RTIGB0cmVlYDsNCkNSRUFURSBUQUJMRSBJRiBOT1QgRVhJU1RTIGB0cmVlYCAoIGB0cmVlSWRgIGludCgxMSkgTk9UIE5VTEwgQVVUT19JTkNSRU1FTlQsIGBwYXJlbnRJZGAgaW50KDExKSBOT1QgTlVMTCwgYHBhZ2VJZGAgaW50KDExKSBOT1QgTlVMTCwgYGluZGV4YCBpbnQoMTEpIE5PVCBOVUxMIERFRkFVTFQgJzAnLCBgbG9ja2VkYCB0aW55aW50KDQpIE5PVCBOVUxMIERFRkFVTFQgJzAnLCBgc2hvcnRjdXRgIGludCgxMSkgTk9UIE5VTEwgREVGQVVMVCAnMCcsIGBsb2dpbnJlcXVpcmVkYCB0aW55aW50KDEpIE5PVCBOVUxMIERFRkFVTFQgJzAnLCBQUklNQVJZIEtFWSAoYHRyZWVJZGApLCBLRVkgYHBhcmVudElkYCAoYHBhcmVudElkYCksIEtFWSBgcGFnZUlkYCAoYHBhZ2VJZGApICkgRU5HSU5FPU15SVNBTSAgREVGQVVMVCBDSEFSU0VUPXV0Zjg7DQpJTlNFUlQgSU5UTyBgdHJlZWAgKGB0cmVlSWRgLCBgcGFyZW50SWRgLCBgcGFnZUlkYCwgYGluZGV4YCwgYGxvY2tlZGAsIGBzaG9ydGN1dGAsIGBsb2dpbnJlcXVpcmVkYCkgVkFMVUVTICgxLCAwLCAxLCAwLCAxLCAwLCAwKTsNCkRST1AgVEFCTEUgSUYgRVhJU1RTIGB0cmVlYWNjZXNzYDsNCkNSRUFURSBUQUJMRSBJRiBOT1QgRVhJU1RTIGB0cmVlYWNjZXNzYCAoIGB0cmVlSWRgIGludCgxMSkgTk9UIE5VTEwsIGBncm91cElkYCBpbnQoMTEpIE5PVCBOVUxMLCBLRVkgYHRyZWVJZGAgKGB0cmVlSWRgLGBncm91cElkYCkgKSBFTkdJTkU9TXlJU0FNIERFRkFVTFQgQ0hBUlNFVD1sYXRpbjE7DQpEUk9QIFRBQkxFIElGIEVYSVNUUyBgdHdpdHRlcmA7DQpDUkVBVEUgVEFCTEUgSUYgTk9UIEVYSVNUUyBgdHdpdHRlcmAgKCBgaWRgIGludCgxKSBOT1QgTlVMTCBBVVRPX0lOQ1JFTUVOVCwgYHNjcmVlbm5hbWVgIHZhcmNoYXIoMjU1KSBOT1QgTlVMTCwgYHRva2VuYCB2YXJjaGFyKDI1NSkgTk9UIE5VTEwsIGBzZWNyZXRgIHZhcmNoYXIoMjU1KSBOT1QgTlVMTCwgUFJJTUFSWSBLRVkgKGBpZGApLCBVTklRVUUgS0VZIGBzY3JlZW5uYW1lYCAoYHNjcmVlbm5hbWVgKSApIEVOR0lORT1NeUlTQU0gIERFRkFVTFQgQ0hBUlNFVD11dGY4Ow0KRFJPUCBUQUJMRSBJRiBFWElTVFMgYHVwZGF0ZWA7DQpDUkVBVEUgVEFCTEUgSUYgTk9UIEVYSVNUUyBgdXBkYXRlYCAoIGBidWlsZGAgaW50KDExKSBOT1QgTlVMTCwgUFJJTUFSWSBLRVkgKGBidWlsZGApICkgRU5HSU5FPU15SVNBTSBERUZBVUxUIENIQVJTRVQ9bGF0aW4xOw0KSU5TRVJUIElOVE8gYHVwZGF0ZWAgKGBidWlsZGApIFZBTFVFUyAoNDk3Nyk7DQpEUk9QIFRBQkxFIElGIEVYSVNUUyBgdXNlcmA7DQpDUkVBVEUgVEFCTEUgSUYgTk9UIEVYSVNUUyBgdXNlcmAgKCBgaWRgIGludCgxMSkgTk9UIE5VTEwgQVVUT19JTkNSRU1FTlQsIGBlbWFpbGAgdmFyY2hhcigyNTUpIE5PVCBOVUxMLCBgcGFzc3dvcmRgIHZhcmNoYXIoMjU1KSBOT1QgTlVMTCwgYHJlZ2lzdHJhdGlvbmRhdGVgIHRpbWVzdGFtcCBOVUxMIERFRkFVTFQgQ1VSUkVOVF9USU1FU1RBTVAsIGBsYXN0bG9naW5gIGRhdGV0aW1lIE5PVCBOVUxMIERFRkFVTFQgJzE5NzAtMDEtMDEgMDA6MDA6MDAnLCBgbW9kaWZpY2F0aW9uZGF0ZWAgaW50KDExKSBOT1QgTlVMTCBERUZBVUxUICcwJywgYGFjdGl2YXRpb25jb2RlYCB2YXJjaGFyKDI1NSkgTk9UIE5VTEwsIGBhY3RpdmF0ZWRgIGludCgxMSkgTk9UIE5VTEwgREVGQVVMVCAnMCcsIGBkZWxldGVkYCB0aW55aW50KDEpIE5PVCBOVUxMIERFRkFVTFQgJzAnLCBQUklNQVJZIEtFWSAoYGlkYCkgKSBFTkdJTkU9TXlJU0FNICBERUZBVUxUIENIQVJTRVQ9dXRmODsNCkRST1AgVEFCTEUgSUYgRVhJU1RTIGB1c2VyZmllbGRzYDsNCkNSRUFURSBUQUJMRSBJRiBOT1QgRVhJU1RTIGB1c2VyZmllbGRzYCAoIGBmaWVsZElkYCBpbnQoMTEpIE5PVCBOVUxMIEFVVE9fSU5DUkVNRU5ULCBgdXNlcklkYCBpbnQoMTEpIE5PVCBOVUxMLCBgZmllbGRgIHZhcmNoYXIoMjU1KSBOT1QgTlVMTCwgYHZhbHVlYCB0ZXh0IE5PVCBOVUxMLCBgZGVsZXRlZGAgdGlueWludCgxKSBOT1QgTlVMTCBERUZBVUxUICcwJywgUFJJTUFSWSBLRVkgKGBmaWVsZElkYCksIEtFWSBgdXNlcklkXzJgIChgdXNlcklkYCksIEtFWSBgdXNlcklkYCAoYHVzZXJJZGAsYGZpZWxkYCkgKSBFTkdJTkU9TXlJU0FNICBERUZBVUxUIENIQVJTRVQ9dXRmODsNCkRST1AgVEFCTEUgSUYgRVhJU1RTIGB1c2VyZ3JvdXBzYDsNCkNSRUFURSBUQUJMRSBJRiBOT1QgRVhJU1RTIGB1c2VyZ3JvdXBzYCAoIGBncm91cElkYCBpbnQoMTEpIE5PVCBOVUxMIEFVVE9fSU5DUkVNRU5ULCBgZ3JvdXBuYW1lYCB2YXJjaGFyKDI1NSkgTk9UIE5VTEwsIFBSSU1BUlkgS0VZIChgZ3JvdXBJZGApICkgRU5HSU5FPU15SVNBTSBERUZBVUxUIENIQVJTRVQ9dXRmODsNCkRST1AgVEFCTEUgSUYgRVhJU1RTIGB1c2VydXNlcmdyb3Vwc2A7DQpDUkVBVEUgVEFCTEUgSUYgTk9UIEVYSVNUUyBgdXNlcnVzZXJncm91cHNgICggYGdyb3VwSWRgIGludCgxMSkgTk9UIE5VTEwsIGB1c2VySWRgIGludCgxMSkgTk9UIE5VTEwsIGBkZWxldGVkYCB0aW55aW50KDEpIE5PVCBOVUxMIERFRkFVTFQgJzAnLCBVTklRVUUgS0VZIGBncm91cElkYCAoYGdyb3VwSWRgLGB1c2VySWRgKSwgS0VZIGBkZWxldGVkYCAoYGRlbGV0ZWRgKSApIEVOR0lORT1NeUlTQU0gREVGQVVMVCBDSEFSU0VUPXV0Zjg7');
					$conn -> multi_query($sqlfile); 
					while ($conn -> more_results() && $conn -> next_result());
					$conn -> close();
					
				}
			}
					
			if($dbaccess) {	
				
				if(!is_dir($config -> basepath . 'bright/site/config')) {
					if(!@mkdir($config -> basepath . 'bright/site/config', 0644, true)) {
						$errarr[] = 'Cannot create config dir';
					}
					@mkdir($config -> basepath . 'bright/site/views');
					@mkdir($config -> basepath . 'bright/site/templates');
					@mkdir($config -> basepath . 'bright/site/actions');
					@mkdir($config -> basepath . 'bright/site/hooks');
					
					if(!file_exists($config -> basepath . 'bright/site/views/BaseView.php')) {
						file_put_contents($config -> basepath . 'bright/site/views/BaseView.php', base64_decode($baseview));
					}
				}
				$sample = file_get_contents($config -> basepath . 'bright/library/Bright/config/Constants.php.txt');
				$settings = array();
				$vars  = get_object_vars ($config);
				foreach($vars as $key => $value) {
					if($value != '') {
						$wrap = "'";
						$add = true;
						switch($key) {
							case 'uploadfolder':
							case 'smtp':
							case 'smtpport':
								// Skip if default
								if($value == $default -> {$key}) {
									$add = false;
								}
							
							case 'runimport':
							case 'submit_btn':
								$add = false;
								break;
							
							case 'smtpport':
								$wrap = '';
								break;
							
							case 'useprefix':
								$wrap = '';
								$value = ($value == 'on') ? 'true' : 'false';
								break;
						}
						if($add) {
							$settings[] = 'protected $' . strtoupper($key) . ' = ' . $wrap . $value . $wrap . ';';
							
						}
					}
					
					$sample = str_replace('###VALUES###', implode("\r\n\t", $settings), $sample);
					$writeconfig = file_put_contents($config -> basepath . 'bright/site/config/Constants.php', $sample);
					
					//echo $sample;
				}
			}
			
		}
		
		
	}
	
	function getMessages($type, $arr) {
		if(count($arr) == 0) 
			return '';
		$class = '';
		switch($type) {
			case 'e': $class = 'error';break;
			case 'i': $class = 'information';break;
			case 'o': $class = 'okdiv';break;
		}
		
		$ret = '<div class="' . $class .'"><ul><li>';
		$ret .= join('</li><li>', $arr);
		$ret .= '</li></ul></div>';
		return $ret;
		
	}
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
	
	<title>Bright CMS - Setup</title>
	
	<script src="//ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js"></script>
	
	
	
	<style type="text/css">
		*{
			margin: 			0; 
			padding: 			0;
		}
		html, body { 
			margin: 			0; 
			padding: 			0; 
			width: 				100%;
			height: 			100%;
			background-color:	#50799b;
			font-size:			10pt;
			font-family:		Arial, Helvetica, sans;
		}
		
		h1,h2,h3 {
			clear:				both;
			padding-top:		15px;
			padding-bottom:		5px;
			font-family:		Georgia, Sylfaen, Times;
			font-weight:		normal;
		}
		
		p {
			margin-bottom:		10px;
		}
		
		#content {
			padding:			10px;
			width:				800px;
			background-color:	#ffffff;
			margin: 			0 auto;
		}
		
		.fakelabel,
		label {
			display: block;
			float:left;
/*			clear: left;*/
			width: 250px;
			padding-top: 2px;
		}
		.fakeinput,
		input {
			display:			block;
			clear: 				right;
			float: 				left;
		}
		
		.fakeinput {
			font-weight: 		bold;
		}
		
		input[type='password'],
		input[type='text'] {
			width: 300px;
			height: 20px;
		}
		
		p.label_field_pair {
			clear: both;
			float: none;
			height: 20px;
			margin-bottom: 5px;
		}
			
		.information ul, .error ul, .okdiv ul {
			list-style-type: none;
			font-weight: bold;
		}
		
		.information {
			border: 1px solid #dd9a54;
			background-color: #FFFFAA; /*#f3ebd4;*/
		}

		.error {
			border: 1px solid #bd5748;
			background-color: #FCB2AA;
		}

		.okdiv {
			border: 1px solid #90a232;
			background-color: #e6ebc3;
		}
		
		.information, .error, .okdiv {
			padding: 5px;
			margin-bottom: 10px;
		}
	</style>
</head>

<body>
	<div id="content">
		<h1>Bright CMS - Setup</h1>
		<?php 
			if($writeconfig === false) {
				$sample = htmlentities($sample);
				echo <<<EOT
				<p>Could not write your config file, copy the following lines to <b>bright/site/config/Constants.php</b></p>
				<pre>$sample</pre>';
EOT;
			} else {
			?>
		<form action="/bright/cms/setup.php" method="post">
			<p>It seems your configuration file is missing, this script will create on for you.<br/>
			This script will create the default config file. Edit the file to add additional server settings.</p>
			
			<?php echo getMessages('e', $errarr);?>
			<?php echo getMessages('i', $infoarr);?>
			<?php echo getMessages('o', $okarr);?>
			
			<div class='settingsdiv'>	
				<h2>Database settings</h2>
				<p class='label_field_pair'><label for="dbuser">Username:</label>
				<input type="text" name="dbuser" id="dbuser" value="<?php echo $config -> dbuser?>" /></p>
				
				<p class='label_field_pair'><label for="dbpass">Password:</label>
				<input type="password" name="dbpass" id="dbpass" value="<?php echo $config -> dbpass?>" /></p>
				
				<p class='label_field_pair'><label for="dbserver">Servername:</label>
				<input type="text" name="dbserver" id="dbserver" value="<?php echo $config -> dbserver?>" /></p>
				
				<p class='label_field_pair'><label for="dbname">Database name:</label>
				<input type="text" name="dbname" id="dbname" value="<?php echo $config -> dbname?>" /></p>
				
				<p class='label_field_pair'><label for="runimport">Run import script on database:</label>
				<input type="checkbox" name="runimport" id="runimport" <?php echo $config -> runimport;?> /></p>
				
				
				<h2>General</h2>
				
				<p class='label_field_pair'><label for="sitename">Name of website:</label>
				<input type="text" name="sitename" id="sitename" value="<?php echo $config -> sitename;?>" /></p>
								
				<p class='label_field_pair'><label for="availablelang">Available languages (comma separated):</label>
				<input type="text" name="availablelang" id="availablelang" value="<?php echo $config -> availablelang;?>" /></p>
								
				<p class='label_field_pair'><label for="useprefix">Use language prefix (/nl/, /en/ etc.):</label>
				<input type="checkbox" name="useprefix" id="useprefix" <?php echo $config -> useprefix;?> /></p>
				
				<p class='label_field_pair'><label for="logo">Path to logo (117px * 117px):</label>
				<input type="text" name="logo" id="logo" value="<?php echo $config -> logo?>" /></p>
				
				<h2>Paths &amp; urls</h2>
				<p class='label_field_pair'><label for="baseurl">Base url (domainname) of site:</label>
				<input type="text" name="baseurl" id="baseurl" value="<?php echo $config -> baseurl;?>" /></p>
				
				<p class='label_field_pair'><label for="uploadfolder">Uploadfolder:</label>
				<input type="text" name="uploadfolder" id="uploadfolder" value="<?php echo $config -> uploadfolder;?>" /></p>
				
				<p class='label_field_pair'><span class='fakelabel'>Base path:</span>
				<span class='fakeinput'><?php echo $config -> basepath;?></span></p>
		
				<h2>Email</h2>
				<p class='label_field_pair'><label for="mailingfrom">Mailing 'from' email:</label>
				<input type="text" name="mailingfrom" id="mailingfrom" value="<?php echo $config -> mailingfrom;?>" /></p>
		
				<p class='label_field_pair'><label for="mailingbounce">E-mail to send bounced emails to:</label>
				<input type="text" name="mailingbounce" id="mailingbounce" value="<?php echo $config -> mailingbounce;?>" /></p>
		
				<p class='label_field_pair'><label for="sysmail">E-mail to send system mails to (dev mail):</label>
				<input type="text" name="sysmail" id="sysmail" value="<?php echo $config -> sysmail;?>" /></p>
		
		
				<p class='label_field_pair'><label for="transport">Smtp transport:</label>
				<input type="text" name="transport" id="transport" value="<?php echo $config -> transport;?>" /></p>
		
				<p class='label_field_pair'><label for="smtp">Smtp server:</label>
				<input type="text" name="smtp" id="smtp" value="<?php echo $config -> smtp;?>" /></p>
		
				<p class='label_field_pair'><label for="smtpport">Smtp port:</label>
				<input type="text" name="smtpport" id="smtpport" value="<?php echo $config -> smtpport;?>" /></p>
				
				<h2>Optional settings</h2>
		
				<p class='label_field_pair'><label for="googlemapsapikey">Google Maps Api key:</label>
				<input type="text" name="googlemapsapikey" id="googlemapsapikey" value="<?php echo $config -> googlemapsapikey;?>" /></p>
		
				<p class='label_field_pair'><label for="additionalmodules">Additional modules (comma separated):</label>
				<input type="text" name="additionalmodules" id="additionalmodules" value="<?php echo $config -> additionalmodules;?>" /></p>
		
				<p class='label_field_pair'><label for="loginpage">Login page:</label>
				<input type="text" name="loginpage" id="loginpage" value="<?php echo $config -> loginpage;?>" /></p>
		
				<p class='label_field_pair'><label for="activationpage">Activation page:</label>
				<input type="text" name="activationpage" id="activationpage" value="<?php echo $config -> activationpage;?>" /></p>
				
				<p class='label_field_pair'><label for="deactivationpage">Deactivation page:</label>
				<input type="text" name="deactivationpage" id="deactivationpage" value="<?php echo $config -> deactivationpage;?>" /></p>
		
				<p class='label_field_pair'><label for="submit">&nbsp;</label>
				<input type="submit" name='submit_btn' class="text" value="Go!" /></p>
			</div>
		</form>
		<?php }?>
	</div>
</body>
</html>
