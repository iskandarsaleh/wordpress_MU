<?php
header('Content-type: text/css'); 


if( !isset( $_REQUEST[ 'dir' ] ) )
{
	exit;
}
$dir = trim( $_REQUEST[ 'dir' ] );

function buildLogoArray( $path ) {
	$logos=array();
	$d=dirname(__FILE__) . "/" . $path;
	if( file_exists( $d ) )
	{
		$dir = @opendir($d);
		if( $dir ) {	
			if( substr( $path, strlen( $path ) - 1, 1 ) != "/" ) {
				$path .= "/";
			}
			while ($f = readdir($dir)) { 
				$matches = null;
				if (eregi("(.*)\.(gif)|(jpe?g)|(png)",$f,$matches)) { 
				$logos[] = $path . $f; 
				}
			}
		}
		else { // see if $dir is a single image
			$matches = null;
			if (eregi("(.*)\.(gif)|(jpe?g)|(png)",$path,$matches)) { 
				$logos[] = $path; 
			}
		}
	}
    return $logos;
}


$logos = buildLogoArray($dir);
if( count( $logos ) == 0 )
	exit;
	
$logo = $logos[ array_rand( $logos ) ];

$width = "500";
if( isset( $_REQUEST[ 'width' ] ) && $_REQUEST[ 'width' ] != "" )
	$width = $_REQUEST[ 'width' ];
	
$height = "90";
if( isset( $_REQUEST[ 'height' ] ) && $_REQUEST[ 'height' ] != "" )
	$height = $_REQUEST[ 'height' ];

if( eregi("\.(gif)$",$logo) && function_exists( 'imagecreatefromgif' ) )
{
	$im = imagecreatefromgif(dirname(__FILE__)."/".$logo);
	$width = imagesx($im);
	$height = imagesy($im);
	imagedestroy($im);
}	
else if( eregi("\.(jpe?g)$",$logo) && function_exists( 'imagecreatefromjpeg' ) )
{
	$im = imagecreatefromjpeg(dirname(__FILE__)."/".$logo);
	$width = imagesx($im);
	$height = imagesy($im);
	imagedestroy($im);
}	
else if( eregi("\.(png)$",$logo) && function_exists( 'imagecreatefrompng' ) )
{
	$im = imagecreatefrompng(dirname(__FILE__)."/".$logo);
	$width = imagesx($im);
	$height = imagesy($im);
	imagedestroy($im);
}

// cahcing
$timestamp = filemtime( __FILE__ );
$timestamp = gmdate('D, d M Y H:i:s T', $timestamp);
$etag = md5(__FILE__ . $logo . $_REQUEST[ 'ie' ] . $width . $height ); 

if( isset( $_SERVER[ 'HTTP_IF_NONE_MATCH' ] ) 
	&& $_SERVER[ 'HTTP_IF_NONE_MATCH' ] == $etag
	&& isset( $_SERVER[ 'HTTP_IF_MODIFIED_SINCE' ] )
	&& $_SERVER[ 'HTTP_IF_MODIFIED_SINCE' ] == $timestamp ) {
	header('HTTP/1.1 304 Not Modified');
	header('Status: 304 Not Modified');
	header('ETag: ' . $etag );
	exit;	
}

header('ETag: ' . $etag );
header('Content-type: text/css'); 
header('Last-Modified: ' . $timestamp );

	
if( isset( $_REQUEST[ 'ie' ] ) )
{
$path = dirname( $_SERVER[ 'SCRIPT_NAME' ] );
$logo = $path . '/' . $logo;

?>
#header h1 a,
#header .blogtitle a {
	background-image: none;
	filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src='<?php echo $logo; ?>', sizingMethod=scale);
}
<?php
}
else
{
?>
#header h1 a,
#header .blogtitle a {
	width: <?php echo $width; ?>px;
	height: 0px;
	display: block;
	background: url('<?php echo $logo; ?>');
	overflow: hidden;
	padding-top: <?php echo $height; ?>px;
	float: left;
	cursor: pointer;
}	
<?php
}
?>