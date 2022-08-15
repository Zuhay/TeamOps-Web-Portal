<?php require_once ("Models/WorkItemDataset.php");
$view = new stdClass();
session_start();
$view->pageTitle = "Task";

$taskDataset = new WorkItemDataset();
// if the user clicked on view in the search results page
if(isset($_GET['taskID'])){
    $taskID = $_GET['taskID'];
    $view->task = $taskDataset->getWorkItem($taskID);

    if(isset($_POST['editNameSubmitBtn'])){
        $taskName = "'" . $_POST['taskName'] . "'";
        $column = "work_item_name";
        $taskDataset->edit($taskID, $column, $taskName);
        //        refresh the page
        header('Location: '.$_SERVER['REQUEST_URI']);
    }

    // if the user attempted to change the start or end date
    if(isset($_POST['editDateSubmitBtn'])){
        $startDate = "'".$_POST['startDate'] . "'";
        $endDate =  "'" . $_POST['endDate'] . "'";
        if(isset($startDate)){
            $column = "work_item_start_date";
            $taskDataset->edit($taskID, $column, $startDate);
        }
        if(isset($endDate)){
            $column = "work_item_end_date";
            $taskDataset->edit($taskID, $column, $endDate);
        }
//        refresh the page
        header('Location: '.$_SERVER['REQUEST_URI']);
    }

//    if the user attempted to change the effort
    if(isset($_POST['editEffortSubmitBtn'])){
        $effort = $_POST['effort'];
        $column = "work_item_effort";
        $taskDataset->edit($taskID, $column, $effort);
        //        refresh the page
        header('Location: '.$_SERVER['REQUEST_URI']);
    }

//    if the user attempted to edit the comment
    if(isset($_POST['editCommentsSubmitBtn'])){
        $comments = "'" . $_POST['comments'] . "'";
        $column = "work_item_comments";
        $taskDataset->edit($taskID, $column, $comments);
        //        refresh the page
        header('Location: '.$_SERVER['REQUEST_URI']);
    }

    if(isset($_POST['deleteTaskSubmitBtn'])){
        $taskDataset->deleteWorkItem($taskID);
        //        redirect to the view all task page
        if(!isset($_GET['teamID'])){
            header('Location: search.php?projectID=' . $view->task->getProjectId());
        }else{
            header('Location: search.php?projectID=' . $view->task->getProjectId() . '&teamID=' . $_GET['teamID']);
        }
    }
}

require_once ("Views/task.phtml");