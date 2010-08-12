<?php
require_once('configpage.php');
function footer() {
 print <<<MSG

<p class=minitext> AdiPaRT Web Tools 2010</p>

MSG;

}

?>


<html>


<head>
<link rel="stylesheet" href="jquery.notifyBar.css" type="text/css" media="screen" />

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript" charset="utf-8">
</script>

<script type="text/javascript" src="jquery.notifyBar.js"></script>

<style type="text/css">

fieldset {
  width: 430px;
  position: relative;
  margin-left:auto;
  margin-right:auto;
  background: #F0F0F0;
  border-color: #c0c0c0;
}

p.sansserif{
  font: 16px;
  font-family:Arial,Helvetica,sans-serif;

}

.textInput,textarea {
  width: 250px;
  font:bold 16px/16px Arial,Helvetica,sans-serif;
  font-family: Arial,Helvetica,sans-serif;
  background-color: #FFFFFF;
  border: 1px solid #000;
  border-color: #c0c0c0;
}

.textInput:hover {
    border: 1px solid #000;
    background: #BDEDFF;
}

.textInput_win {
    width: 250px;
    font:bold 16px/16px Arial,Helvetica,sans-serif;
    font-family: Arial,Helvetica,sans-serif;
    background-color: #FFFFFF;
    border: 1px solid #000;
    background: #BDEDFF;
}

.inputHighlighted {
  width: 250px;
  font:bold 16px/16px Arial,Helvetica,sans-serif;
  font-family: Arial,Helvetica,sans-serif;
  background-color: #FDD017;
  color: #000;
  border: 1px solid #000;
}


 .recaptchatable .recaptcha_image_cell, #recaptcha_table {
   background-color:#00A1E5 !important; //reCaptcha widget background color
 }
 
 #recaptcha_table {
   border-color: #033D55 !important; //reCaptcha widget border color
 }
 
 #recaptcha_response_field {
   border-color: #033D55 !important; //Text input field border color
   background-color: #FFF !important; //Text input field background color
 }

p.minitext {

  font: 9px Arial,Helvetica,sans-serif;
  font-family: Arial,Helvetica,sans-serif;
  color: #707070;
  text-align:center;

}

.custom {
  font-size:20px;
  font-family: "Times New Roman", Times, serif;
  text-transform:uppercase;
  background:#fff url(jq-test-pattern.gif) repeat-x top center;
}


</style>

<script>
var RecaptchaOptions = {
   theme : 'clean'
};

</script>

<script src="adipart.js" type="text/javascript">

</script>

<script type="text/javascript">

function badField(elem) {
  <?php global $sucks;
  if (!($sucks))
    print "elem.setAttribute(\"class\", \"inputHighlighted\");";
  else 
     print "elem.setAttribute(\"className\", \"inputHighlighted\");";
  ?>
  elem.setAttribute("aria-invalid","true");
}



function resetForms(elem) {
  <?php global $sucks;
  if (!($sucks))
    print 'elem.setAttribute("class", "textInput");';
  else
    print 'elem.setAttribute("className", "textInput");';
  ?>
   

}

</script>


</head>

<?php
headerSet()
?>
<br>
<form name="data" action="passreset.php" method="post" onSubmit="return checkForm()">

<?php 
centerField(); 
?>
<fieldset class="fieldset">
 <table>
  <tr>
    <td align=right><p class="sansserif">Username:</td>
    <td> <input <?php putExtra(); ?> type="text" name="username" onFocus="javascript:data.boton.disabled=false;"></td>
  </tr>
  <tr>
    <td align=right><p class="sansserif">Password: </td>
    <td><input <?php putExtra(); ?> type="password" name="password" onFocus="javascript:data.boton.disabled=false;"></td>
  </tr>
  <tr>
    <td align=right><p class="sansserif">Personal Email:</td>
    <td><input <?php putExtra(); ?> type="text" name="email" onFocus="javascript:data.boton.disabled=false;"></td>
  </tr>
  <tr>
    <td align=right><p class="sansserif">Confirm Email: </td>
    <td><input <?php putExtra(); ?> type="text" name="confirmemail" onFocus="javascript:data.boton.disabled=false;"></td>
  </tr>
</table>
<p class="minitext"> Please fill out the following field for human verification </p>
<?php
      require_once('recaptchalib.php');
      $publickey = "6LclB7wSAAAAAESgWAGrQMwfsq8bLP0l5DTPfOqq"; // you got this from the signup page
      echo recaptcha_get_html($publickey)."<br>";
    ?>

<input style="float:right" type="submit" value="Submit" name="boton"> <br>

</form >
</fieldset>
</div>
<?php
footer();
?>
</html>

