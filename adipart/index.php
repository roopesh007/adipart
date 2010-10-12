<?php

require_once("include/configpage.php");

print '<head><link rel="stylesheet" href="adipart.css" type="text/css" media="screen" /></head>';
headerSet();
setCss();

print <<<LOGIN

<div align=center>
<table>
 <tr>
  <td><img src="images/contact-new.png"></td>
  <td width="100"></td>
  <td><img src="images/recover-pass.png"></td>
 </tr>
 <tr>
  <td><center><a class="link" href="changepass.php">Register Data</td>
  <td></td>
  <td><center><a class="link" href="genpass.php">Recover Password</td>
 </tr>
</table>


LOGIN;






footer();
?>
