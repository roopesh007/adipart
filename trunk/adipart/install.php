<?php

function validate_perms () {
 
  $ourFileName = "include/configpage.php";
  $ourFileHandle = @fopen($ourFileName, 'w+');
  if ($ourFileHandle)  {
    fclose($ourFileHandle);
    return true;
  }
  return false;
  
}

function validate_read () {
 
  $ourFileName = "include/configpage.php.sample";
  $ourFileHandle = @fopen($ourFileName, 'r');
  if ($ourFileHandle)  {
    fclose($ourFileHandle);
    return true;
  }
  return false;
  
}

function performinstall() {


}

if (($_GET['dbhost']) && ($_GET['dbname']) && ($_GET['dbuser']) && ($_GET['dbpass']) && ($_GET['ldaphost'])
    && ($_GET['ldapdomain']) && ($_GET['ldaplocal']) && ($_GET['ldapadmin']) && ($_GET['ldappass'])  
    && ($_GET['ldapfield']) && ($_GET['smtphost']) && ($_GET['email']) && ($_GET['webpage']) ) {
  print "OK";
    foreach ($_GET as $field => $value) {
    $htmlvalue[]="value=$value";
    if ($value) {
      $hasError[]="success";
      //print  $field . " has " . $value . "<br>";
    }
    else {
      $hasError[]="Error";
   //   print $field." is empty <br>";
    }
  }

  if (!(validate_perms())) {print "Error, I have no write rights on folder, fix this or install manually";}
  performinstall();
}
else { 
  foreach ($_GET as $field => $value) {
    $htmlvalue[]="value=$value";
    if ($value) {
      $hasError[]="success";
      //print  $field . " has " . $value . "<br>";
    }
    else {
      $hasError[]="Error"; 
   //   print $field." is empty <br>";
    }
  } 
}

function printForm () {
global $hasError, $_GET, $htmlvalue;

print <<< HEAD

<html>
<head>
<link rel="stylesheet" href="css/install.css" type="text/css" media="screen" />
<div id="header">
</div>
</head>
HEAD;

if (!(validate_perms())) {print '<p class="perm">Error can\'t write setup file, make sure you have write permissions in config dir';}
if (!(validate_read())) {print '<p class="warning">Error can\'t read the sample setup file</p>';}

print <<< FORM
<form>
<table>
 <tr>
  <td align=right><p class="$hasError[0]">Set your database host:</td> <td><input type=text name=dbhost $htmlvalue[0]></td>
 </tr>
 <tr>
  <td align=right><p class="$hasError[1]">Set your database name:</td><td><input type=text name=dbname $htmlvalue[1]></td>
 </tr>
 <tr>
  <td align=right><p class="$hasError[2]">Set your db user:</td><td><input type=text name=dbuser $htmlvalue[2]></td>
 </tr>
 <tr>
  <td align=right><p class="$hasError[3]">Set your db password:</td><td><input type=password name=dbpass $htmlvalue[3]></td>
 </tr>
 <tr>
  <td align=right><p class="$hasError[4]">Set your LDAP server:</td><td><input type=text name=ldaphost value="pdc.domain.local" $htmlvalue[4]></td>
 </tr>
 <tr>
  <td align=right><p class="$hasError[5]">Set your LDAP domain: </td><td><input type=text name=ldapdomain value="domain.local" $htmlvalue[5]></td>
 </tr>
 <tr>
  <td align=right><p class="$hasError[6]">Set your LDAP Search domain: </td><td><input type=text name=ldaplocal value="dc=domain,dc=local" $htmlvalue[6]></td>
 </tr>
 <tr>
  <td align=right><p class="$hasError[7]">Set your LDAP Admin User: </td><td><input type=text name=ldapadmin $htmlvalue[7]></td>
 </tr>
 <tr>
  <td align=right><p class="$hasError[8]">Set your LDAP Admin Password: </td><td><input type=password name=ldappass $htmlvalue[8]></td>
 </tr>
 <tr>
  <td align=right><p class="$hasError[9]">Set your LDAP Storage Field: </td><td><input type=text name=ldapfield $htmlvalue[9]></td>
 </tr>
 <tr>
  <td align=right><p class="$hasError[10]">Set your SMTP Server: </td><td><input type=text name=smtphost $htmlvalue[10]></td>
 </tr>
 <tr>
  <td align=right><p class="$hasError[11]">Set your Email Address: </td><td><input type=text name=email $htmlvalue[11]></td>
 </tr>
 <tr>
  <td align=right><p class="$hasError[12]">Set your WebPage hosting this app: </td><td><input type=text name=webpage $htmlvalue[12]></td>
 </tr>
</table>
<input type=submit value=proceed>
</form>
</html>
FORM;


}

printForm();
?>
