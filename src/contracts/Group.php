<?php

namespace Farshad\Sms\Contracts;

interface Group
{

    /**
     * Get the groups details
     */
    public function groups();

    /**
     * Return contacts data in the address book
     */
    public function contacts();

    /**
     * Create new group in the address book
     */
    public function createGroup();


    /**
     * Add the user to the group in the address book
     */
    public function addContact();


    /**
     * Check the contact exists in the address book
     */
    public function checkContact();

    /**
     * Update the contact details in the address book
     */
    public function updateContact();

    /**
     * Delete the contact from address book
     */
    public function deleteContact();


}