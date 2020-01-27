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
    <td width="275" align="right">Account Name :</td>
    <td width="470"><label for="username"></label>
      <input name="username" type="text" id="username" value="<?php echo $account['cAccId']; ?>" readonly="readonly"></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td><input type="submit" name="delete" id="delete" value="Delete Account" /></td>
  </tr>
</table>
</form>
&nbsp;
<?php
if($_POST['delete'])
{
	$mode = 3;
	$empty = NULL;
	$update_sql = $sql->prepare("EXEC ".MSSQL_C9DB.".Web.UspUpdateAccount :userid, :acc, :pwd, :auth, :hack, :mode");
	$update_sql->BindParam(":userid",$a);
	$update_sql->BindParam(":acc",$_POST['username']);
	$update_sql->BindParam(":pwd",$empty);
	$update_sql->BindParam(":auth",$empty);
	$update_sql->BindParam(":hack",$empty);
	$update_sql->BindParam(":mode",$mode);
	$update_sql->execute();
	$api->popup("Account Delete Success.");
	$api->go("index.php?page=accountmanage");
	
}
?>
</fieldset>
</div>
</p>