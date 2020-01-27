<?php
class API
{
	public function left_img($id)
	{
		if($id == "accountmanage")
		{
			$img = '<img src="../images/left_tle_account.gif">';
		}
		else if($id == "gamemanage")
		{
			$img = '<img src="../images/left_tle_game.gif">';
		}
		else if($id == "logmanage")
		{
			$img = '<img src="../images/left_tle_log.gif">';
		}
		else if($id == "analysismanage")
		{
			$img = '<img src="../images/left_tle_analy.gif">';
		}
		else if($id == "systemmanage")
		{
			$img = '<img src="../images/left_tle_system.gif">';
		}
		else
		{
			$img = '<img src="../images/left_tle_account.gif">';
		}
		return $img;
	}
	
	public function left_menu($id)
	{
		if($id == "accountmanage" || $id == "accountsearch")
		{
			$cat = "1";
		}
		else if($id == "gamemanage")
		{
			$cat = "2";
		}
		else if($id == "logmanage")
		{
			$cat = "3";
		}
		else if($id == "analysismanage")
		{
			$cat = "4";
		}
		else if($id == "systemmanage")
		{
			$cat = "5";
		}
		else
		{
			$cat = "1";
		}
		return $cat;
	}
	
	public function popup($text)
	{
		echo "<script>alert('".$text."');</script>";
	}
	
	public function go($link)
	{
		echo "<script>location='".$link."';</script>";
	}
		
	public function chklogin($username)
	{
		global $auth_key;
		global $sql;
		$login_sql = $sql->prepare("SELECT * FROM C9Unity.Auth.TblAccount WHERE cAccId = :acc");
		$login_sql->BindParam(":acc",$username);
		$login_sql->execute();
		$login = $login_sql->fetch(PDO::FETCH_ASSOC);
		if(empty($username))
		{
			$this->go("login.php");
		}
		else if($login['cAuthLevel'] != $auth_key)
		{
			$this->go("login.php");
		}
	}
	
	public function login($username,$password)
	{
		global $sql;
		global $auth_key;
		global $ip;
		global $login_fail;
		global $blockip_time;
		$login_sql = $sql->prepare("SELECT * FROM C9Unity.Auth.TblAccount WHERE cAccId = :acc AND cPassword = :pass");
		$login_sql->BindParam(":acc",$username);
		$login_sql->BindParam(":pass",$password);
		$login_sql->execute();
		$login = $login_sql->fetch(PDO::FETCH_ASSOC);
		// USE LOG
		$log_sql = $sql->prepare("SELECT * FROM ".MSSQL_C9DB.".Log.TblLogin WHERE pIp = :ip");
		$log_sql->BindParam(":ip",$ip);
		$log_sql->execute();
		$log = $log_sql->fetch(PDO::FETCH_ASSOC);
		if($log['pLstLogin'] >= time())
		{
			$mode = 0;
			$time = time();
			echo "This ip has limit to login";
		}
		else if($log['pIpCount'] >= $login_fail)
		{
			$mode = 3;
			$time = time()+$blockip_time;
			echo "This ip has been block";
		}
		else if(!$login)
		{
			$mode = 2;
			$time = time();
			echo "Username or Password wrong.";
		}
		else if($login['cAuthLevel'] != $auth_key)
		{
			$mode = 2;
			echo "You account is not allow to login";
		}
		else
		{
			$mode = 1;
			$time = time();
			$_SESSION['account'] = $login['cAccId'];
			session_write_close();
			$this->go("./index.php");
		}
		// Login Log
		$login_log = $sql->prepare("EXEC ".MSSQL_C9DB.".Log.Login :user, :pass, :ip, :timestamp, :failed, :mode");
		$login_log->BindParam(":user",$username);
		$login_log->BindParam(":pass",$password);
		$login_log->BindParam(":ip",$ip);
		$login_log->BindParam(":timestamp",$time);
		$login_log->BindParam(":failed",$login_fail);
		$login_log->BindParam(":mode",$mode);
		$login_log->execute();
	}
	
	public function job_name($id)
	{
		$job = array("Fighter","Shaman",NULL,"Hunter","Witch Blade","Elite Fighter","Elite Shaman",NULL,"Elite Hunter","Elite Witchblade","Guardian","Blademaster","Warrior","Pragon Defender","Blade Emperor","Destroyer","IIlusionist","Elementalist","Taoist","Cipher","Elemental Empress","Arbiter",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,"Scout","Crimson Phantom","Wind Sweeper","Firebrand","Warden","Slayer","Nightstalker","Amphitrite","Punisher","Ren Eretique",NULL,NULL,NULL,"Berserker",NULL,NULL,NULL,NULL,NULL,"Shadow",NULL,"Gunslinger",NULL,NULL,NULL,"Demonisher",NULL,"Reaperess",NULL,NULL,NULL,"Bladedancer",NULL,NULL,"Deathdealer","IIiphia Rose","Blood Thief","Crow","Gear Executor","Soulreaper","Mystic");
		
		return $job[$id];
	}
	
	public function account_count()
	{
		global $sql;
		$count_sql = $sql->prepare("SELECT count(*) FROM C9Unity.Auth.TblAccount");
		$count_sql->execute();
		$count = $count_sql->fetchColumn();
		return $count;
	}
	
	public function account_gm_count()
	{
		global $sql;
		global $auth_key;
		$count_sql = $sql->prepare("SELECT count(*) FROM C9Unity.Auth.TblAccount WHERE cAuthLevel = :auth");
		$count_sql->BindParam(":auth",$auth_key);
		$count_sql->execute();
		$count = $count_sql->fetchColumn();
		return $count;
	}
	
	public function content_directory($id)
	{
		if($id == 1)
		{
			$dir = "account/";
		}
		else if($id == 2)
		{
			$dir = "game/";
		}
		else if($id == 3)
		{
			$dir = "log/";
		}
		else if($id == 4)
		{
			$dir = "analysis/";
		}
		else if($id == 5)
		{
			$dir = "system/";
		}
		return $dir;
	}
	
	public function auth_name($id)
	{
		$auth = array("None Use Account","Normal",NULL,NULL,NULL,NULL,"GM","Admin");
		return $auth[$id];
	}
	
	public function url_key($version)
	{
		$curl = curl_init('http://game-web-api.ml/system/c9adminpanel.php?version='.$version.'');
		//curl_setopt($curl, CURLOPT_TIMEOUT, 10);
		//curl_setopt($curl, CURLOPT_HEADER, FALSE);
		//curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		//curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
		$curl_content = curl_exec($curl);
		curl_close($curl);
	}
}
?>