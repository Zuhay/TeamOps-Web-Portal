<?php
require_once("Models/SearchDataset.php");
require_once("Models/UsersDataset.php");
require_once("Models/ProjectDataset.php");
require_once("Models/User.php");
require_once ("Models/TeamDataSet.php");
require_once ("Models/OrganisationDataset.php");

$view = new stdClass();
session_start();
$view->pageTitle="Teams";

$searchDataset = new SearchDataset();
$usersDataset = new UsersDataset();
$projectDataset = new ProjectDataset();
$teamDataSet = new TeamDataSet();
$organisationDataSet = new OrganisationDataset();

if(isset($_SESSION['email'])){
    $confirm = $_SESSION['email'];
}
$orgID = $organisationDataSet->getAdminOrganizationID($confirm);

$view->teamDataSet = $teamDataSet->fetchAllOrganisationTeams($orgID);



// get all tasks for a project
    $view->noOfTeams = $teamDataSet->getNoOfTeams() . " team(s) in this organisation ";

require_once ("Views/teams.phtml");
