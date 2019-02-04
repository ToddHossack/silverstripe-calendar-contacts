<?php


class CalendarDirectoryEntryExtension extends DataExtension {

    private static $belongs_many_many = array(
		'Events' => 'Event'
	);
    
    public function updateCMSFields(FieldList $fields)
    {
        // Add tab
        /*
		$fields->findOrMakeTab(
			'Root.Contacts', _t('CalendarContactsEventExtension.ContactsTab','Contacts')
		);

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
