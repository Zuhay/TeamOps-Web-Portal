<?php


class Team
{
    protected $teamID, $teamName;

    public function __construct($dbRow)
    {
        $this->teamID = $dbRow['teamID'];
        $this->teamName = $dbRow['team_name'];
    }

    /**
     * @return mixed
     */
    public function getTeamID()
    {
        return $this->teamID;
    }

    /**
     * @return mixed
     */
    public function getTeamName()
    {
        return $this->teamName;
    }

    /**
     * @param mixed $teamName
     */
    public function setTeamName($teamName)
    {
        $this->teamName = $teamName;
    }

    /**
     * @param mixed $teamID
     */
    public function setTeamID($teamID)
    {
        $this->teamID = $teamID;
    }
}