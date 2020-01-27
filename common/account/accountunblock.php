<fieldset class="field_box">
<form name="accountsearch" method="post" action="">
  <table width="500">
    <tr>
      <td width="136" align="right">Account Name :</td>
      <td width="127"><label for="account"></label>
      <input type="text" name="account" id="account" autocomplete="off"></td>
      <td width="221"><input type="submit" class="btn_search" name="submit" id="submit" value=" " /></td>
    </tr>
  </table>
</form>
</fieldset><p><div class="animated fadeIn">
<?php
$a = $_GET['id'];
// Account Information
$account_sql = $sql->prepare("SELECT * FROM C9Unity.Auth.TblAccount WHERE cAccNo = :p1");
$account_sql->BindParam(":p1",$a);
$account_sql->execute();
$account = $account_sql->fetch(PDO::FETCH_ASSOC);
?>
<form action="" method="post" name="unblock">
<table width="757">
  <tr>
    <td align="right">Account :</td>
    <td><?php echo $account['cAccId']; ?></td>
  </tr>
  <tr>
    <td align="right"><input name="unblock" type="submit" value="Unblock" /></td>
    <td><input name="cancel" type="button" value="Cancel" /></td>
  </tr>
</table>

</form>
<center>
<?php
if($_POST['unblock'])
{
	// Unblock
	$mode = 4;
	$null = NULL;
	$update_sql = $sql->prepare("EXEC ".MSSQL_C9DB.".Web.UspUpdateAccount :userid, :acc, :pwd, :auth, :hack, :mode");
	$update_sql->BindParam(":userid",$a);
	$update_sql->BindParam(":acc",$null);
	$update_sql->BindParam(":pwd",$null);
	$update_sql->BindParam(":auth",$null);
	$update_sql->BindParam(":hack",$null);
	$update_sql->BindParam(":mode",$mode);
	$update_sql->execute();
	$api->popup("Account Update Success.");
	$api->go("index.php?page=accountban");
}
?>
</center></div>
</p>