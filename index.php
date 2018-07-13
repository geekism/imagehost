<?php

########################################## START CONFIG #############################################################
$SHOW_DOT = 0;
$changelog = 0;
$ignore_file_list = array("..", ".", "index.php", "view.php", "icons.png", "styles", ".htaccess", "img", "includes", ".git", ".svn");
$ignore_ext_list = array("exe", "txt", "ini", "conf");
######################################### END CONFIG ################################################################

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
function is_image($path) {
	$a = getimagesize($path);
	$image_type = $a[2];
	if(in_array($image_type , array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_TIFF_II, IMAGETYPE_TIFF_MM, IMAGETYPE_BMP, IMAGETYPE_ICO, IMAGETYPE_IFF, IMAGETYPE_XBM, IMAGETYPE_WEBP, IMAGETYPE_PSD))) { return true; }
	return false;
}

$source = $_GET['view'];
$file = $_GET['file'];

if (strpos($source, 'source') !== false) { echo nl2br(htmlentities(file_get_contents("index.php"))); die(); }
if (isset($file)) {
   echo "<b><p>viewing:&nbsp;&nbsp;&nbsp;&nbsp;".$file."&nbsp;&nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp;view raw: &nbsp;&nbsp;&nbsp;&nbsp; <a href=".$_GET['file'].">".$file."</a></p></b>";
   if (strpos($file, '..') !== false || (strpos($file, '%2E') !== false) || (strpos($file, 'view.php') !== false) || (strpos($file, 'index.php') !== false)) { echo "<h1>Illegal char/filename found in URL</h1>"; exit; }
echo '
<!DOCTYPE html> 
<html lang="en">
<head>
   <title>source of: '.$file.' </title>
   <meta charset="utf-8">
   <style>
	   body { align: center; background: #222222; color: #fefefe; font-family: Tahoma, Arial, Helvetica, Sans-Serif; font-size: 0.900em; font-color: #242424; }
	   a { color: #ffa200; text-decoration: none; }
	   a:hover { text-decoration: underline bold; color: #242424; }
     table { margin: auto; width: 99%; border-collapse: separate; border:solid white 1px; border-radius:9px; -moz-border-radius:9px; padding-left: 10px; padding-right: 10px; background: #242424; border: 1px solid #fff; white-space: pre-line; }
	   td.main { color: #fff; background: #242424; font-size: 0.900em; padding-top: 3px; padding-bottom: 3px; white-space: pre-line; }
	   td.main a { color:#ffa200; font-size: 0.900em; }
	   img { width: 15px; height: 15px; border: 2px solid #242424; }
	   td.main a:hover { background: #242424; color: #fff; font-weight: bold; }
	   td { background: #242424; color: #fff; }
     tr.main td { padding-top: 2px; padding-bottom: 2px; vertical-align: top; padding-left: 10px; padding-right: 10px; white-space: pre-line; }
	   pre { font-family: monospace; width: 100%; border: 1px dashed #454545; !important; }
	   p { text-align: center; }
   </style>
   <script src="//cdn.rawgit.com/geekism/code-prettify/master/loader/run_prettify.js?skin=sons-of-obsidian"></script>
</head>
<body onload="PR.prettyPrint();">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<pre class="prettyprint white-space: pre-line linenums">';

if (is_image($file)) {
	echo "<img src=\"".$file."\" style=\"height: 80%; width: 80%;\">";
	echo "</pre>";
	echo '<center><input action="action" onclick="window.history.go(-1); return false;" type="button" value="Go Back" /><center>
	<center><h5><a href=/index.php?download='.$file.'>download</a></h5></center>
	<center><h3><a href="/">Go Home</a></h3></center>';
	return 1;
}

if (!is_image(file_exists(getcwd() . '/' . $file))) {
	if (show_source(getcwd() . '/' . $file));
	} else {
		echo "file not found";
	}

echo '
</pre>
<center><input action="action" onclick="window.history.go(-1); return false;" type="button" value="Go Back" /></center>
<BR>
<center><h5><a href=/index.php?download='.$file.'>download</a></h5></center>
<BR>
<center><h3><a href="/">Go Home</a></h3></center>
<script src="//code.justla.me/styles/prettify.js"></script>
<script>prettyPrint();</script>
</table>
</body>
</html>
';
exit;
}
?>
<head>
   <html>
   <style type="text/css">
      body { align: center; background: #222222; color: #fefefe; font-family: Tahoma, 'Lucida Grande', 'Trebuchet MS', Arial, Helvetica, Sans-Serif; font-size: 0.900em; font-color: #242424; }
      a { color: #ffa200; text-decoration: none; }
      a:hover { text-decoration: underline bold; color: #242424; }
      table { margin: auto; width: 99%; border-collapse:separate; border:solid white 1px; border-radius:9px; -moz-border-radius:9px; padding-left: 10px; padding-right: 10px; background: #242424; border: 1px solid #fff; white-space: pre-line; }
      td.main { color: #fff; background: #242424; font-size: 0.900em; padding-top: 3px; padding-bottom: 3px; width: 99%; }
      td.main a { color:#ffa200; font-size: 0.900em; width: 99%; }
      img { width: 15px; height: 15px; border: 2px solid #242424; }
      td.main a:hover { background: #242424; color: #fff; font-weight: bold; }
      td { background: #242424; color: #fff; }
      tr.main td { padding-top: 2px; padding-bottom: 2px; vertical-align: top; padding-left: 10px; padding-right: 10px; white-space: pre-line;  }
   </style>
   <script src="//cdn.rawgit.com/geekism/code-prettify/master/loader/run_prettify.js?skin=sons-of-obsidian"></script>
   <title>
      Quick Directory Listing
   </title>
</head>
<body>
<?php
function getFileExt($filename) {
   return substr(strrchr($filename,'.'),1);
}

$THIS_SCRIPT = getenv("SCRIPT_NAME");
$dir=$_GET['d'];
if ($dir=="" || $dir==false) { $dir="."; }
$absdir = realpath($dir);
if ($absdir != "") { $absdir .= "/"; }

$scriptdir = getcwd();
if ($scriptdir != "") { $scriptdir .= "/"; }
$pos = strpos($absdir,$scriptdir);

if ($pos !== 0) {
   die("<b>ERROR</b>: An invalid directory (<b>$dir</b>) was entered.");
}

$reldir = substr($absdir,strlen($scriptdir));
clearstatcache();
$handle  = opendir($absdir);
while (false !== ($filename = readdir($handle))) {
   if (is_dir($absdir."/".$filename)==true && $filename!=".") { $dirs[] = $filename; }
   if (is_dir($absdir."/".$filename)==false && $filename!=$THIS_SCRIPT) { if ($SHOW_DOT || substr($filename,0,1)!=".") { $files[] = $filename; } }
}

$at_topdir = $absdir==$scriptdir;
if (! $at_topdir) {
   $absparentdir="";
   $subdirs=explode("/",$absdir);
   for($x=1;$x<=count($subdirs)-3;$x++) { $absparentdir.="/".$subdirs[$x]; }
}

$relparentdir = substr($absparentdir,strlen($scriptdir));
if ($files) { sort($files); }
if ($dirs)  { sort($dirs); }
if ($reldir=="") { $showdir = "."; } else { $showdir = $reldir; }
echo "<br>Current Directory&nbsp;&nbsp;&nbsp;&nbsp;:   <b>$showdir</b><br/><br/>\n";
echo "<table><tr><td>";

if ($at_topdir) {
   echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
} else {
   echo "<img width='16' height='16' alt='star' src='data:image/gif;base64,R0lGODlhGwAWAMIAAP/////Mmcz//7u7u5lmMzMzMwAAAAAAACH+TlRoaXMgYXJ0IGlzIGluIHRoZSBwdWJsaWMgZG9tYWluLiBLZXZpbiBIdWdoZXMsIGtldmluaEBlaXQuY29tLCBTZXB0ZW1iZXIgMTk5NQAh+QQBAAACACwAAAAAGwAWAAADZSi63P4wykmrbSbrfJcZYAga3SeeGxeZZxuSEOu6sCOjc8rdb8AbgaCQkKEJdcJhoYhKOp+EpeAGfFoDUZisenVmPb2uVwoecMXBL+NzRqvXbfEbQ6jb7/cCOabv+/0qEjqDNQ8JADs='><a href=\"$THIS_SCRIPT?d=$relparentdir\">Up Level</a>";
}

echo "</td>\n";
echo "<td>\nFolders:\n<br><br>";
if ($dirs) {
   foreach($dirs as $name) {
      if(!in_array($name, $ignore_file_list)) {
         echo "<img width='16' height='16' alt='star' src='data:image/gif;base64,R0lGODlhFAAWAMIAAP/////Mmcz//5lmMzMzMwAAAAAAAAAAACH+TlRoaXMgYXJ0IGlzIGluIHRoZSBwdWJsaWMgZG9tYWluLiBLZXZpbiBIdWdoZXMsIGtldmluaEBlaXQuY29tLCBTZXB0ZW1iZXIgMTk5NQAh+QQBAAACACwAAAAAFAAWAAADVCi63P4wyklZufjOErrvRcR9ZKYpxUB6aokGQyzHKxyO9RoTV54PPJyPBewNSUXhcWc8soJOIjTaSVJhVphWxd3CeILUbDwmgMPmtHrNIyxM8Iw7AQA7''><a href=\"$THIS_SCRIPT?d=$reldir$name\">$name</a><br/>";
      }
   }
} else {
  echo "\n";
}

echo "<br><br></td>\n";
echo "<td>\nFiles:\n<br><br>";
if ($files) {
   foreach($files as $name) {
      $fileExt = getFileExt($name);
      if(!in_array($name, $ignore_ext_list)) {
         echo "<a href=\"$THIS_SCRIPT?download=$reldir$name\"><img width='16' height='16' alt='star' src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAACHUlEQVR42n2Tu4sTURTG584rmdm8iEYRrERQUWELa9m/II0gW0S2FSxsBEGxUQsFLSy2lQjLEsRexG20URAtV7EREatIkASZR2bu+DvjzTLGx4WPk73n+77z2DvK+vMcBgNwFhwAORiDl+Ah+FYlqyXxBrihlHKImRHLkb/doihS4nXw5DcDIxgSpeoP4pyolwopDHxiSHwKLu4Z2LZ9E9EAiFgqWxDuZlk2kt+u665zf9Xce2AFbGqt7ynER8GziphcUZvP56eqs3me95q8ZzoREx+DNYX7NcdxLmASiVjIJMIkSU5UDXzffwPPXowknDzPNxWJHUwOmrnLQyKM4/h41aBer781BoUZxWfEjyoIgvcYJBhoLssKJLIois5UDeC9gheKdsGFFqtGo7FLIuVC2roym82eW/85zWZzjXEfYFKwp1QMdhhjHwYuF99xXaf9r38TM8Yhim2D/ZjoNE0/qVardYsN93GU1gOWN2UH50h+XlriEXbwuFartTCIpGM4W4qWTnI5IpkzgoNJHZMIk/PEDyImv0r+ETFEHFM9h2eT75cPqdvt3qZCX9oSE0YRkwSSfBMriIa0by3EcGyqb08mkzulQbvd9jAYMspp2bAQMAlA+VDJ5UasTZcv8L88nU7zvY+p0+k4EDcgXoIoL03Y5b+V9vWv96UTTO+Px+PRv75Gq9frybIGYJVujplHs8tO3oEtxF+q/J8UyDX70PhePwAAAABJRU5ErkJggg=='></img></a> <img width='16' height='16' alt='star' src='data:image/gif;base64,R0lGODlhFAAVAMIAAAAAAMDAwP8A/4CAgAAAgP///0KapwAAACH5BAEAAAIALAAAAAAUABUAAANJKELcPipKUqq1gch5e8ibQnVYAW4jaVZnlJIBBrlqZTgAVxdDP+S0nemjCQpNRdHRklwsK82XMPosUJ/XZfa4neq0X+7EQS4rEgA7'></img><a href=?file=$reldir$name>$name</a><br/>";
      }
   }
} else {
   echo "\n<br><br><br>";
}
echo "<br><br></td></tr></table>\n";
if ($changelog) { 
echo '
<BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR>
<table>
      <tr><th><td align="center"><br>Change Log:</td></th></tr>
      <tr><td><b>1.0.1</b></td><td align="right">Added StyleSheet Internally.</td></tr>
      <tr><td><b>1.0.2</b></td><td align="right">Added File Name Ignoring.</td></tr>
      <tr><td><b>1.0.3</b></td><td align="right">Added File Extention Ignoring.</td></tr>
      <tr><td><b>1.0.4</b></td><td align="right">Got rid of view.php and created view.php within \'index.php\' to do a single file operation.</td></tr>
      <tr><td><b>1.0.5</b></td><td align="right">Created DataURI of folder.open.gif, folder.gif, file.gif.</td></tr>
      <tr><td><b>1.0.6</b></td><td align="right">Added Change log to index.php</td></tr>
      <tr><td><b>9.9.9</b><BR><BR><BR></td><td align="right">End of change log.<BR><BR><BR></td></tr>
</table>
';

}
?>
</body>
</html>
