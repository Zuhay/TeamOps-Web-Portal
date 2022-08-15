<?php


class Project
{
    // declare the fields needed for a project
    private $project_id, $project_name, $userID, $teamID;

    public function __construct($dbRow)
    {
        //initialize the fields by getting the values from the database
        $this->project_id = $dbRow['project_id'];
        $this->project_name = $dbRow['project_name'];
        $this->userID = $dbRow['userID'];
        $this->teamID = $dbRow['teamID'];
    }

//    Return project id
    public function getProjectId()
    {
        return $this->project_id;
    }

    public function getProjectName()
    {
        return $this->project_name;
    }

    /**
     * @return mixed
     */
    public function getUserID()
    {
        return $this->userID;
    }

    /**
     * @return mixed
     */
    public function getTeamID()
    {
        return $this->teamID;
    }



}