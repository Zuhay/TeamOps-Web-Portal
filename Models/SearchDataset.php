<?php

require_once("Models/Database.php");
require_once("Models/WorkItem.php");
require_once("Models/Project.php");
class SearchDataset
{
    // store the number of search results
    private $noOfSearchResults;
    public function __construct(){
        $this->dbInstance = Database::getInstance();
        $this->_dbHandle = $this->dbInstance->getdbConnection();
        $this->noOfSearchResults = 0;
    }

    //    Fetch work item for particular user
     public function fetchWorkItems($projectID)
     {

         $userID = $_SESSION['userID'];
         $sqlQuery = "select * from WorkItem, Project where WorkItem.project_id = Project.project_id AND Project.userID = $userID AND WorkItem.project_id = $projectID;";

         $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
         $statement->execute(); // execute the PDO statement

         $dataSet = [];

         while ($row = $statement->fetch()) {
             $dataSet[] = new WorkItem($row);
         }
         $this->noOfSearchResults = count($dataSet);
         return $dataSet;
     }

    /**
     * @return int
     */
    public function getNoOfSearchResults()
    {
        return $this->noOfSearchResults;
    }


}