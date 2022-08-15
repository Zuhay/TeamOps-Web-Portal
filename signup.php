<?php require_once("Models/UsersDataset.php");
require_once("Models/OrganisationDataset.php");
$view = new stdClass();
$view->pageTitle = "Login Page";

session_start();

$usersDataset = new UsersDataset();
$orgDataset = new OrganisationDataset();

if(isset($_POST['signUpBtn'])){

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $organizationName = $_POST['organization'];
    $jobTitle = $_POST['jobTitle'];
    $emailAddress = $_POST['emailAddress'];
    $confirmEmail = $_POST['confirmEmailAddress'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    if($emailAddress == $confirmEmail){
        //confirm the domain is valid
        $splitEmail = explode("@", $emailAddress);
        $domain = $splitEmail[1];
        $domainIsValid = $orgDataset->validateOrganisationDomain($domain);
        if($domainIsValid){
            if($password == $confirmPassword){
                $encryptedPassword = password_hash($password, PASSWORD_DEFAULT);

                //get the id of the organization selected by the user in the signup form
                $organizationID = $orgDataset->getOrganization($organizationName)->getOrganisationID();
                //attempt to signup the user
                $successfulSignUp = $usersDataset->signup($firstName, $lastName, $emailAddress, $encryptedPassword, $jobTitle, $organizationID);
                if($successfulSignUp){
                    // log the user in after successfully signing up
                    $user = $usersDataset->fetchUserDetails($emailAddress);
                    $org = $orgDataset->getOrganization($organizationName);
//                var_dump($user);
                    $_SESSION['email'] = $user->getEmailAddress();
                    $_SESSION['userID'] = $user->getUserID();
                header("Location:userportal.php");
                }else{
                    $view->signUpError = "Seems like you already have an account with us";
                }
            }else{
                $view->pwdMismatch = "Password doesn't match";
            }
        }else{
            $view->domainMismatch = "Sorry we do not recognize this domain. Please ensure that @" . $domain . " is the correct domain";
        }
    }else{
        $view->emailMismatch = "Email doesn't match";
    }
}

$view->orgDataset = $orgDataset->fetchAllOrganisations();
require_once ('Views/signup.phtml');