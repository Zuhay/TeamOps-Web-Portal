<?php
session_start();

$view = new stdClass();
require_once ('Models/UsersDataset.php');
require_once ('Models/OrganisationDataset.php');
$view->pageTitle = "Profile Page";


if(isset($_SESSION['userID'])){

    $userID = $_SESSION['userID'];
     $email = $_SESSION['email'];
    $userDataSet = new UsersDataset();
    $itemData = $userDataSet->fetchUserDetails($email);

    $organisationDataSet = new OrganisationDataset();
    $set = $organisationDataSet->getOrganisation($itemData->getOrganizationID());
    $organisation = $set[0];

        if(isset($_POST['saveBtn'])){
          $value =  $_POST['value'];
          $parameter = $_POST['parameter'];

              if($parameter == "email_address"){
                    $value =  $value.'@'.$organisation->getOrganisationEmailDomain();
                    $_SESSION['email'] = $value;
              }
            $userDataSet->editInUser($parameter,$value,$userID);


            header('Location: '.$_SERVER['REQUEST_URI']);

        }

    require_once('Views/profile.phtml');
}else{
    header("Location: login.php");
    exit();
}


