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
$accn = "%".$_POST['account']."%";
$account_sql = $sql->prepare("SELECT TOP 30 C9Unity.Auth.TblAccount.*,C9Unity.Auth.TblAccountBlock.* FROM C9Unity.Auth.TblAccount
LEFT JOIN C9Unity.Auth.TblAccountBlock ON C9Unity.Auth.TblAccount.cAccNo = C9Unity.Auth.TblAccountBlock.cAccNo WHERE C9Unity.Auth.TblAccount.cAccId LIKE :acc");
$account_sql->BindParam(":acc",$accn);
$account_sql->execute();
while($account = $account_sql->fetch(PDO::FETCH_ASSOC))
{
	if($account['cDetectedHack'] == 1)
	{
  echo '<tr>
    <td width="560">'.$account['cAccId'].'</td>
    <td width="60"><a href="index.php?page=accountunblock&id='.$account['cAccNo'].'"><img src="../../images/btn_reset.gif"  /></a></td>
  </tr>';
	}
}
?>
</table>

</p>