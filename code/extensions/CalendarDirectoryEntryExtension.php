<?php


class CalendarDirectoryEntryExtension extends DataExtension {

    private static $belongs_many_many = array(
		'Events' => 'Event'
	);
    
    
    public function updateCMSFields(FieldList $fields)
    {
        // Remove events gridfield
        $fields->removeByName('Events');
    }
    
}
