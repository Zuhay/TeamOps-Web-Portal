<?php

require_once ('Database.php');
require_once ('Models/Team.php');

class TeamDataSet
{
    protected $_dbHandle, $_dbInstance;
    private $noOfTeams;

    public function __construct()
    {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();

    }

    //    Returns all user projects
    public function fetchAllTeams()
    {
        $sqlQuery = 'SELECT * FROM Team';


        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement

        $statement->execute(); // execute the PDO statement


        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new Team($row);
        }
        return $dataSet;

    }


    public function fetchAllOrganisationTeams($orgID)
    {
        $sqlQuery = 'SELECT * FROM Team WHERE organisationID = ?';


        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->bindParam(1, $orgID);
        $statement->execute(); // execute the PDO statement


        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new Team($row);
        }
        $this->noOfTeams = count($dataSet);
        return $dataSet;

    }

    public function fetchCategoryTeams($categoryName, $organisationID)
    {
        $sqlQuery = 'SELECT * FROM Team,Category WHERE Team.categoryID = Category.category_id AND Category.category_name = ? AND organisationID = ?';

        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->bindParam(1, $categoryName);
        $statement->bindParam(2, $organisationID);
        $statement->execute(); // execute the PDO statement

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new Team($row);
        }
        return $dataSet;

    }

    //    return a dataset of all the teams the user is a member of
    public function getAllUserTeams($userID){
        $sqlQuery = "SELECT * FROM Team, TeamMember WHERE Team.teamID = TeamMember.teamID AND TeamMember.userID = $userID";
        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement
        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new Team($row);
        }
        return $dataSet;
    }


    public function fetchTeamID($teamName, $organisationID){
        $sqlQuery = "SELECT * FROM Team WHERE team_name = ? AND organisationID = ?";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(1, $teamName);
        $statement->bindParam(2, $organisationID);
        $statement->execute();

        $row = $statement->fetch();
        $org = new Team($row);
        return $org;
    }

    public function createTeam($team_name, $categoryID, $organisationID){
        $sqlQuery ="INSERT INTO Team (team_name, categoryID, organisationID) VALUES (?,?,?) ";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(1, $team_name);
        $statement->bindParam(2, $categoryID);
        $statement->bindParam(3, $organisationID);
        //Execute the query
        $statement->execute(); // execute the PDO statement
    }

    public function deleteTeam($team_id){
        $query ="DELETE FROM Team WHERE teamID = ?";

        //Execute the query
        $statement = $this->_dbHandle->prepare($query); // prepare a PDO statement
        $statement->bindParam(1, $team_id);
        $statement->execute(); // execute the PDO statement
    }

    public function getTeam($teamID){
        $sqlQuery = "SELECT * FROM Team WHERE Team.teamID = ?";
        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->bindParam(1, $teamID);
        $statement->execute(); // execute the PDO statement

        $row = $statement->fetch();
        return new Team($row);
    }

    /**
     * @return int
     */
    public function getNoOfTeams()
    {
        return $this->noOfTeams;
    }
}