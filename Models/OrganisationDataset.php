<?php

require_once ("Models/User.php");
require_once("Models/Organisation.php");
require_once ("Models/Database.php");

class OrganisationDataset
{
    protected $_dbHandle, $_dbInstance;

    public function __construct(){
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    public function register($name, $emailDomain, $contactNo, $adminID){
        // check if the company is already registered
        $sqlQuery = "SELECT * FROM Organisation WHERE organisation_name = '$name'";
//        echo $sqlQuery;
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();
        $row = $statement->fetch();

        if(empty($row)){
            // if the organization is not registered, register the organization and return true
            $sqlQuery = "INSERT INTO Organisation (organisation_name, organisation_email_domain, organisation_contact_number, organisation_admin_id)
                            VALUES(?, ?, ?, ?)";
//            echo $sqlQuery;
            $statement = $this->_dbHandle->prepare($sqlQuery);
            $parameters = array($name, $emailDomain, $contactNo, $adminID);
            $statement->execute($parameters);
            return true;
        }else{
            // return false if the organization is already registered
            return false;
        }
    }

    public function fetchAllOrganisations(){
        $sqlQuery = "SELECT * FROM Organisation";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute(); // execute the PDO statement

        $dataSet = [];
        while ( $row =$statement->fetch()) {
            $dataSet[] = new Organisation($row);
        }
        return $dataSet;
    }
    public function getOrganisationMembers($organisationID){

        $sqlQuery = 'SELECT * FROM Users WHERE organization_id = ?';
        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->bindParam(1, $organisationID);
        $statement->execute(); // execute the PDO statement


        $dataSet = [];
        while ( $row =$statement->fetch()) {
            $dataSet[] = new User($row);
        }
        return $dataSet;
    }

    public function getOrganisation($organisationID){

        $sqlQuery = 'SELECT * FROM Organisation WHERE organisation_id= ?';
        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->bindParam(1, $organisationID);
        $statement->execute(); // execute the PDO statement


        $dataSet = [];
        while ( $row =$statement->fetch()) {
            $dataSet[] = new Organisation($row);
        }
        return $dataSet;
    }

    public function getName($organisationID){

        $sqlQuery = 'SELECT organisation_name FROM Organisation WHERE organisation_id= ?';
        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->bindParam(1, $organisationID);
        $statement->execute(); // execute the PDO statement

        $name = $statement->fetch();
//
        $itemData = $name[0];
//        $organisationName = $itemData->getOrganisationName();
        return $itemData;

//        $dataSet = "";
//        if($row = $statement->fetch())
//            $dataSet = new Organisation($row);
//
//        return $dataSet;
    }

    public function getAdminOrganizationID($adminEmail){
        $value = 'admin';
        $sqlQuery = 'SELECT * FROM Organisation,Users WHERE Organisation.organisation_admin_id = Users.user_id AND Users.last_name = ? AND Users.email_address = ?';
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(1, $value);
        $statement->bindParam(2, $adminEmail);
        $statement->execute();

        $dataSet = [];
        $row =$statement->fetch();
       $dataSet = $row[0];
        return $dataSet;
//        $dataSet = "";
//        if($row = $statement->fetch())
//            $dataSet = new Organisation($row);
//
//        return $dataSet;

    }

    public function  getOrganization($organizationName){
        $sqlQuery = "SELECT * FROM Organisation WHERE organisation_name = ?";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(1, $organizationName);
        $statement->execute();

        $row = $statement->fetch();
        $org = new Organisation($row);
        return $org;
    }

    /**
     * @param $domain
     * @return bool
     */
    public function validateOrganisationDomain($domain){
        $sqlQuery = "SELECT * FROM Organisation WHERE organisation_email_domain = ?";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(1, $domain);
        $statement->execute();

        $row = $statement->fetch();
        if(empty($row)){
            return false;
        }else{
            return true;
        }
    }
}