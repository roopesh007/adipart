<?php
require_once('include/configpage.php');

?>


<html>


<head>
<link rel="stylesheet" href="css/jquery.notifyBar.css" type="text/css" media="screen" />

<script src="jquery.min.js" type="text/javascript" charset="utf-8">
</script>

<script type="text/javascript" src="jquery.notifyBar.js"></script>

<link rel="stylesheet" href="css/adipart.css" type="text/css" media="screen" />

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
      require_once('include/recaptchalib.php');
      $publickey = $recaptcha_pub; // you got this from the signup page
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

