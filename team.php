<?php
require_once ("Models/TeamDataSet.php");
require_once ("Models/TeamMemberDataSet.php");
require_once ("Models/ProjectDataSet.php");
require_once ("Models/UsersDataset.php");
$view = new stdClass();
$view->pageTitle = "Team";

session_start();

$teamDataset = new TeamDataSet();
$projectDataset = new ProjectDataset();
$teamMemberDataset = new TeamMemberDataSet();
$usersDataset = new UsersDataset();
if(isset($_GET['teamID'])){
    $teamID = $_GET['teamID'];
    $view->team = $teamDataset->getTeam($teamID);
    $view->members = $teamMemberDataset->fetchTeamMembers($teamID);
    $view->projectDataset = $projectDataset->getTeamProjects($teamID);



//    add team project
    if(isset($_POST['projectSubmitBtn'])){
        $projectName = $_POST['projectName'];
        $projectDataset->createTeamProject($teamID, $projectName);
        header("Location: team.php?teamID=" . $teamID);
    }

}
if(isset($_GET['teamID']) && isset($_GET['showMembers'])){
    $view->teamMembers = $teamMemberDataset->getAllTeamMembers($teamID);
}

require_once ("Views/team.phtml");