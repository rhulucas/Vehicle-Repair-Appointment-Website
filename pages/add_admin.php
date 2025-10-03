<?php
require_once 'classes/Page.php';
$page = new Page();
echo $page->head("Encrypted Login - Home Page");
echo $page->security();
 if ($_SESSION['status']=="staff")
 {
	 $nav0 = $navStaff;
 }
 else if ($_SESSION['status']=="admin")
 {
	 $nav0 = $navAdmin;
 }


require_once('classes/StickyForm.php');
$stickyForm = new StickyForm();

function init(){
  global $elementsArr, $stickyForm;
  
	$output2 = "";
	if(isset($_POST['addAdmin'])){
		$postArr = $stickyForm->validateForm($_POST, $elementsArr);
		if($postArr['masterStatus']['status'] == "noerrors")
			{
				return addData($_POST);
		}
		else{
			return getForm("",$postArr);
		}
	}
	else {
      return getForm("", $elementsArr);
    }
}

$elementsArr = [
  "masterStatus"=>[
    "status"=>"noerrors",
    "type"=>"masterStatus"
  ],
	"name"=>[
	  "errorMessage"=>"<span style='color: red; margin-left: 15px;'>Name cannot be blank and must be a standard name</span>",
		"errorOutput"=>"",
		"type"=>"text",
		"value"=>"Scott",
		"regex"=>"name"
	],
	
	"email"=>[
	  "errorMessage"=>"<span style='color: red; margin-left: 15px;'>Email address cannot be blank and must be a valid email box</span>",
		"errorOutput"=>"",
		"type"=>"text",
		"value"=>"Scott@test.com",
		"regex"=>"email"
	],
	
	"password"=>[
		"errorMessage"=>"<span style='color: red; margin-left: 15px;'>Password cannot be blank and should be at least 8 characters</span>",
		"errorOutput"=>"",
		"type"=>"text",
		"value"=>"password",
		"regex"=>"password"		
	],
	
	"status"=>[
		"errorMessage"=>"<span style='color: red; margin-left: 15px;'>Status cannot be blank</span>",
		"errorOutput"=>"",
		"type"=>"text",
		"value"=>"staff",
		"regex"=>"status"		
	]
];

function addData($post){
	global $elementsArr;	
	global $output2;
	
	require_once('classes/Pdo_methods.php');

	$pdo = new PdoMethods();
	$sql = "SELECT email FROM admin WHERE email = :email";
	$bindings = array(
			array(':email', $post['email'], 'str')
		);
	$records = $pdo->selectBinded($sql, $bindings);
	if($records == 'error'){
		$output2 = 'There was an error processing your request';
	}
	else{
		if(count($records) != 0){
	            $output2 = "There is already someone with that email";
		}
		else {
			/** ENCRYPT THE PASSWORD USING PASSWORD_HASH */
			$password = password_hash($post['password'], PASSWORD_DEFAULT);


			$sql = "INSERT INTO admin (name, email, password, status) VALUES (:name, :email, :password, :status)";
			$bindings = array(
			array(':name',$post['name'],'str'),
			array(':email',$post['email'],'str'), array(':password',$post['password'],'str'), array(':status',$post['status'],'str')
			);
			
			$result = $pdo->otherBinded($sql, $bindings);
			if($result = 'noerror'){
					$output2 = 'Admin added';
			}
			else {
				$output2 = 'There was a problem adding this administrator';
			}
			}
		}
		  return getForm($output2, $elementsArr);
	}

  
function getForm($acknowledgement, $elementsArr)
{

global $stickyForm;

$form = <<<HTML
		<form method="post" action="index.php?page=add_admin">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="name">Name
			  {$elementsArr['name']['errorOutput']}
			  </label>
              <input type="text" class="form-control" name="name" value={$elementsArr['name']['value']}>
            </div>
          </div>
        </div>
		
		<div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="email">Email
			  {$elementsArr['email']['errorOutput']}
			  </label>
              <input type="text" class="form-control" name="email" value={$elementsArr['email']['value']}>
            </div>
          </div>
        </div>
		
		<div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="password">Password
			  {$elementsArr['password']['errorOutput']}
			  </label>
              <input type="text" class="form-control" name="password" value={$elementsArr['password']['value']}>
            </div>
          </div>
        </div>
		
		<div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="status">Status
			  {$elementsArr['status']['errorOutput']}
			  </label>
              <input type="status" class="form-control" name="status" value={$elementsArr['status']['value']}>
            </div>
          </div>
        </div>
		
		<div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <input type="submit" class="btn btn-primary" name="addAdmin" value="Add Admin" >
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
     <?php 	echo $nav0; ?>	
	 <h1>Add Admin(s)</h1>
     	 
  </body>
</html>