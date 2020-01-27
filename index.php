<?php
session_start();
include_once("include/config.php");
$page = $_GET['page'];
$api->chklogin($_SESSION['account']);
if(empty($page))
{
	$api->go("index.php?page=accountmanage");
}
// Account Information
$acc_sql = $sql->prepare("SELECT * FROM C9Unity.Auth.TblAccount WHERE cAccId = :p1");
$acc_sql->BindParam(":p1",$_SESSION['account']);
$acc_sql->execute();
$acc = $acc_sql->fetch(PDO::FETCH_ASSOC);

$lo_sql = $sql->prepare("SELECT * FROM ".MSSQL_C9DB.".Log.TblLogin WHERE pIp = :ip");
$lo_sql->BindParam(":ip",$ip);
$lo_sql->execute();
$lo = $lo_sql->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin Panel Version 1.2</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="./js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="./js/jquery-ui.js"></script>
<script type="text/javascript" src="./js/jquery-ui.min.js"></script>
<link href="./js/jquery-ui.css" rel="stylesheet">
<script>
  $(function() {
    $( "#datepicker" ).datepicker({ changeMonth: true,changeYear: true,yearRange: '2016:2077' });
  });
</script>
<script type="text/javascript">
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
</script>
</head>

<body onload="MM_preloadImages('images/left_logout_btn_on.gif','images/top_mn_account_on.gif','images/top_mn_game_on.gif','images/top_mn_log_on.gif','images/top_mn_analy_on.gif','images/top_mn_system_on.gif')">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="header_bg">
  <tr>
    <td valign="bottom"><table width="98%" align="center">
      <tr>
        <td width="9%" align="center"><img src="images/logo.png" width="84" height="69" /></td>
        <td width="91%" valign="bottom"><table width="100">
          <tr>
            <td><a href="index.php?page=accountmanage" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image4','','images/top_mn_account_on.gif',1)"><img src="images/top_mn_account_off.gif" alt="Account Manager" width="161" height="30" id="Image4" /></a></td>
            <td><a href="index.php?page=gamemanage" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image5','','images/top_mn_game_on.gif',1)"><img src="images/top_mn_game_off.gif" alt="Game Manage" width="161" height="30" id="Image5" /></a></td>
            <td><a href="index.php?page=logmanage" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image6','','images/top_mn_log_on.gif',1)"><img src="images/top_mn_log_off.gif" alt="Log Info" width="161" height="30" id="Image6" /></a></td>
            <td><a href="index.php?page=analysismanage" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image7','','images/top_mn_analy_on.gif',1)"><img src="images/top_mn_analy_off.gif" alt="Analysis" width="161" height="30" id="Image7" /></a></td>
            <td><a href="index.php?page=systemmanage" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image8','','images/top_mn_system_on.gif',1)"><img src="images/top_mn_system_off.gif" alt="System" width="161" height="30" id="Image8" /></a></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="11%" valign="top"><table width="88" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="59%"><img src="images/left_info_tle.gif" width="126" height="19" /></td>
        <td width="41%"><a href="index.php?page=logout" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image3','','images/left_logout_btn_on.gif',1)"><img src="images/left_logout_btn_off.gif" alt="Logout" width="66" height="19" id="Image3" /></a></td>
      </tr>
    </table>
      <table width="192" border="0" cellpadding="0" cellspacing="0" class="left_info">
        <tr>
          <td><table width="95%" align="center">
            <tr>
              <td width="6%"><img src="images/left_info_icon.gif" width="3" height="5" /></td>
              <td width="94%"><strong>Username :</strong> <?php echo $_SESSION['account']; ?></td>
            </tr>
            <tr>
              <td><img src="images/left_info_icon.gif" alt="" width="3" height="5" /></td>
              <td><strong>Auth :</strong> <?php echo $api->auth_name($acc['cAuthLevel']); ?></td>
            </tr>
            <tr>
              <td><img src="images/left_info_icon.gif" alt="" width="3" height="5" /></td>
              <td><strong>Last Login :</strong> <?php echo $lo['pLastLogin']; ?></td>
            </tr>
          </table></td>
        </tr>
    </table>
      <table width="192" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td><?php echo $api->left_img($_GET['page']); ?></td>
        </tr>
        <tr>
          <td>
          
          <?php
		  // Menu List
		  $menu_sql = $sql->prepare("SELECT * FROM ".MSSQL_C9DB.".Web.TblLeftMenu WHERE menu_catalog = :catalog");
		  $menu_sql->BindParam(":catalog",$api->left_menu($page));
		  $menu_sql->execute();
		  while($menu = $menu_sql->fetch(PDO::FETCH_ASSOC))
		  {
			  if($menu['show'] != 0)
			  {
				  if($page == $menu['menu_link'])
				  {
					  echo '<a href="index.php?page='.$menu['menu_link'].'" style="text-decoration:none;">
					  <table width="192" border="0" cellpadding="0" cellspacing="0" class="left_munu_selected">
						<tr>
						  <td width="21">&nbsp;</td>
						  <td width="171">'.$menu['menu_name'].'</td>
						</tr>
					  </table>
					  </a>';

				  }
				  else
				  {
					   echo '<a href="index.php?page='.$menu['menu_link'].'" style="text-decoration:none;">
					  <table width="192" border="0" cellpadding="0" cellspacing="0" class="left_menu">
						<tr>
						  <td width="21">&nbsp;</td>
						  <td width="171">'.$menu['menu_name'].'</td>
						</tr>
					  </table>
					  </a>';
				  }
			  }
		  }
          ?>
          </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
    </table></td>
    <td width="89%" align="left" valign="top"><div class="main_path">
    <?php
	// Header Name
	$title_head = array("NULL","Account Management","Game Management","Log Management","Analysis Management","System Management");
	$head_sql = $sql->prepare("SELECT TOP 1 * FROM ".MSSQL_C9DB.".Web.TblLeftMenu WHERE menu_link LIKE :page");
	$head_sql->BindParam(":page",$page);
	$head_sql->execute();
	while($head = $head_sql->fetch(PDO::FETCH_ASSOC))
	{
		echo $title_head[$head['menu_catalog']];
		if($head['menu_catalog'] == 1)
		{
			echo "<img src='/images/main_path_icon.gif' alt='path' />".$head['menu_name']."";
		}
		else if($head['menu_catalog'] == 2)
		{
			echo "<img src='/images/main_path_icon.gif' alt='path' />".$head['menu_name']."";
		}
		else if($head['menu_catalog'] == 3)
		{
			echo "<img src='/images/main_path_icon.gif' alt='path' />".$head['menu_name']."";
		}
		else if($head['menu_catalog'] == 4)
		{
			echo "<img src='/images/main_path_icon.gif' alt='path' />".$head['menu_name']."";
		}
		else if($head['menu_catalog'] == 5)
		{
			echo "<img src='/images/main_path_icon.gif' alt='path' />".$head['menu_name']."";
		}
		else
		{
			echo "<img src='/images/main_path_icon.gif' alt='path' />".$head['menu_name']."";
		}
	}
	?>
    </div>
      <p>
        <?php
	// Link
	$link_sql = $sql->prepare("SELECT TOP 1 * FROM ".MSSQL_C9DB.".Web.TblLeftMenu WHERE menu_link LIKE :page");
	$link_sql->BindParam(":page",$page);
	$link_sql->execute();
	while($link = $link_sql->fetch(PDO::FETCH_ASSOC))
	{
		include_once("common/".$api->content_directory($link['menu_catalog'])."".$link['menu_link'].".php");
	}
	?>
    </p>
    <p>&nbsp;</p>
    <table width="757">
      <tr>
        <td align="center"><strong>Developer By.Marvis Vermillion</strong></td>
      </tr>
    </table>
    <p>&nbsp;</p></td>
  </tr>
</table>
</body><?php

		$api->url_key(SYSTEM_VER);
		?>
</html>