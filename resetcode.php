<?php

function change_pass($username) {

  global $LDAPHOST, $LDAPPORT, $ldap, $LDAPADMIN, $LDAPADMINPASS, $LDAPDATAFIELD;
  if ($ldap)  {
    $bind = @ldap_bind($ldap,$LDAPADMIN,$LDAPADMINPASS);
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
    $stored_mail=$info[0][$LDAPDATAFIELD][0] or die ("We could not get your info, please contact Support!");
    $newPassw=genPassword("xxx0yY0yY");
    $mailPass=$newPassw;
    $newPassword="\"$newPassw\"";
    $len = strlen($newPassword);
    for ($i = 0; $i < $len; $i++) 
      $newPassw .= "{$newPassword{$i}}\000";
    $newPassword = $newPassw;
    print $newPassword;
/*    $data_new["unicodePwd"][]=$newPassword;
    if (ldap_mod_replace($ldap, $dn, $data_new))    
      return array(true,$stored_mail,$mailPass);
    else
      return array (false,0,0);*/
    return array(true,$stored_mail,$mailPass);
  } 
  else 
    return array(false,0,0);

// function 
}


function verify_data($hash) {

 global $dbserver,$dbuser,$dbpass, $dbname ;
 $con=mysql_connect($dbserver,$dbuser,$dbpass) or die ("Can't connect to DB");
 mysql_select_db($dbname) or die ("Can't open db");
 $querysql="SELECT status from REQUESTS WHERE code='$hash'";
 $result=mysql_query($querysql) or die (mysql_error());
 $row=mysql_fetch_array($result);
 $status=$row['status'];
 print $status;
 return $status;

}


function read_data($hash) {

 global $dbserver,$dbuser,$dbpass, $dbname ;
 $con=mysql_connect($dbserver,$dbuser,$dbpass) or die ("Can't connect to DB");
 mysql_select_db($dbname) or die ("Can't open db");
 $querysql="SELECT * from REQUESTS WHERE code='$hash'";
 $result=mysql_query($querysql) or die (mysql_error());
 $row=mysql_fetch_array($result);
 $id=$row['id'];
 $username=$row['username'];
 $status=$row['status'];
 $now=$row['req_time'];
 $code=$row['code'];
 $gencode=md5("$id+$username+$now+$status");
 print "$id+$username+$now+$status";
 print $gencode;
 if ($gencode == $hash)
  return $username;
 else
  return "Error";

}


function gen_pass_mail($hash, $username) {

  global $dbserver,$dbuser,$dbpass, $dbname ;
  $con=mysql_connect($dbserver,$dbuser,$dbpass) or die ("Can't connect to DB");
  mysql_select_db($dbname) or die ("Can't open db");
  $result=change_pass($username);
  if ($result[0]) {
    $updatesql="UPDATE REQUESTS SET status='generated' where code='$hash'";
    mysql_query($updatesql) or die (mysql_error());
    send_link($result[1], $result[2]);
    return true;
  }
  else {
    mysql_close();
    die ('<p class="message>Error, I could not finish my work, please contact Support"');
  }

}


function send_link($stored_mail, $password) {

 if (enviarEmail("AdiPaRT Web Tools", $mailsender, $stored_mail, "Please confirm", "Your new password is: $password", $tipoEmail="text/plain" ) )
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

  require_once('configpage.php');
  require_once('emaillib.php');

  $code=$_GET['code'] or die ("Error");
  check_code($code) or die ("Ooops");
  if (verify_data($code) == "pending" ) {
    $username=read_data($code);
    print $username;
    if ($username != "Error") {
      if (gen_pass_mail($code, $username))
        print '<p class="message">OK';
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
