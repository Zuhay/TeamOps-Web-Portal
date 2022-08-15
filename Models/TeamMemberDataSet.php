<?php

require_once ("Models/User.php");
class TeamMemberDataSet
{
    protected $_dbHandle, $_dbInstance;

    public function __construct()
    {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();

    }

    public function memberExists($teamName){
        $sqlQuery = 'SELECT * FROM TeamMember WHERE userID = ?';
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(1,$teamName);
        $statement->execute();
        $dataSet = [];
        while ( $row = $statement->fetch()) {
            $dataSet[] = new Team($row);
        }
        if(count($dataSet) < 1 ){
            return false;
        }else{
            return $dataSet;
        }
    }

    public function fetchTeamMembers($teamID){
        $sqlQuery = 'SELECT * FROM Users,TeamMember,Team WHERE Users.user_id = TeamMember.userID AND TeamMember.teamID = Team.teamID AND Team.teamID = ?';

        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->bindParam(1, $teamID);
        $statement->execute(); // execute the PDO statement
        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new User($row);
        }
        return $dataSet;
    }


        public function fetchAllMembers(){
        $sqlQuery = 'SELECT * FROM Users,TeamMember,Team WHERE Users.user_id = TeamMember.userID AND Team.teamID = TeamMember.teamID ';

        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new User($row);
        }
        return $dataSet;
    }

    public function addMember($userID,$teamID, $isTeamLeader){
        $sqlQuery = 'INSERT INTO TeamMember (userID, teamID, isTeamLeader)  values (?,?,?)';

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(1,$userID);
        $statement->bindParam(2,$teamID);
        $statement->bindParam(3, $isTeamLeader);
        $statement->execute();
    }

    public function removeTeamMember($userID){
//        Remove team member
        $sqlQuery = 'DELETE FROM TeamMember WHERE TeamMember.userID = ? ';
        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->bindParam(1,$userID);
        $statement->execute(); // execute the PDO statement
    }

    public function getAllTeamMembers($teamID){
        $sqlQuery = "SELECT * FROM TeamMember, Users WHERE TeamMember.userID = Users.user_id AND TeamMember.teamID = $teamID";
        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement

        $dataset = [];
        while($row = $statement->fetch()){
            $dataset[] = new User($row);
        }
        return $dataset;
    }
}