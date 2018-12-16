<?php
//support for live commenting
header('Content-Type: text/plain');
switch($_GET['function']){
 	case 'getAllCommentCount':
 		echo getAllCommentCount();
		break;
 	case 'getLastComment':
		break;		
	default:
}
die();
?>
