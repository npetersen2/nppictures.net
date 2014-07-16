<?php

require 'CONFIG_VARS.php';

/*
 * <link rel="stylesheet" type="text/css" media="screen, print, projection" href="/css/compressed.css.php" />
 */
 
$cssFiles = array(
  'styles.fonts.css',
  'styles.css',
  'fancybox/styles.fancybox.css'
);

$buffer = "";
foreach ($cssFiles as $cssFile) {
  $buffer .= file_get_contents($cssFile);
}
 
// Remove comments
$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
 
// Remove space after colons
$buffer = str_replace(': ', ':', $buffer);
 
// Remove whitespace
$buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
 
// Enable GZip encoding.
ob_start("ob_gzhandler");
 
// Enable caching
header('Cache-Control: public');
 
// Expire in 1 year
if ($CACHE_ON) {
  // expires in one year
  header('Expires: ' . gmdate('D, d M Y H:i:s', time() + (60 * 60 * 24 * 30 * 12)) . ' GMT');
} else {
  // expires immediately
  header('Expires: ' . gmdate('D, d M Y H:i:s', time()) . ' GMT');
}

// Set the correct MIME type, because Apache won't set it for us
header("Content-type: text/css");
 
// Write everything out
echo($buffer);
?>