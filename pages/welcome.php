<?php
require_once 'classes/Page.php';
//require_once 'classes/Admin.php';
require_once('pages/routes.php');
$page = new Page();
//$admin = new Admin();
$output = "";
//$output = $admin->displayUsernamePassword();

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
 else {
	 $nav0 = $navNull;
 }
function init(){
    return ["<h1>Welcome</h1>","<p>Welcome ".$_SESSION["name"]."</p>"];
}
// 
?>

  <body>
    <div id="wrapper" class="container">
      
      <h1></h1>
     <?php 	 	
					echo $nav0;

	 ?>
		     
  </body>
</html>