<fieldset class="field_box">
<form name="accountsearch" method="post" action="index.php?page=accountmanage">
  <table width="500">
    <tr>
      <td width="136" align="right">Account Name :</td>
      <td width="127"><label for="account"></label>
      <input type="text" name="account" id="account" autocomplete="off"></td>
      <td width="221"><input type="submit" class="btn_search" name="submit" id="submit" value=" " /></td>
    </tr>
  </table>
</form>
</fieldset><p><div class="animated fadeIn"><fieldset class="field_box">
<?php 
$a = $_GET['id'];
// Account Information
$account_sql = $sql->prepare("SELECT * FROM C9Unity.Auth.TblAccount WHERE cAccNo = :p1");
$account_sql->BindParam(":p1",$a);
$account_sql->execute();
$account = $account_sql->fetch(PDO::FETCH_ASSOC);
?>
<form action="" method="post" name="editaccount"><table width="757">
  <tr>
    <td width="343" align="right">Account Name :</td>
    <td width="402"><label for="username"></label>
      <input type="text" name="username" id="username" value="<?php echo $account['cAccId']; ?>"></td>
  </tr>
  <tr>
    <td align="right">Account No. :</td>
    <td><?php echo $account['cAccNo']; ?></td>
  </tr>
  <tr>
    <td align="right">Account Password :</td>
    <td><label for="password"></label>
      <input type="text" name="password" id="password" value="<?php echo $account['cPassword']; ?>"></td>
  </tr>
  <tr>
    <td align="right">Register Date :</td>
    <td><?php echo $account['cDateReg']; ?></td>
  </tr>
  <tr>
    <td align="right">Account Authority :</td>
    <td><label for="auth"></label>
      <select name="auth" id="auth">
        <option value="0"<?php if($account['cAuthLevel'] == 0){ echo 'selected="selected"'; }?>>Lock</option>
        <option value="1"<?php if($account['cAuthLevel'] == 1){ echo 'selected="selected"'; }?>>Normal</option>
        <option value="6"<?php if($account['cAuthLevel'] == 6){ echo 'selected="selected"'; }?>>GM</option>
        <option value="7"<?php if($account['cAuthLevel'] == 7){ echo 'selected="selected"'; }?>>Admin</option>
      </select></td>
  </tr>
  <tr>
    <td align="right">Detected Hack :</td>
    <td><select name="lock">
      <option value="0"<?php if($account['cDetectedHack'] == 0){ echo 'selected="selected"'; }?>>Unlock</option>
      <option value="1"<?php if($account['cDetectedHack'] == 1){ echo 'selected="selected"'; }?>>Lock</option>
    </select></td>
  </tr>
  <tr>
    <td align="right">Login Status :</td>
    <td><?php
    if($account['cCertifiedKey'] != 0)
	{
		echo '<font color="#009900">Online</font>';
	}
	else
	{
		echo '<font color="#FF0000">Offline</font>';
	}
	?></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td><input type="submit" name="chg" id="chg" value="Update Account"></td>
  </tr>
</table>
</form>
&nbsp;
<?php
if($_POST['chg'])
{
	if(trim($_POST['username']) == "" || $_POST['password'] == "")
	{
		$api->popup("Please Fill all field");
	}
	else
	{
		$mode = 1;
		$update_sql = $sql->prepare("EXEC ".MSSQL_C9DB.".Web.UspUpdateAccount :userid, :acc, :pwd, :auth, :hack, :mode");
		$update_sql->BindParam(":userid",$a);
		$update_sql->BindParam(":acc",$_POST['username']);
		$update_sql->BindParam(":pwd",$_POST['password']);
		$update_sql->BindParam(":auth",$_POST['auth']);
		$update_sql->BindParam(":hack",$_POST['lock']);
		$update_sql->BindParam(":mode",$mode);
		$update_sql->execute();
		$api->popup("Account Update Success.");
		$api->go("index.php?page=accountchange&id=".$a."");
	}
}
?>
</fieldset>
</div>
</p>