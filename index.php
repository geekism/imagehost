<?php
$uploaddir = "fGsniaindFC9eRNo/";
$dir = getcwd() . "/".$uploaddir;
$output = '';
$imagehost = "v3.0.0";
$message = "";

if(isset($_GET['view']) == "yes") { $show = "1"; } else { $show = "0"; }
if(isset($_POST['submit'])) {
	$temp_name = $_FILES["file"]["tmp_name"];
	$name = $_FILES["file"]["name"];
	if (is_image($temp_name)) {
		$newname = substr(str_shuffle(str_repeat("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0987654321", 10)), 0, 10);
		$ext = pathinfo($name, PATHINFO_EXTENSION);
		move_uploaded_file($temp_name, $uploaddir."/$newname.$ext");
		chmod("$uploaddir/$newname.$ext", 0644);
		$newfilename = $newname.'.'.$ext;
		$image_properties = getimagesize("".$dir."/".$newfilename."");
		$message .= "". $newname . "." . $ext . " was uploaded!<br><br>";
		$message .= "Filename: <b>".$newfilename."</b><br>";
		$message .= "Resolution: <b>".$image_properties['0']."</b>px x <b>".$image_properties['1']."</b>px!<br>";
		$message .= "Mime: <b>".$image_properties['mime']."</b>!<br>";
	} else {
		echo "$name isnt a image, or isnt an acceptable format!"; return 0;
	}
}

function countfiles() {
	global $dir;
	$filecount = 0;
	$files = glob($dir . "*");
	if ($files){
		$filecount = count($files);
	}
	return $filecount;
}

function getFileExt($filename) { return substr(strrchr($filename,'.'),1); }
function getFilesize($file,$digits = 2) {
if (is_file($file)) {
	$filePath = $file;
	if (!realpath($filePath)) { $filePath = $_SERVER["DOCUMENT_ROOT"].$filePath; }
	$fileSize = filesize($filePath);
	$sizes = array("TB","GB","MB","KB","B");
	$total = count($sizes);
	while ($total-- && $fileSize > 1024) { $fileSize /= 1024; }
	return round($fileSize, $digits)." ".$sizes[$total];
}
	return false;
}
function is_image($path) {
	$a = getimagesize($path);
	$image_type = $a[2];
	if(in_array($image_type, array(
		IMAGETYPE_GIF,
		IMAGETYPE_JPEG,
		IMAGETYPE_PNG,
		IMAGETYPE_TIFF_II,
		IMAGETYPE_TIFF_MM,
		IMAGETYPE_BMP,
		IMAGETYPE_ICO,
		IMAGETYPE_IFF,
		IMAGETYPE_XBM,
		IMAGETYPE_WEBP,
		IMAGETYPE_PSD))
	) { return true; }
	return false;
}
function checkMissing() {
	global $uploaddir;
	if (!file_exists($uploaddir)) {
		mkdir("$uploaddir", 0755);
		chmod("$uploaddir", 0755);
		$output .= '
		<head>
		<style type="text/css">
		body { background: #000; color: #fefefe; font-family: Tahoma, Arial, Helvetica, Sans-Serif; font-size: 0.900em; }
		</style>
		<title>Missing: uploads folder</title>
		</head>
		<html>
		<body>
		<center><BR><BR><BR><BR>
		<h2>
		Directory: <b>'.$uploaddir.'</b> wasnt found.
		</h2><br>
		Creating it: mkdir '.$uploaddir.'/<br>
		Setting permissions: chmod 755 '.$uploaddir.'/<br>
		Click to <a href="">Continue</a></center><BR><BR><BR><BR>
		</body>
		</html>
		';
	echo $output;
	return 0;
	}
	if (!file_exists(".htaccess")) {
		$file = '.htaccess';
		$contents = '
		<IfModule mod_rewrite.c>
		RewriteEngine on
		RewriteCond %{HTTPS} !=on
		RewriteRule ^/?(.*) https://%{SERVER_NAME}/$1 [R,L]
		RewriteRule "^takeapeek/(.*)$" "/'.$uploaddir.'/$1"
		RewriteRule "^i/(.*)$" "/'.$uploaddir.'/$1"
		RewriteRule "^view/(.*)$" "/'.$uploaddir.'/$1"
		</IfModule>
		Options -Indexes -MultiViews
		';
		file_put_contents($file, $contents);
		chmod(".htaccess", 0644);
		$output .= '
		<head>
		<style type="text/css">
		body { background: #000; color: #fefefe; font-family: Tahoma, Arial, Helvetica, Sans-Serif; font-size: 0.900em; }
		</style>
		<title>Missing: .htaccess</title>
		</head>
		<html>
		<body>
		<center><BR><BR><BR><BR>
		<h2>
		File: <b>.htaccess</b> wasnt found.
		</h2><br>
		Creating it: touch .htaccess<br>
		Writing .htaccess settings ... Done<br>
		Click to <a href="">Continue</a></center><BR><BR><BR><BR>
		</body>
		</html>
		';
	echo $output;
	return 0;
	}
}
checkMissing();
?>
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
		accept { background: green; color: #fefefe; font-family: 'Trebuchet MS'; font-size: 0.750em; font-color: #fefefe; }
		deny { background: red; color: #fefefe; font-family: 'Trebuchet MS'; font-size: 0.750em; font-color: #fefefe; }
		list { font-color: #fff; }
		#<!-- input[type=button], input[type=submit], input[type=reset] .abutton:hover { background-color: #555; border: none; color: white; padding: 2px 8px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; border-radius: 10%; -webkit-transition-duration: 0.4s; transition-duration: 0.4s; } -->
		input[type=button], input[type=submit], input[type=reset] .abutton:hover { background-color: #555; color: white; box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24), 0 17px 50px 0 rgba(0,0,0,0.19); }
		header { color: #fff; font-size: 20px; font-weight: bold; }
	</style>
	<title>Image Hosting: Powered by justla.me</title>
</head>
<html>
	<body>
		<table border="0" cellpadding="0" cellspacing="0" width="100%"><th>
			<a href="/">go home</a> - <?php if ($show) { echo '<a href="/">hide uploaded images</a>'; }else{ echo '<a href="?view=yes">show uploaded images</a>'; } ?>
		</th></table>
		<table border="0" cellpadding="0" cellspacing="0" width="100%"><center><th><br><br>
			<header>Free Image Hosting!</header>
			<?php
				$count = countfiles();
				echo "There is ".countfiles()." images being hosted on this server!";
			?><br><br>
			<form action="" method="post" enctype="multipart/form-data" id="hostimg">
			<input type="file" name="file" id="file" multiple="multiple" accept="image/*"/>
			<br><accept for="female">Accepted Formats: jpg, jpeg. bmp, png, gif</accept><br>
			<br><deny for="female">Not Accepted Formats: TIFF_II, TIF_MM</deny><br>
			<br><br>
			<input type="submit" name="submit" value="submit"/>
			</form><BR><BR>
			<?php
				if ($message) {
					echo $message;
					echo "<img src=\"takeapeek/".$newname.".".$ext."\" alt=\"".$newname.".".$ext."\"><br><br>";
					echo "<a href=takeapeek/".$newname.".".$ext.">http://".$_SERVER['HTTP_HOST']."/takeapeek/".$newname.".".$ext."</a>";
				}
			?>
			<BR><BR>
			<footer>ImageHosting<?php echo $imagehost; ?>.php: Powered by <a href="https://github.com/geekism/imagehost" target="_blank">justla.me</a><br><br></footer></center></th>
		</table>
		<?php
			if ($_GET['view']) { showImages(); }
			function showImages() {
				global $dir;
				$imagelist = '';
				$okfiletypes = array('jpg','jpeg','bmp','png','gif');
				$files = array();
				if (is_dir($dir)) {
				if ($dh = opendir($dir)) {
					while (($file = readdir($dh)) !== false) { 
						if (($file != '.') && ($file != '..')) { 
							if (in_array(strtolower(substr($file,(strrpos($file,'.')+1))),$okfiletypes)) { 
								$files[] = $file;
							}
						}
					}
					closedir($dh);
				}
			}
			sort($files);
			echo '<table border="0" cellpadding="0" cellspacing="0" width="100%"><th><header>listing current images</header></th><table border="0" cellpadding="0" cellspacing="0" width="100%"><center><th>';
			foreach ($files as $file) {
				$mod_date=date("F d Y [H:m:s]", filemtime($dir.'/'.$file));
				echo '<b><list><ul><li>'.$mod_date,'</b>: <a href="/takeapeek/'.$file.'">'.$file.'</a> - size: '.getFilesize($dir.'/'.$file).'</li></ul>'; }
				echo '</center></th></table></table>';
			}
		?>
	</body>
</html>
