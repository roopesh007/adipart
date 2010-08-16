<?php

require_once("configpage.php");

print '<head><link rel="stylesheet" href="adipart.css" type="text/css" media="screen" /></head>';
headerSet();
setCss();

print <<<LOGIN

<div align=center>
<table>
 <tr>
  <td><img src="contact-new.png"></td>
  <td width="100"></td>
  <td><img src="recover-pass.png"></td>
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
