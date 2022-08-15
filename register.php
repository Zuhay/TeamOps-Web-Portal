<?php
require_once("Models/OrganisationDataset.php");
require_once ("Models/UsersDataset.php");
require_once ("Models/CategoryItemSet.php");
session_start();
$view = new stdClass();
$view->pageTitle = "Register";

$orgDataset = new OrganisationDataset();
$usersDataset = new UsersDataset();
$categoryItemSet = new CategoryItemSet();
if(isset($_POST['registerBtn'])){
    $orgName = $_POST['orgName'];
    $domainName = $_POST['domainName'];
    $orgTelephone = $_POST['orgTelephone'];
    $adminEmail = $_POST['adminEmail'];
    $confirmEmail = $_POST['confirmAdminEmail'];
    $password = $_POST['adminPassword'];
    $confirmPassword = $_POST['confirmAdminPassword'];
    if($adminEmail == $confirmEmail){
        if($password == $confirmPassword){
            $encryptedPassword = password_hash($password, PASSWORD_DEFAULT);

            // add the admin to the user table
            $usersDataset->signup("admin", "admin", $adminEmail, $encryptedPassword, "admin", null);
            // get the user ID of the admin from the Users table
            $adminUser = $usersDataset->fetchUserDetails($adminEmail);
            $adminID = $adminUser->getUserID();

            // if the admin user was successfully registered
            if($adminID != 0 && isset($adminID)){
                echo "adminID" .  $adminID;
                // register the organization also assign the adminID
                $registered = $orgDataset->register($orgName, $domainName, $orgTelephone, $adminID);

                //if the registration was successful
                if($registered){
                    // double check that the email is in the database before setting session
                    $organization = $orgDataset->getOrganization($orgName);
                    //log the admin in
                    $_SESSION['email'] = $adminUser->getEmailAddress();
                    $_SESSION['userID'] = $adminUser->getUserID();
                    $_SESSION['admin'] = true;
                    //update the id of the admin
                    $usersDataset->setOrganizationID($adminUser->getEmailAddress(), $organization->getOrganisationID());
                    $categoryItemSet->assignCategoryTo($organization->getOrganisationID(), 'General');
                    // redirect the admin user to the home page
                    header("Location: userportal.php");
                }else{
                    $view->registerError = "Looks like this organization has already been registered";
                }
            }else{
                echo "Admin user registration did not work";
            }


        }else{
            $view->pwdMismatch = "The password doesn't match";
        }
    }else{
        $view->emailMismatch = "The email doesn't match";
    }

}



require_once ("Views/register.phtml");