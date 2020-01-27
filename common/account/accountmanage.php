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
</fieldset><p>
<table width="757" class="animated fadeIn">
<?php
// Account List
$acc = "%".$_POST['account']."%";
$account_sql = $sql->prepare("SELECT TOP 30 * FROM C9Unity.Auth.TblAccount WHERE cAccId LIKE :acc");
$account_sql->BindParam(":acc",$acc);
$account_sql->execute();
while($account = $account_sql->fetch(PDO::FETCH_ASSOC))
{
	if(!$account['cAccNo'])
	{
		echo "Not found account";
	}
	else
	{
  echo '<tr>
    <td width="560">'.$account['cAccId'].'</td>
    <td width="60"><a href="index.php?page=accountchange&id='.$account['cAccNo'].'"><img src="../../images/btn_change.gif" width="67" height="15" /></a></td>
    <td width="60"><a href="index.php?page=accountblock&id='.$account['cAccNo'].'"><img src="../../images/btn_block_acc.gif" width="103" height="15" /></a></td>
    <td width="59"><a href="index.php?page=accountdelete&id='.$account['cAccNo'].'"><img src="../../images/btn_delete.gif" width="61" height="15" /></a></td>
  </tr>';
	}
}
?>
</table>

</p>