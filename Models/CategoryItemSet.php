<?php
require_once ('Models/Database.php');
require_once ('Models/CategoryItem.php');

class CategoryItemSet
{
    protected $_dbHandle, $_dbInstance;

    public function __construct() {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    public function fetchCategoriesFor($organisationID) {
        $sqlQuery = 'SELECT Category.category_id, Category.category_name FROM Category, Organisation, OrganisationCategory WHERE Organisation.organisation_id = OrganisationCategory.organisation_id AND Category.category_id = OrganisationCategory.categoryID AND Organisation.organisation_id= ?';
        $statement = $this->_dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->bindParam(1, $organisationID);
        $statement->execute(); // execute the PDO statement

        $dataSet = [];
        while ( $row =$statement->fetch()) {
            $dataSet[] = new CategoryItem($row);
        }
        return $dataSet;
    }

    public function createCategory($categoryName){
        if($this->categoryExists($categoryName) != false){
           return false;
        }else{
            $sqlQuery = 'INSERT INTO Category (category_name) values (?)';

            $statement = $this->_dbHandle->prepare($sqlQuery);
            $statement->bindParam(1,$categoryName);
            $statement->execute();
            return true;
        }
    }

    public function categoryExists($categoryName){
        $sqlQuery = 'SELECT * FROM Category WHERE category_name = ?';
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(1,$categoryName);
        $statement->execute();
        $dataSet = [];
        while ( $row = $statement->fetch()) {
            $dataSet[] = new CategoryItem($row);
        }
        if(count($dataSet) < 1 ){
            return false;
        }else{
            return $dataSet;
        }
    }

    public function getCategoryTeam($categoryName){
        $sqlQuery = 'SELECT * FROM Category WHERE category_name = ?';
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(1,$categoryName);
        $statement->execute();
        $dataSet = [];
        while ( $row = $statement->fetch()) {
            $dataSet[] = new CategoryItem($row);
        }
        return $dataSet[0];
    }

    public function getCategory($categoryName){
        $sqlQuery = 'SELECT * FROM Category WHERE category_name = ?';
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(1,$categoryName);
        $statement->execute();
        $dataSet = [];
        $row =$statement->fetch();
        $dataSet[] = new CategoryItem($row);
        return $dataSet[0];
    }

    public function assignCategoryTo($organisationID, $categoryName){
        $value = $this->categoryExists($categoryName);
        if( $value != false){
            $itemData = $value[0];
            $categoryID = $itemData->getCategoryID();
        }else{
            $this->createCategory($categoryName);
            $newValue = $this->categoryExists($categoryName);
            $itemData = $newValue[0];
            $categoryID = $itemData->getCategoryID();
        }

        $sqlQuery = 'INSERT INTO OrganisationCategory (organisation_id, categoryID) values (?,?)';

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(1,$organisationID);
        $statement->bindParam(2,$categoryID);
        $statement->execute();
    }

    public function deleteCategoryFor($organisationID, $categoryName){
        $value = $this->categoryExists($categoryName);
        if( $value != false) {
            $itemData = $value[0];
            $categoryID = $itemData->getCategoryID();

            $sqlQuery = 'DELETE FROM OrganisationCategory WHERE categoryID = ? AND organisation_id = ? ';
            $statement = $this->_dbHandle->prepare($sqlQuery);
            $statement->bindParam(1, $categoryID);
            $statement->bindParam(2,$organisationID);
            $statement->execute();
          }

    }


}