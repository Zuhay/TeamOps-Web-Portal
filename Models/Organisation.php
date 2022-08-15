<?php


class Organisation
{
    // fields needed for each organization
    protected $organisationID, $organisationName, $organisationAdminID, $organisationEmailDomain, $organisationContactNumber;

    public function __construct($dbRow){
        $this->organisationID = $dbRow['organisation_id'];
        $this->organisationName = $dbRow['organisation_name'];
        $this->organisationAdminID = $dbRow['organisation_admin_id'];
        $this->organisationEmailDomain = $dbRow['organisation_email_domain'];
        $this->organisationContactNumber = $dbRow['organisation_contact_number'];
    }

    /**
     * @return mixed
     */
    public function getOrganisationAdminID()
    {
        return $this->organisationAdminID;
    }

    /**
     * @return mixed
     */
    public function getOrganisationContactNumber()
    {
        return $this->organisationContactNumber;
    }

    /**
     * @return mixed
     */
    public function getOrganisationEmailDomain()
    {
        return $this->organisationEmailDomain;
    }

    /**
     * @return mixed
     */
    public function getOrganisationID()
    {
        return $this->organisationID;
    }

    /**
     * @return mixed
     */
    public function getOrganisationName()
    {
        return $this->organisationName;
    }

    /**
     * @param mixed $organisationAdminID
     */
    public function setOrganisationAdminEmail($organisationAdminID)
    {
        $this->organisationAdminID= $organisationAdminID;
    }

    /**
     * @param mixed $organisationContactNumber
     */
    public function setOrganisationContactNumber($organisationContactNumber)
    {
        $this->organisationContactNumber = $organisationContactNumber;
    }

    /**
     * @param mixed $organisationEmailDomain
     */
    public function setOrganisationEmailDomain($organisationEmailDomain)
    {
        $this->organisationEmailDomain = $organisationEmailDomain;
    }

    /**
     * @param mixed $organisationID
     */
    public function setOrganisationID($organisationID)
    {
        $this->organisationID = $organisationID;
    }

    /**
     * @param mixed $organisationName
     */
    public function setOrganisationName($organisationName)
    {
        $this->organisationName = $organisationName;
    }


}