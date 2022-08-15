<?php


class User
{
    // declare the fields needed for a user
    private $userID, $firstName, $lastName, $emailAddress, $password, $jobTitle, $organizationID, $imageID;

    /**
     * User constructor.
     * @param $dbRow
     */
    public function __construct($dbRow){
        //initialize the fields by getting the values from the database
        $this->userID = $dbRow['user_id'];
        $this->firstName = $dbRow['first_name'];
        $this->lastName = $dbRow['last_name'];
        $this->emailAddress = $dbRow['email_address'];
        $this->password = $dbRow['password'];
        $this->jobTitle = $dbRow['job_title'];
        $this->organizationID = $dbRow['organization_id'];
        $this->imageID = $dbRow['imageID'];
    }

    /**
     * @return mixed : return the id of the user
     */
    public function getUserID()
    {
        return $this->userID;
    }


    /**
     * @return mixed : return the first name of the user
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return mixed : return the last name of the user
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return mixed : return the email address of the user
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * @return mixed : return the password of the user
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getJobTitle()
    {
        return $this->jobTitle;
    }

    /**
     * @return mixed
     */
    public function getOrganizationID()
    {
        return $this->organizationID;
    }

    /**
     * @return mixed
     */
    public function getImageID()
    {
        return $this->imageID;
    }
}