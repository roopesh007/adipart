<?php

require_once("include/configpage.php");

?>
<html>


<head>
<link rel="stylesheet" href="adipart.css" type="text/css" media="screen" />

<link rel="stylesheet" href="jquery.notifyBar.css" type="text/css" media="screen" />

<script src="jquery.min.js" type="text/javascript" charset="utf-8">
</script> 

  <script type="text/javascript" src="jquery.notifyBar.js"></script>

<script>
var RecaptchaOptions = {
   theme : 'clean'
};
</script>

<script src="adipart.js" type="text/javascript" language="javascript">
</script>

<script type="text/javascript">

function badField(elem) {
  <?php global $sucks;
  if (!($sucks))
    print "elem.setAttribute(\"class\", \"inputHighlighted\");\n";
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
headerSet();
?>
<br>
<?php
centerField();
?>
<fieldset class="fieldset">
<form name="data" action="gencode.php" method="post" onSubmit="return checkgenForm()">
 <table>
  <tr>
    <td align=right><p class="sansserif">Username:</td>
    <td> <input  <?php putExtra(); ?> type="text" name="username"  onFocus="javascript:data.button.disabled=false;"></td>
  </tr>
</table>
<p class="minitext"> Please fill out the following field for human verification </p>
<?php
      require_once('include/recaptchalib.php');
      $publickey = recaptcha_pub; // you got this from the signup page
      echo recaptcha_get_html($publickey)."<br>";
    ?>

<input style="float:right" type="submit" value="Change" name=button> <br>
</form>
</fieldset>
</div>
<?php

footer();

?>
</html>

