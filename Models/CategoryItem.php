<?php


class CategoryItem
{
    protected $_categoryID, $_categoryName;

    public function __construct($dbRow)
    {
        $this->_categoryID = $dbRow['category_id'];
        $this->_categoryName = $dbRow['category_name'];

    }

    public function getCategoryID() {
        return $this->_categoryID;
    }

    public function getCategoryName() {
        return $this->_categoryName;
    }



}