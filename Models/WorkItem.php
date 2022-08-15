<?php


class WorkItem
{
//    declare work item fields
    private $work_item_id, $work_item_name, $work_item_category, $work_item_start_date, $work_item_end_date,$work_item_comments,$work_item_effort,$project_id;

    public function __construct($dbRow) {
        $this->work_item_id= $dbRow['work_item_id'];
        $this->work_item_name = $dbRow['work_item_name'];
        $this->work_item_start_date= $dbRow['work_item_start_date'];
        $this->work_item_end_date= $dbRow['work_item_end_date'];
        $this->work_item_comments= $dbRow['work_item_comments'];
        $this->work_item_effort= $dbRow['work_item_effort'];
        $this->project_id= $dbRow['project_id'];


    }

//    Return the id of work item
    public function getWorkItemId() {
        return $this->work_item_id;
    }
//    Return name of work item
    public function getWorkItemName() {
        return $this->work_item_name;
    }
//      Return start date of work item
    public function getWorkItemStartDate() {
        return $this->work_item_start_date;
    }
//    Return end date of work item
    public function getWorkItemEndDate() {
        return $this->work_item_end_date;
    }
//      Return comments of work item
    public function getWorkItemComments() {
        return $this->work_item_comments;
    }
//    Return effort of work item
    public function getWorkItemEffort() {
        return $this->work_item_effort;
    }
//      Return project id of work item(foreign key)
    public function getProjectId() {
        return $this->project_id;
    }

}