<?php


class CalendarDirectoryEntryExtension extends DataExtension {

    private static $belongs_many_many = array(
		'Events' => 'Event'
	);
    
}
