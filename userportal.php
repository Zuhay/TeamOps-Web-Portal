<?php
require_once ("Models/ProjectDataset.php");
require_once ("Models/UsersDataset.php");
require_once ("Models/WorkItemDataset.php");
require_once ('Models/CategoryItemSet.php');
require_once ('Models/OrganisationDataset.php');
require_once ('Models/TeamDataSet.php');
require_once ('Models/TeamMemberDataSet.php');
$view = new stdClass();
session_start();
$view->pageTitle = "User Portal";

$taskDataset = new WorkItemDataset();
$projectDataset = new ProjectDataset();
$usersDataset = new UsersDataset();
$categoryItemSet = new CategoryItemSet();
$organisationDataSet = new OrganisationDataset();
$teamDataSet = new TeamDataSet();
$teamMemberDataSet = new TeamMemberDataSet();
//$user = $usersDataset->fetchUserDetails($_SESSION['email']);
if(!empty($_GET['pagename'])) {
    $categoryPageSwitch = $_GET['pagename'];
}

if(isset($_SESSION['email'])){
    $confirm = $_SESSION['email'];
}
$orgID = $organisationDataSet->getAdminOrganizationID($confirm);
$view->organisationDataSet = $organisationDataSet->getName($orgID);
$view->categoryItemSet = $categoryItemSet->fetchCategoriesFor($orgID);
$view->projectDataset = $projectDataset->fetchProjectForUser($_SESSION['userID']);
$view->teamMemberDataSet = $teamMemberDataSet->fetchAllMembers();
$organisationAllMembers = $organisationDataSet->getOrganisationMembers($orgID);

if(!empty($categoryPageSwitch)) {
    $view->teamDataSet = $teamDataSet->fetchCategoryTeams($categoryPageSwitch, $orgID);
    $categoryID = $categoryItemSet->getCategory($categoryPageSwitch);
     $ID = $categoryID->getCategoryID();

}

if(isset($_GET['showTeams'])){
    $view->teamDataset = $teamDataSet->getAllUserTeams($_SESSION['userID']);
}



// if the user submitted the form to create a project
if(isset($_POST['projectSubmitBtn'])){
    $projectName = $_POST['projectName'];
    $projectDataset->createUserProject($_SESSION['userID'], $projectName);
    header('Location: '.$_SERVER['REQUEST_URI']);
}

// if the user submitted the form to add task
if(isset($_POST['taskSubmitBtn'])){
    $name = trim($_POST['taskName']);
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $comments = $_POST['comments'];
    $effort = $_POST['effort'];
    $projectID = $_GET['projectID'];
    $taskDataset->addWorkItem($name, $startDate, $endDate, $comments, $effort, $projectID);
}

//if the user submitted the form to delete a project
if(isset($_POST['delProjectSubmitBtn'])){
    $nameOfProject = trim($_POST['projectName']);
    // verify if that project exists for the user
    $allProjects = $projectDataset->fetchProjectForUser($_SESSION['userID']);
    $isValid = false;
    foreach ($allProjects as $project){
        if($nameOfProject == $project->getProjectName()){
            $isValid = true;
        }
    }
    if($isValid){
        $project = $projectDataset->fetchProject($nameOfProject);
        $projectID = $project->getProjectId();
//        $projectDataset->deleteTask($projectID);
        $projectDataset->deleteProject($projectID);
//    echo $nameOfProject;
        header('Location: '.$_SERVER['REQUEST_URI']);

    }else{
        $view->invalid = "Couldn't find a project with that name";
    }

}
if(isset($_POST['createCategoryBtn'])) {
    if(isset($_POST['category'])){
        $categoryName = $_POST['category'];
        $categoryItemSet->createCategory($categoryName);
        //$connect= $_POST['organisation_id'];//this line is supposed to connect the organisation and category
        $categoryItemSet->assignCategoryTo($orgID, $categoryName);
        header("Location:userportal.php");
    }
    else{
        $view->invalid = "Action failed, try again.";
    }
}

if(isset($_POST['addTeamBtn'])) {
// Validating all the data before inserting it into the database
    $team_name = $_POST['teamName'];
    $category_id = $_POST['categoryID'];

//     Creating teams for admin of organisation
    $teamDataSet = new TeamDataset();
    $teamDataSet->createTeam($team_name, $category_id,$orgID);
    $userID = $_SESSION['userID'];
    $teamData = $teamDataSet->fetchTeamID($team_name, $orgID);
    $teamID = $teamData->getTeamID();
    $teamMemberDataSet->addMember($userID ,$teamID, true);
    header("location:userportal.php");

}

if(isset($_POST['removeCategoryBtn'])) {
    if(isset($_POST['categoryName'])) {
        $categoryName = $_POST['categoryName'];
        $categoryItemSet->deleteCategoryFor($orgID, $categoryName);
        header("location:userportal.php");
    }
}
//Creating teams for user

// Get all categories for the create team form
$organisationID = $usersDataset->getUserOrganisation()->getOrganisationID();
$categoryDataset = new CategoryItemSet();
$view->categoryDataset = $categoryDataset->fetchCategoriesFor($organisationID);

if(isset($_POST['teamSubmitBtn'])){
    $teamName = trim($_POST['teamName']);
    $categoryName = $_POST['category'];
    $categoryID = $categoryDataset->getCategory($categoryName)->getCategoryID();
    $teamDataSet->createTeam($teamName, $categoryID, $organisationID);
    $teamID = $teamDataSet->fetchTeamID($teamName, $organisationID)->getTeamID();
//    make the creator the team leader
    $teamMemberDataSet->addMember($_SESSION['userID'], $teamID, 1);
    header("Location: userportal.php?showTeams=true");
}
require_once("Views/userportal.phtml");