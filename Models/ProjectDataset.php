<?php
require_once ('Models/Database.php');
require_once ('Models/Project.php');
require_once ('Models/WorkItem.php');

class ProjectDataset
{
    protected $_dbHandle, $_dbInstance;

    public function __construct()
    {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();

    }
    //    Returns all projects
    public function fetchAllProjects()
    {
        $sqlQuery = 'SELECT * FROM Project';

        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new Project($row);
        }
        return $dataSet;

    }
//    Return project for given project name
     public function fetchProject($project_name)
     {
         $userID = $_SESSION['userID'];
         $sqlQuery = "SELECT * FROM Project WHERE project_name='$project_name' AND userID = $userID";

         $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
         $statement->execute(); // execute the PDO statement

         if ($row = $statement->fetch()) {
             $project = new Project($row);
         }
         return $project;
     }

     public function getProject($projectID){
        $sqlQuery = "SELECT * FROM Project WHERE project_id = $projectID";
         $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
         $statement->execute(); // execute the PDO statement

         if ($row = $statement->fetch()) {
             $project = new Project($row);
         }
         return $project;
     }

//    Create a user project
    public function createUserProject($userID, $projectName)
    {
        $query ="INSERT INTO Project (project_name, userID) VALUES ('$projectName', $userID)";

        //Execute the query
        $statement = $this->_dbHandle->prepare($query); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement
    }

    //    Create a user project
    public function createTeamProject($teamID, $projectName)
    {
        $query ="INSERT INTO Project (project_name, teamID) VALUES ('$projectName', $teamID)";

        //Execute the query
        $statement = $this->_dbHandle->prepare($query); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement
    }

//    Remove project from database
    public function removeProject($project_name)
    {

        $query ="DELETE FROM Project WHERE Project.project_name='$project_name' ";
        //Execute the query
        $statement = $this->_dbHandle->prepare($query); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement
    }

    //    Return  project and userProject details if user id exists
    public function fetchProjectForUser($user_id)
    {
        $sqlQuery = "SELECT * FROM Project WHERE userID = $user_id";


        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new Project($row);
        }
        return $dataSet;
    }

//    Check if project exists
     public function checkProject($project_name){
         $sqlQuery = "SELECT * FROM Project WHERE Project.project_name='$project_name'";

         $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
         $statement->execute(); // execute the PDO statement

         $dataSet = '';
         if ($row = $statement->fetch()) {
             $dataSet = new Project($row);
         }
         if($dataSet=='')
             return false;
         else
             return true;
     }

    public function deleteProject($projectID){
//        Remove the all the tasks  for that project from the database
        $query = "DELETE FROM WorkItem WHERE WorkItem.project_id = $projectID";
        $secStatement = $this->_dbHandle->prepare($query); // prepare a PDO statement
        $secStatement->execute(); // execute the PDO statement

//        Remove the Project from the database
        $sqlQuery = "DELETE FROM Project WHERE project_id = '$projectID'";
//        $sqlQuery = "DELETE Project, WorkItem FROM Project INNER JOIN WorkItem ON WorkItem.project_id = Project.project_id WHERE Project.project_id = $projectID AND Project.userID = $userID";
        echo $sqlQuery;
        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement
    }
    //user view
    public function getTeamProjects($teamID){
        $sqlQuery = "SELECT * FROM Project WHERE teamID = $teamID";


        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new Project($row);
        }
        return $dataSet;
    }
    //admin view
    public function fetchTeamProjects($teamID)
    {
        $sqlQuery = 'SELECT * FROM Project WHERE Project.teamID= ?';
        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->bindParam(1, $teamID);
        $statement->execute(); // execute the PDO statement
        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new Project($row);
        }
        return $dataSet;
    }
}