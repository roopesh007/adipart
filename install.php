<?php

print <<< FORM

<html>

<form>
<table>
 <tr>
  <td align=right><p>Set your database host:</td> <td><input type=text name=dbhost></td>
 </tr>
 <tr>
  <td align=right><p>Set your database name:</td><td><input type=text name=dbname></td>
 </tr>
 <tr>
  <td align=right><p>Set your db user:</td><td><input type=text name=dbuser></td>
 </tr>
 <tr>
  <td align=right><p>Set your db password:</td><td><input type=password name=dbpass></td>
 </tr>
 <tr>
  <td align=right><p>Set your LDAP server:</td><td><input type=text name=ldaphost value="pdc.domain.local"></td>
 </tr>
 <tr>
  <td align=right><p>Set your LDAP domain: </td><td><input type=text name=ldapdomain value="domain.local"></td>
 </tr>
 <tr>
  <td align=right><p>Set your LDAP Search domain: </td><td><input type=text name=ldaplocal value="dc=domain,dc=local"></td>
 </tr>
 <tr>
  <td align=right><p>Set your LDAP Admin User: </td><td><input type=text name=ldapadmin></td>
 </tr>
 <tr>
  <td align=right><p>Set your LDAP Admin Password: </td><td><input type=password name=ldappass></td>
 </tr>
 <tr>
  <td align=right><p>Set your LDAP Storage Field: </td><td><input type=text name=ldapfield value="wwwhomepage"></td>
 </tr>
 <tr>
  <td align=right><p>Set your SMTP Server: </td><td><input type=text name=smtphost></td>
 </tr>
 <tr>
  <td align=right><p>Set your Email Address: </td><td><input type=text name=email></td>
 </tr>
 <tr>
  <td align=right><p>Set your WebPage hosting this app: </td><td><input type=text name=webpage></td>
 </tr>
</table>
<input type=submit value=proceed>
</form>
</html>



FORM;
?>
