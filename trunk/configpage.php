<?php
 $UA=getenv("HTTP_USER_AGENT") or die("Error");
 if (eregi("MSIE 6", $UA))
   die ("Sorry your Browser is not supported");
 if (eregi("MSIE", $UA))
   $sucks = true;
 else
   $sucks = false;
if (!(@$_SERVER["HTTPS"])) {
    print "Your session is not secure <br>";
  }


 $dbserver="localhost";
 $dbuser="username";
 $dbpass="password";
 $dbname="ldappass";
 $LDAPHOST="pfc.mydomain.local";
 $LDAPADMIN="ldapadmin";
 $LDAPADMINPASS="ldappass";
 $LDAPDATAFIELD="mypass";
 $LDAPDOMAIN="dc=mydomain,dc=local";
 $LDAPLOCALDOMAIN="mydomain.local";
 $LOGO="monkey.jpg";
 $LOGO2="adipart.gif";
 $mailsender="information@mydomain.com";
 $sendername="ADiPaRT Web Tools";
 $website="https://mydomain.com";
 
//Debug Settings
 error_reporting(E_ALL);
 ini_set('display_errors', '1');
// End Debug Settings

 putenv('LDAPTLS_REQCERT=never') or die('Failed to setup the env');

// NON SSL

 $ldap = ldap_connect($LDAPHOST) or die ('<p class="message">Error al conectar a LDAP');

// SSL

/*
 $LDAPHOST='ldaps://mydomain.local';
 $LDAPPORT=636;
 $ldap = ldap_connect($LDAPHOST, $LDAPPORT) or die ('<p class="message">Error al conectar a LDAP');
*/

 ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
 ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

function headerSet() {
global $LOGO, $LOGO2;
print <<<HEAD
<div style="text-align:center;margin-left:auto;margin-right:auto;display:block">
<img style="margin-left:auto;margin-right:auto;display:block" src="$LOGO">
<img style="margin-left:auto;margin-right:auto;display:block" src="$LOGO2">
</div>
HEAD;


}

function setCss() {


print <<<CSS
<html>

<style>
p.message{
  font: 16px;
  font-family:Arial,Helvetica,sans-serif;
  color: red;
  text-align: center;
}


p.minitext {

  font: 9px Arial,Helvetica,sans-serif;
  font-family: Arial,Helvetica,sans-serif;
  color: #707070;
  text-align: center;

}

a.link{
  font: 16px;
  font-family:Arial,Helvetica,sans-serif;
  color: red;
  text-decoration: none;
}

a.link:hover{
  color: blue;
}

</style>
CSS;

}

function centerField() {

global $sucks;

  if ($sucks)
    print '<div style="text-align:center">';
  else
    print '<div >';

}

function putExtra(){

global $sucks;

  if ($sucks)
    print "class=\"textInput\" onmouseover=\"className='textInput_win'\"  onmouseout=\"className='textInput'\" ";
  else
    print "class=\"textInput\"";

}



function genPassword($pattern,$chardef = array(
    'v' => 'aeiouy',
    'c' => 'bcdfghjklmnpqrstvwxz',
    'V' => 'AEIOUY',
    'C' => 'BCDFGHIJKLMNPQRSTVWXZ',
    'w' => 'aeiouyAEIOUY',
    'd' => 'bcdfghjklmnpqrstvwxzBCDFGHIJKLMNPQRSTVWXZ',
    'a' => 'abcdefghijklmnopqrstuvwxyz',
    'A' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
    'b' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
    '#' => '!@#$%^&*(){}[]-=\_+|<>?,./',
    '0' => '1234567890',
    'y' => 'abcdefghijklmnopqrstuvwxyz1234567890',
    'Y' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890',
    'x' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890',
    'z' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*(){}[]-=\_+|<>?,./1234567890'
   ))
{
    $output = "";
    $chardef_keys = array_keys($chardef);
    for($i=0;$i<strlen($pattern);$i++) {
        if(in_array(substr($pattern,$i,1),$chardef_keys)) {
            $output .= substr($chardef[substr($pattern,$i,1)],rand(0,strlen($chardef[substr($pattern,$i,1)])-1),1);
        }
    }
    return $output;
}

function footer() {
 print <<<MSG

<p class="minitext"> AdiPaRT Web Tools 2010 </p>

MSG;

}


?>
