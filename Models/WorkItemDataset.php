<?php
require_once ('Models/Database.php');
require_once ('Models/WorkItem.php');
//require_once ('Models/Project.php');

class WorkItemDataset
{
    protected $_dbHandle, $_dbInstance;

    public function __construct()
    {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();

    }
//    Returns all work items of a particular project id
    public function fetchAllWorkItems()
    {
        $sqlQuery = 'SELECT * FROM WorkItem,Project WHERE WorkItem.project_id =Project.project_id ';

        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new WorkItem($row);
        }
        return $dataSet;

    }

//    Insert work item into WorkItem table
    public function addWorkItem($work_item_name, $work_item_start_date, $work_item_end_date,$work_item_comments,$work_item_effort,$project_id)
    {
        $query ="INSERT INTO WorkItem (work_item_name,work_item_start_date,work_item_end_date,work_item_comments,work_item_effort,project_id) VALUES ('$work_item_name', '$work_item_start_date', '$work_item_end_date','$work_item_comments','$work_item_effort','$project_id')";

        //Execute the query
        $statement = $this->_dbHandle->prepare($query); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement
    }

    //    Remove work item from WorkItem table
    public function deleteWorkItem($work_item_id)
    {
        $query ="DELETE FROM WorkItem WHERE WorkItem.work_item_id = $work_item_id";
        //Execute the query
        $statement = $this->_dbHandle->prepare($query); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement
    }

    public function getWorkItem($taskID)
    {
        $query ="SELECT * FROM WorkItem WHERE WorkItem.work_item_id = $taskID";
        //Execute the query
        $statement = $this->_dbHandle->prepare($query); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement
        $row = $statement->fetch();
        return new WorkItem($row);
    }

    public function edit($taskID, $column, $value){
        $sqlQuery = "UPDATE WorkItem SET $column = $value WHERE work_item_id = $taskID";
        echo $sqlQuery;
        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement
    }

}