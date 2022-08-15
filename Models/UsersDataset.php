<?php

require_once ("Models/User.php");
require_once ("Models/Database.php");

/**
 * Class UsersDataset
 * This class will be used to query the User database
 */
class UsersDataset
{
    public function __construct(){
        $this->dbInstance = Database::getInstance();
        $this->dbHandle = $this->dbInstance->getdbConnection();
    }

    public function verifyLoginDetails($email, $password){
        $sqlQuery = "SELECT * FROM Users WHERE email_address = ?";
//        echo $sqlQuery;
        $statement = $this->dbHandle->prepare($sqlQuery);
        $statement->bindParam(1, $email);
        $statement->execute();

        $row = $statement->fetch();
        $user = new User($row);
        //de-encrypt the password
        if(password_verify($password, $user->getPassword())){
            return true;
        }else{
            return false;
        }
    }

    public function signup($firstName, $lastName, $emailAddress, $password, $jobTitle, $organizationID)
    {
        // check if a user with that username already exists
        $sqlQuery = "SELECT * FROM Users WHERE email_address = ?";
        $statement = $this->dbHandle->prepare($sqlQuery);
        $statement->bindParam(1, $emailAddress);
        $statement->execute();
        $row = $statement->fetch();
        if (empty($row)) {
            $sqlQuery = "INSERT INTO Users(first_name, last_name, email_address, password, job_title, organization_id) VALUES(?, ?, ?, ?, ?, ?)";

            $statement = $this->dbHandle->prepare($sqlQuery);
            $parameters = array($firstName, $lastName, $emailAddress, $password, $jobTitle, $organizationID);
            $statement->execute($parameters);
            return true;
        } else {
            return false;
        }
    }

    public function fetchUserDetails($email){
        $sqlQuery = "SELECT * FROM Users WHERE email_address = ?";
        $statement = $this->dbHandle->prepare($sqlQuery);
        $statement->bindParam(1, $email);
        $statement->execute();

        $row = $statement->fetch();
        $user = new User($row);
        return $user;
    }

    public function setOrganizationID($adminEmail, $orgID){
        $sqlQuery = "UPDATE Users SET organization_id = $orgID WHERE email_address='$adminEmail'";
        $statement = $this->dbHandle->prepare($sqlQuery);
        $statement->execute();
    }

    public function editInUser($fieldToEdit, $value, $userID){
        $sqlQuery = "UPDATE Users SET ".$fieldToEdit." = ?  WHERE user_id = ?";
        $statement = $this->dbHandle->prepare($sqlQuery);
        $statement->bindParam(1, $value);
        $statement->bindParam(2, $userID);

        $statement->execute();
    }

    public function getUserOrganisation(){
        $userID = $_SESSION['userID'];
        $sqlQuery = "SELECT * FROM Organisation, Users WHERE Organisation.organisation_id = Users.organization_id AND Users.user_id = $userID";
        $statement = $this->dbHandle->prepare($sqlQuery);
        $statement->execute();

        $row = $statement->fetch();
        return new Organisation($row);
    }

}