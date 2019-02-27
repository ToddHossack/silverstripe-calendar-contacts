<?php

class CalendarDirectoryExtension extends DataExtension {

  private static $default_events_directory = "Event Organizers";
  
  /**
   * Adds default groups
   */
  public function requireDefaultRecords() {
		$defaultRecordName = $this->owner->stat('default_events_directory');
        
        $className = $this->owner->class;

        // Check for existing record
        $res = DataModel::inst()->$className
              ->filter(array('Name' => $defaultRecordName))
              ->first();
        if($res) {
            return;
        }

        $obj = DataModel::inst()->$className->newObject([
            'Name' => $defaultRecordName
        ]);
        $obj->write();
   
        DB::alteration_message("Added default record to $className table","created");
        
	}
}
