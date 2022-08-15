<?php require_once ("Models/UsersDataset.php");
require_once ("Models/OrganisationDataset.php");
$view = new stdClass();
$view->pageTitle = "Login Page";

session_start();

// create a new instance of the users dataset class which will be used to query the database
$usersDataset = new UsersDataset();
//if the user press the login button
if(isset($_POST["loginBtn"])){
    //$view->login = "Login button pressed";
    $email = $_POST['emailAddress'];
    $password = $_POST['password'];
    //check if the login details are correct
    $verified = $usersDataset->verifyLoginDetails($email, $password);

    // if the login details are correct, log the user in
    if($verified == true){

        // check if the user is an admin user
        $user = $usersDataset->fetchUserDetails($email);
        $orgDataset = new OrganisationDataset();
        $organisations = $orgDataset->fetchAllOrganisations();
        foreach ($organisations as $organisation) {
            if($organisation->getOrganisationAdminID() == $user->getUserID()){
                $_SESSION['admin'] = true;
            }
        }
//      create a session for the user
        $_SESSION['email'] = $email;
        $user = $usersDataset->fetchUserDetails($email);
        $_SESSION['userID'] = $user->getUserID();
        header("Location: userportal.php");
    }else{
        $view->loginError = "Wrong username or password";
    }
}

// if the logout button was pressed
if(isset($_GET["logout"]) && !isset($_POST["loginBtn"])){
    //end the session
    unset($_SESSION["email"]);
    unset($_SESSION["userID"]);
    if(isset($_SESSION['admin'])){
        unset($_SESSION["admin"]);
    }
    //destroy the session
    session_destroy();
}

require_once('Views/login.phtml');