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
        // Add tab
		$fields->findOrMakeTab(
			'Root.Contacts', _t('CalendarContactsEventExtension.ContactsTab','Contacts')
		);
        if($this->owner->exists()) {
            // GridField
            $gridFieldConf = GridFieldConfig_RecordEditor::create();
            // Auto completer
            $autoCompleter = new GridFieldAddExistingAutocompleter();
            $autoCompleter->setResultsFormat('$FullName ($Email)')->setSearchFields(['LastName','Name','Email']);
            $autoCompleter->setSearchList(CMDirectoryPersonEntry::get());
            $gridFieldConf->addComponent($autoCompleter);
            // Sorting
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
            
		} else {
            $fields->addFieldToTab('Root.Contacts', LiteralField::create('NotSaved', "<p class='message warning'>"._t('CalendarContactsEventExtension.AddContactsAfterSaving', 'Contacts may be added after the event has been saved for the first time.').'</p>'));
        }
        
        
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
