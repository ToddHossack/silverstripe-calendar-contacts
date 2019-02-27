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

        $options = CMDirectoryEntry::get()->map('ID','FullName')->toArray();
        asort($options);
        
        $contactsFields = ListboxField::create('Contacts',
            _t('CalendarContactsEventExtension.Contacts','Contacts'),
            $options, '', 5, true
        );
        
        $fields->addFieldToTab('Root.Contacts',$contactsFields);
    }

}
