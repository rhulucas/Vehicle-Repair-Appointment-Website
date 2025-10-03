<?php
//require_once 'classes/Page.php';
//$page = new Page();
//echo $page->head("Encrypted Login - Login Page");
require_once('pages/routes.php');
//$output2 ="welcome";
require_once('classes/StickyForm.php');
$stickyForm = new StickyForm();

function init(){
	global $elementsArr, $stickyForm;
	//global $output2;
	if(isset($_POST['login'])){
	//$output2 = "submitted";	
	$postArr = $stickyForm->validateForm($_POST, $elementsArr);
	if($postArr['masterStatus']['status'] == "noerrors"){
	return addData($_POST);
	}
	else{
		return getForm("",$postArr);	
	}
	}
	else{
		return getForm("", $elementsArr);
	}
}


$elementsArr = [
  "masterStatus"=>[
    "status"=>"noerrors",
    "type"=>"masterStatus"
  ],
  
	"email"=>[
	  "errorMessage"=>"<span style='color: red; margin-left: 15px;'>Email address cannot be blank and must be a valid email box</span>",
		"errorOutput"=>"",
		"type"=>"text",
		"value"=>"rong@emich.edu",
		"regex"=>"email"
	],
	
	"password"=>[
		"errorMessage"=>"<span style='color: red; margin-left: 15px;'>Password cannot be blank and should be at least 8 characters</span>",
		"errorOutput"=>"",
		"type"=>"text",
		"value"=>"password",
		"regex"=>"password"		
	]
];

function addData($post){
  global $elementsArr; 
  global $output2;
	
	
	
	
		require_once 'classes/Pdo_methods.php';
		//$output2 ="";
	
		$pdo = new PdoMethods();
	
	    $sql = "SELECT name, email, password, status FROM admin WHERE email = :email";
		$bindings = array(
			array(':email', $_POST['email'], 'str')
		);

	    $records = $pdo->selectBinded($sql, $bindings);

		/** IF THERE WAS AN RETURN ERROR STRING */
		if($records == 'error'){
			$output2 = "There was an error logging it";
		}
		
		/** */
		else{
			if(count($records) != 0){
	            /** IF THE PASSWORD IS NOT VERIFIED USING PASSWORD_VERIFY THEN RETURN FAILED, OTHERWISE RETURN SUCCESS, IF NO RECORDS ARE FOUND RETURN NO RECORDS FOUND. */
	            if($_POST['password']==$records[0]['password']){
	                session_start();
	                $_SESSION['access'] = "accessGranted";
	                $output2 =  "success";
					$_SESSION["name"] = $records[0]['name'];
					$_SESSION["status"] = $records[0]['status'];
	            }
	            else {
	                $output2 =  "There was a problem logging in with those credentials-1 ".$_POST['password']." record".$records[0]['password'];
	            }
			}
			else {
				$output2 =  "There was a problem logging in with those credentials-2";
			}
		}
		
    if($output2 === 'success'){
	$output2 =  "welcome";
    header('Location: index.php?page=welcome');
	}
	
  return getForm($output2, $elementsArr);
}


function getForm($acknowledgement, $elementsArr)
{

global $stickyForm;

//$output .= "<form action='index.php?page=login method='post>";
$form = <<<HTML
    <form method="post" action="index.php?page=login">
    <div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label for="email">Email {$elementsArr['email']['errorOutput']}</label>
				<input type="text" class="form-control" id="email" name="email" value={$elementsArr['email']['value']} >
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label for="password">Password{$elementsArr['password']['errorOutput']}</label>
				<input type="password" class="form-control" name="password" value={$elementsArr['password']['value']}>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<input type="submit" class="btn btn-primary" name="login" value="Login">
			</div>
		</div>
	</div>
	</form>
HTML;

return [$acknowledgement, $form];
}

?>

 <body>
    <div id="wrapper" class="container">	
	<h1>Login</h1>
	
  </body>
</html>
 