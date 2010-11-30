<?php

function debug ($object, $label = '')
{
	Custom_Controller_Plugin_Debug::debug($object, $label);
}

function logger($message, $type = Zend_Log::INFO)
{
	Custom_Controller_Plugin_Debug::logger($message, $type);
}

function array_key_exists_recursive($needle,$haystack)
{
	foreach($haystack as $key=>$val)
	{
		if(is_array($val))
		{
			if ( array_key_exists_recursive($needle,$val))
			{
				return TRUE;
			}
		}
   		elseif ($val == $needle)
   		{
   			return TRUE;
   		}
	}
	return FALSE;
}

function is_multidimensional_array($a)
{
    $rv = array_filter($a,'is_array');
    if (count($rv)>0)
    {
    	return TRUE;
    }
    else
    {
    	return FALSE;
    }
}

function pr($val)
{
	$debug_backtrace = debug_backtrace();

	echo 'Debug called from ' . $debug_backtrace[1]['file'] . ' (line ' . $debug_backtrace[1]['line'] . ')';
	echo "< pre>";
	print_r($val);
	echo "< /pre>";
}

function debug_redirect($url)
{
	$debug_backtrace = debug_backtrace();
	$file = '< strong> ' . $debug_backtrace[0]['file'] . '< /strong>';
	$line = '< strong>' . $debug_backtrace[0]['line'] . '< /strong>';

	echo '< div style="padding:15px 30px; margin:0px; text-align:center; font-size:16px; background-color:#ccc; ">Should redirect to: < a href="'. $url . '">' . $url . '< /a>< /div>';
	echo '< div style="padding:15px 30px; margin:0px; text-align:center; font-size:16px; background-color:#ccc; ">Called from ' . $file . ', line ' . $line . '< /div>';

	echo '< div style="background-color:yellow; border:1px solid red; padding:5px 10px; margin:20px 0px">';
	echo '< pre>COOKIES:';
	print_r($_COOKIES);
	echo '< /pre>';

	echo '< pre>SESSION:';
	print_r($_SESSION);
	echo '< /pre>';

	echo '< pre>SERVER:';
	print_r($_SERVER);
	echo '< /pre>';

	echo '< /div>';
	exit();
}
?>