<?php


class CalendarContactsEventExtension extends DataExtension {

    private static $many_many = array(
		'Contacts' => 'CMDirectoryPersonEntry'
	);
    
    private static $many_many_extraFields = [
        'Contacts' => [
          'Sort' => 'Int'
        ]
    ];
    
    public function updateCMSFields(FieldList $fields)
    {
        $contacts = $fields->fieldByName('Contacts');

        // Add tab
		$fields->findOrMakeTab(
			'Root.Contacts', _t('CalendarContactsEventExtension.ContactsTab','Contacts')
		);
        
        // GridField
        $gridFieldConf = GridFieldConfig_RecordEditor::create();
        // Auto completer
        $autoCompleter = new GridFieldAddExistingAutocompleter();
        $autoCompleter->setResultsFormat('$FullName ($Email)')->setSearchFields(['LastName','Name','Email']);
        $autoCompleter->setSearchList(CMDirectoryPersonEntry::get());
        $gridFieldConf->addComponent($autoCompleter);
        // Sorting - @todo Sorting relation on front end doesn't seem to work with SS3
        if (class_exists('GridFieldOrderableRows')) {
            $gridFieldConf->addComponent(new GridFieldOrderableRows('Sort'));
        } elseif (class_exists('GridFieldSortableRows')) {
            $gridFieldConf->addComponent(new GridFieldSortableRows('Sort'));
        }
        // Make field
        $contactsField = GridField::create('Contacts', 
            _t('CalendarContactsEventExtension.Contacts','Contacts'), 
            $this->owner->SortedContacts(), 
            $gridFieldConf
        );

        $fields->addFieldToTab('Root.Contacts',$contactsField);
    }
    
    public function SortedContacts()
    {
        return $this->owner->Contacts()->sort('Sort','ASC');
        
    }
    public function onBeforeDelete() 
    {
        //$this->owner->Contacts()->removeAll();
	}


}
