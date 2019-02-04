<?php


class CalendarContactsEventExtension extends DataExtension {

    private static $many_many = array(
		'Contacts' => 'CMDirectoryEntry'
	);
    
    public function updateCMSFields(FieldList $fields)
    {
        // Add tab
		$fields->findOrMakeTab(
			'Root.Contacts', _t('CalendarContactsEventExtension.ContactsTab','Contacts')
		);
        /*
        $source = function() {
            return EventContact::get()->map()->toArray();
        };
        
        $contactsField = DropdownField::create('ConID', _t('CalendarContactsEventExtension.LocationField', 'Select location'), $source())
            ->setHasEmptyDefault(true)
            ->useAddNew('EventLocation',$source);
		$fields->addFieldToTab('Root.Location',$locationField);
        */
    }

}
