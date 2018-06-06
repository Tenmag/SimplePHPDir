<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<title><?php echo $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']); ?></title>
</head>
<body>
<?php
function formatBytes($bytes, $precision = 2)
{
 $units = array('B', 'KB', 'MB', 'GB', 'TB');
 $bytes = max($bytes, 0);
 $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
 $pow = min($pow, count($units) - 1);
 $bytes /= pow(1024, $pow);
 return round($bytes, $precision) . '&nbsp;' . $units[$pow];
}

$files = glob("*",GLOB_MARK);
usort($files, function ($a, $b) {
 $aIsDir = is_dir($a);
 $bIsDir = is_dir($b);
 if ($aIsDir === $bIsDir) return strnatcasecmp($a, $b);
 elseif ($aIsDir && !$bIsDir) return -1;
 elseif (!$aIsDir && $bIsDir) return 1;
});

foreach ($files as $filename) {
 if($filename !== "." && $filename !== ".." && !fnmatch("index.*", $filename)) {
  $nextline = "<a href='$filename'>$filename</a>";
  if (is_dir($filename)) {
   $nextline = "<span style='background-color:#eee'>" . $nextline . "</span>";
  } else {
   $nextline = "<span>" . $nextline . "&emsp;&rarr;&emsp;" . formatBytes(filesize($filename),0) . "</span>";
  }
  echo $nextline . "<br/>\r";
 }
}

?>
</body>
</html>
