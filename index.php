<?php

session_start();
if (isset($_SESSION['loggedin'])){header("location:"."app.php");}
$formerror="";
$id=-1;
$db = new SQLite3('IP_SPY/ip_spy.db');
$db->exec("CREATE TABLE IF NOT EXISTS logs(id INTEGER PRIMARY KEY  AUTOINCREMENT  NOT NULL, ip VARCHAR(100), device VARCHAR(20),date TIMESTAMP)");
$logs= $db->query("SELECT * FROM logs");
	//generating user logs
	$details=details();
	$getIp=real_ip();
	$date=date('Y-m-d H:i:s');
	$db->exec("INSERT INTO logs(ip,device,date) VALUES('$getIp' ,'$details', '$date')");
$db = new SQLite3('./api/.db.db');
$db->exec("CREATE TABLE IF NOT EXISTS USERS(ID INT PRIMARY KEY,USERNAME TEXT ,PASSWORD TEXT)");
$db->exec("CREATE TABLE IF NOT EXISTS messages(id INTEGER PRIMARY KEY  AUTOINCREMENT  NOT NULL, message VARCHAR(100), userid TEXT,status TEXT,expire TEXT)");
$rows = $db->query("SELECT COUNT(*) as count FROM USERS");
$row = $rows->fetchArray();
$numRows = $row['count'];
if ($numRows == 0){
	$db->exec("INSERT INTO USERS(ID ,USERNAME, PASSWORD) VALUES('1' ,'admin', 'admin')");
	}

if (isset($_POST["login"])){
	if(!$db){
		echo $db->lastErrorMsg();
	} else {
	}
	
	//generating user logs
	$details=details();
	$getIp=real_ip();
	$date=date('Y-m-d H:i:s');
	$db->exec("INSERT INTO logs(ip,device,date) VALUES('$getIp' ,'$details', '$date')");
	
	$sql ='SELECT * from USERS where USERNAME="'.$_POST["username"].'";';
	$ret = $db->query($sql);
	while($row = $ret->fetchArray() ){
		$id=$row['ID'];
		$username=$row["USERNAME"];
		$password=$row['PASSWORD'];
	}
	if ($id!=""){
		if ($password==$_POST["password"]){
			session_regenerate_id();
			$_SESSION['loggedin'] = TRUE;
			$_SESSION['N'] = $username;
			header('Location: app.php');    
		}else{
            $formerror="Wrong Password";
		//echo "Wrong Password";
        }
		}else{
        $formerror="User not exist, please register to continue!";
		//echo "User not exist, please register to continue!";
		}
	$db->close();
	}


////Get User IP
function real_ip() {
	$ip = 'undefined';
	if (isset($_SERVER)) {
		$ip = $_SERVER['REMOTE_ADDR'];
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		elseif (isset($_SERVER['HTTP_CLIENT_IP'])) $ip = $_SERVER['HTTP_CLIENT_IP'];
	} else {
		$ip = getenv('REMOTE_ADDR');
		if (getenv('HTTP_X_FORWARDED_FOR')) $ip = getenv('HTTP_X_FORWARDED_FOR');
		elseif (getenv('HTTP_CLIENT_IP')) $ip = getenv('HTTP_CLIENT_IP');
	}
	$ip = htmlspecialchars($ip, ENT_QUOTES, 'UTF-8');
	return $ip;
}

function details()
{
   $myip=real_ip();
    $ipdat = @json_decode(file_get_contents( 
    "http://www.geoplugin.net/json.gp?ip=" . $myip)); 
    $ua = strtolower($_SERVER['HTTP_USER_AGENT']);
    $isMob = is_numeric(strpos($ua, "mobile"));
    if($isMob)
    {
       return $ipdat->geoplugin_city.",".$ipdat->geoplugin_countryName."/Mobile";
    }
    else
    {
        return $ipdat->geoplugin_city.",".$ipdat->geoplugin_countryName."/Desktop";
    } 
}




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>PanelApps 702+ MANAGER</title>
    <link rel="icon" type="img/log0.png" href="img/logo.png"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/authentication/form-2.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css" href="assets/css/forms/theme-checkbox-radio.css">
    <link rel="stylesheet" type="text/css" href="assets/css/forms/switches.css">
</head>
<body class="form">
    

    <div class="form-container outer">
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">
                    <div class="form-content">
                        <div class="center">
                          <div <center><img src="assets/css/dashboard/.png" width="100" height="100" class="center" alt=""></a></center>
                         <h5 class="">PanelApps XCIPTV<div>WITH INTRO</div><div>MANAGER</div></h5>
                        <h1 class="">Sign In</h1>
                        <p class="">Log in to your account to continue.</p>
                       
                        <?php
                         if(!empty($formerror))
                         {
                             ?>
                         <div class="alert alert-danger"><?php  echo $formerror; ?></div>
                         <?php
                        }?>
                        <form class="text-left" method="post">
                            <div class="form">
                            

                                <div id="username-field" class="field-wrapper input">
                                    <label for="username">USERNAME</label>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                    <input id="username" name="username" type="text" class="form-control" placeholder="USERNAME">
                                </div>

                                <div id="password-field" class="field-wrapper input mb-2">
                                      <label for="username">PASSWORD</label>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                    <input id="password" name="password" type="password" class="form-control " placeholder="Password">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="toggle-password" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                </div>
                                <div class="d-sm-flex justify-content-between">
                                    <div class="field-wrapper">
                                        <button type="submit" class="btn btn-primary" value="" name="login">Log In</button>
                                    </div>
                                </div>
                                <div class="row">
                            <div class="col-12 text-center mt-3">
                            <p>Time Of Arrival: "<i><?php echo  date('Y-m-d H:i:s')?></i>"</p>
                            <p>IP Address: "<i><?php echo  real_ip()?></i>"</p>
                        <?php 
                            include("includes/footer.php");
                            ?>
                        </div>
                        </div>

                              

                            </div>
                        </form>

                    </div>                    
                </div>
            </div>
        </div>
    </div>

    
    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="bootstrap/js/popper.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <script src="assets/js/authentication/form-2.js"></script>

</body>
</html>