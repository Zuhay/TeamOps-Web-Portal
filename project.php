<?php
require_once ("Models/ProjectDataset.php");
require_once ("Models/WorkItemDataset.php");
$view = new stdClass();
$view->pageTitle  = "Project";

session_start();

$taskDataset = new WorkItemDataset();
$projectDataset = new ProjectDataset();

// if the user click to view a project from the user portal view
if(isset($_GET['projectID'])){
    $projectID =  $_GET['projectID'];
    $view->projectID = $projectID;
    $view->projectName = $projectDataset->getProject($projectID)->getProjectName();

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
        $projectDataset->deleteProject($projectID);
        //        redirect to the view all userportal page
        header('Location: userportal.php');
    }
}


require_once ("Views/project.phtml");
?>
