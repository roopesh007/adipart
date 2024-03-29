<?php

function change_pass($username) {

  global $LDAPHOST, $LDAPPORT, $ldap, $LDAPADMIN, $LDAPADMINPASS, $LDAPDATAFIELD, $LDAPLOCALDOMAIN, $LDAPDOMAIN;
  if ($ldap)  {
    $bind = @ldap_bind($ldap,$LDAPADMIN."@".$LDAPLOCALDOMAIN,$LDAPADMINPASS);
    if (!($bind)) {
      @ldap_close($ldap);
      die ('<p class="message">Your password is incorrect, please try again 
            <a href=javascript:history.back()>click here</a><br>');
    }
    $filter="(sAMAccountName=$username)";
    $results = ldap_search($ldap,$LDAPDOMAIN,$filter);
    ldap_sort($ldap,$results,"sn");
    $info = ldap_get_entries($ldap, $results);
    if ($info['count'] < 1) {
      @ldap_close($ldap);
      die ('<p class="message">Error occurred, please verify your user , <a href="javascript:history.back()">Go Back</a>');
    }
    $dn=$info[0]["dn"];
    $stored_mail=$info[0][$LDAPDATAFIELD][0] or die ('<p class="message">We could not get your info, please contact Support!');
    $newPassw=genPassword("xxx0yY0yY");
    $mailPass=$newPassw;
    $newPassword="\"$newPassw\"";
    $len = strlen($newPassword);
    $newPass="";
    for ($i = 0; $i < $len; $i++) 
      $newPass .= "{$newPassword{$i}}\000";
    $newPassword = $newPass;
    $data_new["unicodePwd"][]=$newPassword;
    if (ldap_mod_replace($ldap, $dn, $data_new))    
      return array(true,$stored_mail,$mailPass);
    else
      return array (false,100,100);
    return array(true,$stored_mail,$mailPass);
  } 
  else 
    return array(false,0,0);

// function 
}


function verify_data($hash) {

 global $dbserver,$dbuser,$dbpass, $dbname ;
 $con=mysql_connect($dbserver,$dbuser,$dbpass) or die ('<p class="message">Can\'t connect to DB');
 mysql_select_db($dbname) or die ('<p class="message">Can\'t open db');
 $querysql="SELECT status from REQUESTS WHERE code='$hash'";
 $result=mysql_query($querysql) or die (mysql_error());
 $row=mysql_fetch_array($result);
 $status=$row['status'];
 return $status;

}


function read_data($hash) {

 global $dbserver,$dbuser,$dbpass, $dbname ;
 $con=mysql_connect($dbserver,$dbuser,$dbpass) or die ('<p class="message">Can\'t connect to DB');
 mysql_select_db($dbname) or die ('<p class="message">Can\'t open db');
 $querysql="SELECT * from REQUESTS WHERE code='$hash'";
 $result=mysql_query($querysql) or die (mysql_error());
 $row=mysql_fetch_array($result);
 $id=$row['id'];
 $username=$row['username'];
 $status=$row['status'];
 $now=$row['req_time'];
 $code=$row['code'];
 $gencode=md5("$id+$username+$now+$status");
 if ($gencode == $hash)
  return $username;
 else
  return "Error";

}


function gen_pass_mail($hash, $username) {

  global $dbserver,$dbuser,$dbpass, $dbname ;
  $con=mysql_connect($dbserver,$dbuser,$dbpass) or die ('<p class="message">Can\'t connect to DB');
  mysql_select_db($dbname) or die ('<p class="message">Can\'t open db');
  $result=change_pass($username);
  if ($result[0]) {
    $updatesql="UPDATE REQUESTS SET status='generated' where code='$hash'";
    mysql_query($updatesql) or die (mysql_error());
    send_link($result[1], $result[2]);
    return true;
  }
  else {
    mysql_close();
    die ('<p class="message">Yo Mama!!,  I could not finish my work, 
          please <a class="link" href="javascript:location.reload()">retry</a> or
          if the error persists, please contact Support, Error code:'.$result[1]);

  }

}


function send_link($stored_mail, $password) {

 $message="
           Your new password is: $password

           This change may take up to 5 minutes, please be patient

           Thanks";

 global $mailsender, $sendername;
 if (enviarEmail($sendername, $mailsender, $stored_mail, $message, $tipoEmail="text/plain" ) )
  return true;
 else
  return false;
  
 

}


function check_code($hash) {

  if (strlen($hash) == 32) {
    $regexpstr = "/(^[a-zA-Z0-9]+$)/";
    if (preg_match_all($regexpstr,$hash,$matches))
      return true;
    else
      return false;
  } else return false; 
}






if (count ($_GET) == 1) { 

  require_once('include/configpage.php');
  require_once('include/emaillib.php');
  setCss();
  headerSet();
  $code=$_GET['code'] or die ('<p class="message">Error');
  check_code($code) or die ('<p class="message">Ooops');
  if (verify_data($code) == "pending" ) {
    $username=read_data($code);
    //print $username;
    if ($username != "Error") {
      if (gen_pass_mail($code, $username))
        print '<p class="message">Your password has been changed and sent, please check your email';
    }
    else die ('<p class="message">Error, can\'t get your email, please contact the Administrator');
  }
  else
    die ('<p class="message">Error, invalid code, please contact the Administrator');
      
    
}
  else
    die('<p class="message">Error, invalid parameters, please contact the Administrator');
mysql_close();

?>
