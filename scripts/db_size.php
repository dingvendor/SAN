<html><head><title>mysql database size</title></head><body> 
<h1>mysql database size</h1> 
<?php  
function file_size_info($filesize) { 
 $bytes = array('KB', 'KB', 'MB', 'GB', 'TB'); # values are always displayed  
 if ($filesize < 1024) $filesize = 1; # in at least kilobytes. 
 for ($i = 0; $filesize > 1024; $i++) $filesize /= 1024; 
 $file_size_info['size'] = ceil($filesize); 
 $file_size_info['type'] = $bytes[$i]; 
 return $file_size_info; 
} 
$db_server = 'localhost'; 
$db_user = 'bfms2'; 
$db_pwd = 'bfms2'; 
$db_name = 'bfms2'; 
$db_link = @mysql_connect($db_server, $db_user, $db_pwd) 
 or exit('Could not connect: ' . mysql_error()); 
$db = @mysql_select_db($db_name, $db_link) 
 or exit('Could not select database: ' . mysql_error()); 
// Calculate DB size by adding table size + index size: 
$rows = mysql_query("SHOW TABLE STATUS"); 
$dbsize = 0; 
while ($row = mysql_fetch_array($rows)) { 
 $dbsize += $row['Data_length'] + $row['Index_length']; 
} 
print "database size is: $dbsize bytes<br />"; 
print 'or<br />'; 
$dbsize = file_size_info($dbsize); 
print "database size is: {$dbsize['size']} {$dbsize['type']}"; 
?> 
</body></html>
