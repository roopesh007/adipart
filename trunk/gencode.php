<?php

  require_once('configpage.php');
  $username=@$_POST['username'] or die("Error Unkown");
  require_once('recaptchalib.php');
  $privatekey = "6LclB7wSAAAAAKUtbYdzV6CzNq3jOvAgZMitsYHc";
  $resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);

  //if (!$resp->is_valid) {
  if ($resp->is_valid) { //for disable chaptcha
    // What happens when the CAPTCHA was entered incorrectly
    print "<a href=javascript:history.back()>go back</a><br>";
    die ("The reCAPTCHA wasn't entered correctly. Go back and try it again." .
         "(reCAPTCHA said: " . $resp->error . ")");
      check_pending($username);
  } 

else {
 



function send_link($username,$stored_mail, $code) {

global $mailsender, $website;

 if (enviarEmail("ADiPaRT Web Tools", $mailsender, $stored_mail, "Please confirm", "Click Here $website/resetcode.php?code=$code", $tipoEmail="text/plain" ) )
  return true;
 else
  return false;
  
 

}


function get_lastid() {

 $queryid="SELECT max(id) FROM REQUESTS";
 $result=mysql_query($queryid) or die (mysql_error());
 $row = mysql_fetch_array($result);
 $id=$row['max(id)'];
// mysql_close($con);
 return $id;

}


function check_pending($username) {

 global $dbserver,$dbuser,$dbpass, $dbname ;

 $con=mysql_connect($dbserver,$dbuser,$dbpass) or die ("Can't connect to DB");
 mysql_select_db($dbname) or die ("Can't open db");
 $queryid="SELECT count(id) FROM REQUESTS WHERE username='$username' and status='pending'";
 $result=mysql_query($queryid) or die (mysql_error());
 $row = mysql_fetch_array($result);
 $pending=$row['count(id)'];
 return $pending;


}


function generate_code($username) {
 
 global $dbserver,$dbuser,$dbpass, $dbname ;
 
 $con=mysql_connect($dbserver,$dbuser,$dbpass) or die ("Can't connect to DB");
 mysql_select_db($dbname) or die ("Can't open db");
 $id=get_lastid()+1;
 $now=date("Y-m-d H:i:s");
 $status="pending";
 $code=md5("$id+$username+$now+$status");
 $insertsql="INSERT INTO REQUESTS VALUES ('', '$username' , '$now' ,'$status', '$code')";
 mysql_query($insertsql) or die (mysql_error());
 mysql_close($con);
 return $code; 
 
}

require_once('emaillib.php');
require_once('configpage.php');

setCss();
headerSet();

if ($ldap)  {
  $bind = @ldap_bind($ldap,$LDAPADMIN."@".$LDAPLOCALDOMAIN,$LDAPADMINPASS);
  if (!($bind)) {
    @ldap_close($ldap);
    die ('<p class="message">Your password is incorrect, please try again 
          <a href=javascript:history.back()>click here</a><br>');
  }

  $filter="(sAMAccountName=$username)";
  $results =  @ldap_search($ldap,$LDAPDOMAIN,$filter);
  ldap_sort($ldap,$results,"sn");
  $info = ldap_get_entries($ldap, $results);
  if ($info['count'] < 1) {
    @ldap_close($ldap);
    die ('<p class="message">Error occurred, please verify your user , <a href="javascript:history.back()">Go Back</a>');
  }
  $dn=$info[0]["dn"];

  $has_email = array_key_exists('wwwhomepage',$info[0]);

  if ($has_email) { 
    $stored_mail=$info[0]['wwwhomepage'][0];
    if (check_pending($username) == 0) { 
      $code=generate_code($username);
      send_link($username,$stored_mail,$code);
      print '<p class="message">Please confirm the email we sent to reset the password';
    }
    else
       print '<p class="message"> Error, please verify your email first.';

  }
  else {
      @ldap_close($ldap);
      die ('<meta HTTP-EQUIV="REFRESH" content="3; url=http://www.google.com">
            <p class="message">You have not completed the registration procedure, please contact Support.<br>');
    }
  

  

}
@ldap_close($ldap);

} //captcha end
footer ();
?>


