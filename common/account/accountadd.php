<fieldset class="field_box">
<form action="" method="post" name="register">
<table width="757">
  <tr>
    <td align="right">Account Name :</td>
    <td><label for="username"></label>
      <input type="text" name="username" id="username" /></td>
  </tr>
  <tr>
    <td align="right">Password :</td>
    <td><label for="password"></label>
      <input type="text" name="password" id="password" /></td>
  </tr>
  <tr>
    <td align="right">Authority :</td>
    <td><label for="auth"></label>
      <select name="auth" id="auth">
        <option value="1">Normal</option>
        <option value="6">GM</option>
        <option value="7">Admin</option>
      </select></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td><input type="submit" name="addaccount" id="register" value="Register Account" /></td>
  </tr>
</table>
</form>
<div class="animated fadeIn"><center>
<?php
if($_POST['addaccount'])
{
	// Chk User
	$chk_sql = $sql->prepare("SELECT * FROM C9Unity.Auth.TblAccount WHERE cAccId = :p1");
	$chk_sql->BindParam(":p1",$_POST['username']);
	$chk_sql->execute();
	$chk = $chk_sql->fetch(PDO::FETCH_ASSOC);
	if(trim($_POST['username']) == "" || $_POST['password'] == "")
	{
		echo "<font color='#FF0000'>Please fill all field.</font>";
	}
	else if($chk['cAccId'] == $_POST['username'])
	{
		echo "<font color='#FF0000'>Username in use.</font>";
	}
	else
	{
		$register = $sql->prepare("EXEC C9Unity.Admin.UspAddAccount :p1,:p2,:p3,:p4");
		$register->BindParam(":p1",$_POST['username']);
		$register->BindParam(":p2",$_POST['password']);
		$register->BindParam(":p3",$_POST['auth']);
		$register->BindParam(":p4",$ip);
		$register->execute();
		echo "<font color='#006600'>Register Complete.</font>";
	}
}
?></center>
</div>
</fieldset>