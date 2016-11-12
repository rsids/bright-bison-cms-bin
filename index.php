<?php
session_start();
if (!file_exists(dirname(__FILE__) . '/../site/config/Constants.php')) {
    header('Location: /bright/cms/setup.php');
    exit;
}
include_once(dirname(__FILE__) . '/../library/Bright/Bright.php');

$http = isset($_SERVER['https']) && $_SERVER['https'] ? 'https://' : 'http://';
// Make sure the given url is the same as the BASEURL
if (BASEURL != $http . $_SERVER['HTTP_HOST'] . '/') {
    header('Location: ' . BASEURL . 'bright/cms/');
    exit;
}

$adm = new Administrator();
$showerror = false;
if (isset($_POST['submit'])) {
    $data = filter_input_array(INPUT_POST, array('email' => FILTER_VALIDATE_EMAIL, 'password' => FILTER_SANITIZE_STRING));

    if ($data['email'] !== false && $data['password'] !== false) {
        $result = $adm->authenticate($data['email'], sha1($data['password']));
        $showerror = ($result === null);
    } else {
        $showerror = true;
    }

}

$isauth = $adm->isAuth(null);
?><!DOCTYPE html>
<html>
<head>
    <!--
        Product van: Fur
        Bloemsingel 222
        9712 KZ Groningen
        www.wewantfur.com
        -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="AUTHOR" content="Fur"/>
    <meta name="googlebot" content="noindex,noarchive,nofollow"/>
    <meta name="robots" content="noindex,noarchive,nofollow"/>

    <title>Bright CMS</title>
    <link href="screen.css" rel="stylesheet" type="text/css" media=" screen"/>
    <?php
    if ($isauth) {
    ?>
    <script src="//ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js"></script>

    <script type="text/javascript">
        //<!--
        var cmsdir = "/<?php echo CMSFOLDER;?>";
        var flashvars = {gateway: "<?php echo GATEWAY;?>"};

        var params = {showMenu: false};
        var attributes = {};
        swfobject.embedSWF("bright_cms.swf?V=3.24&b=7646",
            "bright_cms",
            "100%",
            "100%",
            "10.1.0",
            "expressInstall.swf",
            flashvars,
            params,
            attributes);

        //-->
    </script>
    <script src="js/main.js?ver=2.6" type="text/javascript"></script>
</head>
<body>
<div id="bright_cms">
    <h1>Flash Player not found</h1>

    <p>To run Bright CMS, Adobe Flash Player 10.1.0 is required, you can download it here:<br/>
        <a href="http://www.adobe.com/go/getflashplayer">Download flash</a></p>
</div>
</body>
<?php } else { ?>
    </head>

    <body>
    <div class="panel">
        <?php if (strpos(LOGO, "/images") === 0) { ?>
            <img src="<?php echo LOGO; ?>">

        <?php } else { ?>
            <img src="/images/brightlogo<?php echo LOGO; ?>">

        <?php } ?>
        <form method="post" action="/bright/cms/">
            <div id="formdiv">
                <label for="email">E-mail address:</label>
                <input type="email" name="email" id="email"/>

                <label for="password">Password:</label>
                <input type="password" name="password" id="password"/>

            </div>
            <div class="clear"></div>
            <hr/>
            <?php if ($showerror) {
                echo '<span class="error">Invalid username or password</span>';
            } ?>
            <input type="submit" name="submit" value="login"/>
        </form>
    </div>
    </body>
<?php } ?>
</html>
