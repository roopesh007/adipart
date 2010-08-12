<?php
  
  require_once('configpage.php');

  $username=@$_POST['username'] or die ("Unknown Error!");
  $password=@$_POST['password'] or die ("Unknown Error!");
  $email=@$_POST['email'] or die ("Unknown Error!");


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
  } 

else {
 
function capture_mail($email) {
 global $ldap, $dn;
 $data_new[$LDAPDATAFIELD][]=$email;
 if (ldap_mod_add($ldap, $dn, $data_new)) {
  print "<p class=\"message\">Your Email: $email , was successfuly  stored, Thank you! <br>";
  return true;
 }
 else {
  print "<p class=\"message\">Error setting your data, please try again later";
  return false;
 }
}


function footer() {
 print <<<MSG
 
<p class=minitext> ADiPaRT Web Tools 2010</p>
</html>

MSG;

}


setCss();

headerSet();

if ($ldap)  {

  $bind = @ldap_bind($ldap,$username.$LDAPLOCALDOMAIN,$password);
  if (!($bind)) {
    @ldap_close($ldap);
    die ('<p class="message">Your password is incorrect, please try again 
          <a href=javascript:history.back()>click here</a><br>');
  }

  $filter="(sAMAccountName=$username)";
  //print $filter."<br>";

  $results = ldap_search($ldap,$LDAPDOMAIN,$filter);
  //var_dump($results);
  ldap_sort($ldap,$results,"sn");
  $info = ldap_get_entries($ldap, $results);
  //print $info["count"]." entries returned"."<br>";
  $dn=$info[0]["dn"];

  $has_email = array_key_exists($LDAPDATAFIELD,$info[0]);

  if ($has_email) 
    $stored_mail=$info[0][$LDAPDATAFIELD][0];
  else {
    if (capture_mail($email)) {
      @ldap_close($ldap);
      die ('<meta HTTP-EQUIV="REFRESH" content="3; url=http://www.google.com">
            <p class="message">Now you can close your browser<br>');
    }
    else{
      @ldap_close($ldap);
      die ('<meta HTTP-EQUIV="REFRESH" content="3; url=http://www.google.com">
            <p class="message">Error setting your data, please try again later');
    }
  }

  if ($email==$stored_mail) {
    @ldap_close($ldap);
    die ('<meta HTTP-EQUIV="REFRESH" content="3; url=http://www.google.com"> 
          <p class="message">Your email was already registered. Thank you</p>');
  }
  else {
    @ldap_close($ldap);
    die ("<p class=\"message\">Your email does not appear in our records, please contact support </p>");
  }

}
@ldap_close($ldap);

} //captcha end
footer();
?>


