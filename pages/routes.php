<?php

$path = "index.php?page=login";


$nav=<<<HTML
    <nav>
    </nav>
HTML;

$navNull=<<<HTML
    <nav>
        <ul>
		    <ol>
				<li class="crumb"><a href="#">Bikes</a></li>
				<li class="crumb"><a href="#">BMX</a></li>
				<li class="crumb">Jump Bike 3000</li>
				<li><a href="logout.php?page=logout">Logout</a></li>
			</ol>

        </ul>
    </nav>
HTML;

$navStaff=<<<HTML
    <nav>
        <ul>
            <li><a href="index.php?page=addContact">Add Contact</a></li>
            <li><a href="index.php?page=deleteContacts">Delete contact(s)</a></li>
			<li><a href="logout.php?page=logout">Logout</a></li>
        </ul>
    </nav>
HTML;

$navAdmin=<<<HTML
    <nav>
        <ul>
            <li><a href="index.php?page=addContact">Add Contact</a></li>
            <li><a href="index.php?page=deleteContacts">Delete contact(s)</a></li>
			<li><a href="index.php?page=add_admin">Add Admin</a></li>
			<li><a href="index.php?page=deleteAdmins">Delete Admin(s)</a></li>
			<li><a href="logout.php?page=logout">Logout</a></li>
        </ul>
    </nav>
HTML;

if(isset($_GET)){
    if($_GET['page'] === "addContact"){
        require_once('pages/addContact.php');
        $result = init();
    }
    
    else if($_GET['page'] === "deleteContacts"){
        require_once('pages/deleteContacts.php');
        $result = init();
    }

    else if($_GET['page'] === "login"){
        require_once('pages/login.php');
        $result = init();
	}
	
	else if($_GET['page'] === "add_admin"){
        require_once('pages/add_admin.php');
		$result = init();

    }
	
	else if($_GET['page'] === "deleteAdmins"){
        require_once('pages/deleteAdmins.php');
        $result = init();
    }
	
	else if($_GET['page'] === "welcome"){
        require_once('pages/welcome.php');
        $result = init();
    }

    else {
        //header('Location: http://russet.php?page=form');
        header('location: '.$path);
    }
}

else {
    //header('Location: http://198.199.80.235/cps276/cps276_assignments/assignment10_final_project/solution/index.php?page=form');
    header('location: '.$path);
}



?>