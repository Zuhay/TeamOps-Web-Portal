<?php
require_once('Models/OrganisationDataset.php');
require_once('Models/TeamMemberDataSet.php');
require_once('Models/ProjectDataset.php');
$view = new stdClass();
session_start();
$view->pageTitle="TeamView";

$organisationDataSet = new OrganisationDataset();
if(isset($_SESSION['email'])){
    $confirm = $_SESSION['email'];
}
$orgID = $organisationDataSet->getAdminOrganizationID($confirm);
$view->organisationName = $organisationDataSet->getName($orgID); //Getting the name of the organisation

$view->teamName = $_GET['teamName']; // Getting team name
$teamID = $_GET['teamID']; // Getting team id
$teamMemberDataSet = new TeamMemberDataSet();
$view->teamMemberDataSet = $teamMemberDataSet->fetchTeamMembers($teamID); //Fetch team members

$projectDataSet = new ProjectDataset();
$view->projectDataSet = $projectDataSet->fetchTeamProjects($teamID);

require_once("Views/teamview.phtml");