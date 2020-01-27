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

// Check Account Status
$status_sql = $sql->prepare("SELECT * FROM C9Unity.Auth.TblAccountBlock WHERE cAccNo = :p1");
$status_sql->BindParam(":p1",$a);
$status_sql->execute();
$status = $status_sql->fetch(PDO::FETCH_ASSOC);
?>
<form action="" method="post" name="editaccount"><table width="757">
  <tr>
    <td width="275" align="right">Account Name :</td>
    <td width="470"><label for="username"></label>
      <input name="username" type="text" id="username" value="<?php echo $account['cAccId']; ?>" readonly="readonly"></td>
  </tr>
  <tr>
    <td align="right">Date End :</td>
    <td><input name="dateban" type="text" id="datepicker" value="<?php echo $status['cDateEnd']; ?>" autocomplete="off" /></td>
  </tr>
  <tr>
    <td align="right">Reason :</td>
    <td><label for="reason"></label>
      <select name="reason" id="reason">
        <option value="1">Disclosure of personal information</option>
        <option value="2">Hack / Pro / Bot</option>
        <option value="3">Interrupting others Or try to disturb others inappropriately.</option>
        <option value="4">Trading ID</option>
        <option value="5">ID theft</option>
        <option value="6">ID theft suspect</option>
        <option value="7">Improper use of the name</option>
        <option value="8">Using illegal software</option>
        <option value="9">Distributing illegal software</option>
        <option value="10">Deceive</option>
      </select></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td><input type="submit" name="Block" id="Block" value="Block Account" /></td>
  </tr>
</table>
</form>
&nbsp;
<?php
if($_POST['Block'])
{
	$month = substr($_POST['dateban'],0,2);
	$day = substr($_POST['dateban'],3,4);
	$year = substr($_POST['dateban'],6,9);
	$dateconvert = "".$year."-".$month."-".$day."";
	$date = substr($dateconvert,0,10);
	if(trim($_POST['dateban']) == "")
	{
		$api->popup("Please selected Date end.");
	}
	else
	{
		$mode = 2;
		$empty = NULL;
		$update_sql = $sql->prepare("EXEC ".MSSQL_C9DB.".Web.UspUpdateAccount :userid, :acc, :pwd, :auth, :hack, :mode");
		$update_sql->BindParam(":userid",$a);
		$update_sql->BindParam(":acc",$empty);
		$update_sql->BindParam(":pwd",$empty);
		$update_sql->BindParam(":auth",$_POST['reason']);
		$update_sql->BindParam(":hack",$date);
		$update_sql->BindParam(":mode",$mode);
		$update_sql->execute();
		$api->popup("Account Banned Success.");
		$api->go("index.php?page=accountblock&id=".$a."");
	}
	
}
?>
</fieldset>
</div>
</p>