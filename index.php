<?php

/* 
	Do not edit anything from here to the STOP. Required for the missing features!
*/

function checkMissing() {
	if (!file_exists("uploads")) {
	mkdir("uploads", 0755); chmod("uploads", 0755);
		echo '
			<head>
				<style type="text/css">
				body { background: #000; color: #fefefe; font-family: Tahoma, Arial, Helvetica, Sans-Serif; font-size: 0.900em; }
				</style>
			<title>Missing: uploads folder</title>
			</head>
			<html>
				<body>
					<center><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR>
						<h2>
							Directory: <b>uploads</b> wasnt found.
						</h2><br>
							Creating it: mkdir uploads/<br>
							Setting permissions: chmod 755 uploads/<br>
							Click to <a href="">Continue</a></center>
				</body>
			</html>
			';
		return 0;
	}
	if (!file_exists(".htaccess")) {
	$file = '.htaccess';
	$contents = '
	<IfModule mod_rewrite.c>
		RewriteEngine on
		RewriteCond %{HTTPS} !=on
		RewriteRule ^/?(.*) https://%{SERVER_NAME}/$1 [R,L]
		RewriteRule "^img/(.*)$" "/uploads/$1"
	</IfModule>
	Options -Indexes -MultiViews
	';
	file_put_contents($file, $contents);
	    echo '
			<head>
				<style type="text/css">
				body { background: #000; color: #fefefe; font-family: Tahoma, Arial, Helvetica, Sans-Serif; font-size: 0.900em; }
				</style>
			<title>Missing: .htaccess</title>
			</head>
			<html>
				<body>
					<center><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR>
						<h2>
							File: <b>.htaccess</b> wasnt found.
						</h2><br>
							Creating it: touch .htaccess<br>
							Writing .htaccess settings ... Done<br>
							Click to <a href="">Continue</a></center>
				</body>
			</html>
			';
		return 0;
	}
}

$imagehost = "v1.5.8";


if(isset($_REQUEST["download"])){
    $file = urldecode($_REQUEST["download"]);
    $filepath = getcwd() . "/" . $file;
    if(file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filepath));
        flush();
        readfile($filepath);
        exit;
    }
}

$fi = new FilesystemIterator(__DIR__ . "/uploads/", FilesystemIterator::SKIP_DOTS);

if($_GET['view']) { $show = "1"; }

function getFileExt($filename) {
   return substr(strrchr($filename,'.'),1);
}

function is_image($path) {
    $a = getimagesize($path);
    $image_type = $a[2];
    if(in_array($image_type , array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_BMP))) { return true; }
    return false;
}

if(isset($_POST['submit'])) {
    $temp_name = $_FILES["file"]["tmp_name"];
    $name = $_FILES["file"]["name"];
    if (is_image($temp_name)) {
        $newname = substr(str_shuffle(str_repeat("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0987654321", 10)), 0, 10);
        $ext = pathinfo($name, PATHINFO_EXTENSION);
        move_uploaded_file($temp_name, "uploads/$newname.$ext");
        chmod("uploads/$newname.$ext", 0644);
        $message = "". $newname . "." . $ext . " was uploaded!<br><br>";
    }
}

checkMissing();
$imagelist = 'fucker';
?>





<!--
Edit below: CSS Style is below!
-->

	<head>
			<style type="text/css">
			      body { background: #222222; color: #fefefe; font-family: Tahoma, 'Lucida Grande', 'Trebuchet MS', Arial, Helvetica, Sans-Serif; font-size: 0.900em; font-color: #242424; }
			      a { color: #ffa200; text-decoration: none; }
			      a:hover { text-decoration: underline bold; color: #242424; }
			      table { margin: auto; width: 75%; border-collapse:separate; border:solid white 1px; border-radius:4px; -moz-border-radius:4px; padding-left: 10px; padding-right: 10px; background: #242424; border: 1px solid #fff; white-space: pre-line; }
			      td.main { color: #fff; background: #242424; font-size: 0.900em; padding-top: 3px; padding-bottom: 3px; width: 99%; }
			      td.main a { color:#ffa200; font-size: 0.900em; width: 99%; }
			      img { width: 600px; height: 400px; border: 2px solid #242424; }
			      td.main a:hover { background: #242424; color: #fff; }
			      td { background: #242424; color: #fff; }
			      th { font-weight: normal; }
			      tr.main td { padding-top: 2px; padding-bottom: 2px; vertical-align: top; padding-left: 10px; padding-right: 10px; white-space: pre-line;  }
			      ainput[type=button], ainput[type=submit], ainput[type=reset] { background-color: #555; border: none; color: white; padding: 2px 8px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; border-radius: 10%; -webkit-transition-duration: 0.4s; transition-duration: 0.4s; }
			      input[type=button], input[type=submit], input[type=reset] .abutton:hover { background-color: #555; color: white; box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24), 0 17px 50px 0 rgba(0,0,0,0.19); }
			      footer { color: #fff; font-size: 10px; }
			</style>
		<title>Image Hosting: Powered by justla.me</title>
	</head>
<html>
	<body>
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<th>
			<a href="/">home</a> - <a href="?view=images">images</a>
		    </th>
		</table>


		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<center>
			<th>
				<br><br>
				<h2>Free Image Hosting!</h2>
				<?php printf("There is %d images being hosted on this server", iterator_count($fi)); ?>
				<br><br>
				<form action="" method="post" enctype="multipart/form-data" id="hostimg">
				<input type="file" name="file" id="file" multiple="multiple" accept="image/*"/>
				<br><label for="female">Accepted Formats: jpg, jpeg. bmp, png, gif</label><br>
				<br><br>
				<input type="submit" name="submit" value="submit"/>
				</form> 
				<BR><BR>	
				<?php
					if ($message) {
							echo $message;
							echo "<img src=\"img/".$newname.".".$ext."\" alt=\"".$newname.".".$ext."\"><br><br>";
							echo "<a href=img/".$newname.".".$ext.">http://".$_SERVER['HTTP_HOST']."/img/".$newname.".".$ext."</a>";
					}
				?>
				<BR><BR>
                                <footer>ImageHosting<?php echo $imagehost; ?>.php: Powered by <a href="https://github.com/geekism/imagehost" target="_blank">justla.me</a><br><br></footer>
			</center>
			</th>
		</table>
		<?php
			if ($_GET['view']) { showImages(); }
			function showImages() {
				$imagelist = '';
			        $dir = getcwd() . "/uploads";
				$okfiletypes = array('jpg','jpeg','bmp','png','gif');
			        $files = array();
			        if (is_dir($dir)) {
			                if ($dh = opendir($dir)) {
                        			while (($file = readdir($dh)) !== false) {
			                                if (($file != '.') && ($file != '..')) { if (in_array(strtolower(substr($file,(strrpos($file,'.')+1))),$okfiletypes)) { $files[] = $file; } }
                        			}
                        			closedir($dh);
                			}
        			}
				sort($files);
				//foreach ($files as $file) { }
				echo '
                        	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	                                <th>listing current images</th>
        		                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        			        <center><th>
				';
								foreach ($files as $file) { echo '<a href="/img/'.$file.'">'.$file.'</a><br>'; }
				echo '
							</th></center>
                		                </table>
                        	</table>
                        	';
			}
		?>
	</body>
</html>
