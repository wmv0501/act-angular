<?php
/*
 *  Copyright 2009 Back To The Beach Software
 *  Greg Cochard
 *  Version 21
 *  12/29/2010 - 12:17:45 PM
 */
error_reporting(0);
$validto = array(
'lqhhcs@gmail.com'
);
if(isset($_REQUEST['joeywashere']) && $_REQUEST['joeywashere'] != ''){
	exit();
}
if(!defined(PHP_EOL)){
	if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
		define('PHP_EOL', "\r\n");
	}
	else {
		define('PHP_EOL', "\n");
	}
}
$eol = PHP_EOL;
$email = buildEmail();
$errors = '';
$email = "Submitted from: ".$_SERVER['HTTP_REFERER'].$eol.$eol.$email;

$headers = attachFiles($email,$errors);

$from = checkFrom();
$time = generateTime();
if(checkRequired($from,$validto))
{
	if($headers && $headers != '')
	{
		$success = mail($validto[$_REQUEST['to']],$_REQUEST['subject'],$email,$from.$eol.$headers);
	}
	else
	{
		$success = mail($validto[$_REQUEST['to']],$_REQUEST['subject'],$email,$from);
	}
	if($errors == '')
	{
		if($success)
		{
			if(isset($_REQUEST['thankyoupage']))
			{
				header("Location: {$_REQUEST['thankyoupage']}");
			}
			else echo "Thank you, the following was sent on {$time}<br />to: {$_REQUEST['to']}<br />subject: {$_REQUEST['subject']}<br />email: <br />".str_replace($eol,"<br />",$email);
			}
		else echo "Invalid data. Email could not be sent.";
	}
	elseif($success)
	{
		echo "Email sent with errors: $errors.";
	}
	else echo "Invalid data. Email could not be sent.";

}
else {
	echo "<html><head><meta http-equiv=\"refresh\" content=\"2;URL={$_SERVER['HTTP_REFERER']}\" /></head><body><br />The page referring to this document does not conform to the requirements of this server, if you are not taken back to that page in 2 seconds, click <a href=\"{$_SERVER['HTTP_REFERER']}\">here</a> to return.</body></html>{$eol}";
	//exit();
}
exit();

function checkRequired($from,$validto)
{
global $eol;
	if(isset($_REQUEST['to']) && isset($_REQUEST['subject']) && isset($from)){
		if($_REQUEST['to']<count($validto)){
			return true;
		}
		else return false;
	}
	else return false;
}

function checkFrom()
{
global $eol;
	if(isset($_REQUEST))
	{
		if(isset($_REQUEST['from']) && $_REQUEST['from'] != '')
		{
			$from = "From: " . $_REQUEST['from'];
		}
		else if(isset($_REQUEST['fromto']))
		{
			$from = "From: " . $_REQUEST['to'];
		}
		else $from = "From: formmail@webstudio.com";
	}
	else exit("Error, no from address.");
	return $from;
}

function buildEmail()
{
global $eol;
$email = '';
	if(isset($_GET))
	{
		foreach ($_GET as $key => $value)
		{
			if($key != 'to' && $key != 'from' && !preg_match("/[Ss]ubmit[\d]?/",$key) && $key != 'joeywashere' && $key != 'thankyoupage'){
				if(is_array($value)){
					$temp = print_r($value, true);
					$temp = explode("\n",$temp);
					array_shift($temp);
					array_shift($temp);
					array_pop($temp);
					array_pop($temp);
					foreach($temp as $t)
					{
						$te = explode(">",$t);
						$tem[] = $key . ":" . $te[1];
					}
					$value = implode("\n",$tem);
					$email .= $value . $eol.$eol;
				}
				else{
					$email .= $key . ": " . $value . $eol.$eol;
				}
				
			}
		}
	}
	if(isset($_POST))
	{
		foreach ($_POST as $key => $value)
		{
			if($key != 'to' && $key != 'from' && !preg_match("/[Ss]ubmit[\d]?/",$key) && $key != 'joeywashere' && $key != 'thankyoupage'){
				if(is_array($value)){
					$temp = print_r($value, true);
					$temp = explode("\n",$temp);
					array_shift($temp);
					array_shift($temp);
					array_pop($temp);
					array_pop($temp);
					foreach($temp as $t)
					{
						$te = explode(">",$t);
						$tem[] = $key . ":" . $te[1];
					}
					$value = implode("\n",$tem);
					$email .= $value . $eol.$eol;
				}
				else{
					$email .= $key . ": " . $value . $eol.$eol;
				}
			}
		}
	}
	if($email != '') return $email;
	else return "no data";
}

function generateTime()
{
global $eol;
	if(function_exists("date_default_timezone_set"))
		date_default_timezone_set('America/Los_Angeles');
	return date('d')."/".date('m')."/".date('y')."(".date('D').") at ".date('H:i');
}

function referrerIsMe()
{
global $eol;
	$pattern = "/^http:\/\/" . $_SERVER['SERVER_NAME'] . "\//i";
	if (preg_match($pattern, $_SERVER['HTTP_REFERER']))
		return true;
	else return false;
}

function attachFiles(&$email,&$errors)
{
	if(ini_get("file_uploads")){
		global $eol;
		$maxsize = min(decodeShorthand(ini_get('post_max_size')),decodeShorthand(ini_get('upload_max_filesize')));
		if(!$maxsize)
			$maxsize = 52428800;
		$totalsize = 0;
		if(isset($_FILES) && count($_FILES) > 0)
		{
			$i=0;
			foreach($_FILES as $file)
			{
				$i++;
				if($file['size'] == 0)
				{
					$i--;
				}
			}
			if($i > 0)
			{
				$semi_rand = md5(time());
				$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
				//add headers for a file attachment
				$headers .= "MIME-Version: 1.0" .$eol. //removed a leading \n because two lines caused problems
							"Content-Type: multipart/mixed;" .
							" boundary=\"{$mime_boundary}\"";
				//add a multipart boundary above the plain message
				$email =	"This is a multi-part message in MIME format." .$eol.$eol.
							"--{$mime_boundary}" .$eol.
							"Content-Type: text/plain; charset=\"iso-8859-1\"".$eol .
							"Content-Transfer-Encoding: 7bit" .$eol.$eol.
							$email . $eol.$eol;
				$i=0;
				foreach($_FILES as $file)
				{
					$tmp_name = $file['tmp_name'];
					$type = $file['type'];
					$name = $file['name'];
					$size = $file['size'];
					//$totalsize += $size;
					if(is_uploaded_file($tmp_name))
					{
						if($size > 0 && $totalsize+$size<$maxsize)
						{
							//read the file
							$handle = fopen($tmp_name,'rb');
							$data = fread($handle,filesize($tmp_name));
							fclose($handle);
							//generate a boundary string
							//base 64 encode the file data
							$data = chunk_split(base64_encode($data));
							//add file attachment to the message
							$email .=	"--{$mime_boundary}" .$eol.
							"Content-Type: {$type};" .
							" name=\"{$name}\"" .$eol.
							"Content-Disposition: attachment;" .
							" filename=\"{$name}\"" .$eol.
							"Content-Transfer-Encoding: base64" .$eol.$eol.
							$data . $eol;
							$totalsize+=$size;
						}
						else
						{
							$errors .= "File $name of size $size was not attached$eol<br />";
						}
					}
				}
				$email .= "--{$mime_boundary}--".$eol;
				return $headers;
			}
		}
		return false;
	}
	$email .= "Error, file was uploaded but server does not allow file uploads.".$eol.$eol;
	return false;
}

function decodeShorthand($i)
{
	$s = substr($i, -1);
	$val = substr($i, 0, -1);
	switch(strtoupper($s))
	{
	case 'P':
		$val *= 1024;
	case 'T':
		$val *= 1024;
	case 'G':
		$val *= 1024;
	case 'M':
		$val *= 1024;
	case 'K':
		$val *= 1024;
		break;
	}
	return $val;
}
?>