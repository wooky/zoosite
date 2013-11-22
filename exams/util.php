<?php //Parse a PDF filename in the form: UMPL666-F2017-M3.pdf
function parseFilename($str)
{
	$arr = explode("-",$str);
	if(count($arr) < 3 || strlen($arr[0]) != 7 || strlen($arr[1]) < 4 || stlen($arr[1]) > 5 || strlen($arr[2]) < 1)
		return null;
	$course = array();
	$course['name'] = strtoupper($arr[0]);
	
	//Parse exam year
	$course['year'] = (strlen($arr[1]) == 4) ? $arr[1] : substr($arr[1],1);
	if(!is_numeric($course['year']))
		return null;
	$course['session'] = (strlen($arr[1]) == 4) ? null : $arr[1][0];
	
	//Parse exam type
	$course['type'] = $arr[2][0];
	switch($course['type'])
	{
		case 'q':
		case 't':
		case 'm':
		case 'x':
			break;
		default:
			return null;
	}
}
