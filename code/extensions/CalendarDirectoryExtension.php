<?php

class CalendarDirectoryExtension extends DataExtension {

  private static $default_events_directory = "Event Contacts";
  
  private static $db = [
      'EventContactsDirectory' => 'Boolean'
  ];
  /**
   * Adds default groups
   */
  public function requireDefaultRecords() {
		$defaultRecordName = $this->owner->stat('default_events_directory');
        
        $className = $this->owner->class;

        // Subsite support
        $classInstance = Injector::inst()->create($className);
        if(class_exists('Subsite') && $classInstance->hasDatabaseField('SubsiteID')) {
            $subsites = Subsite::get();
            $disableFilter = Subsite::$disable_subsite_filter;
            Subsite::$disable_subsite_filter = true;
            // Create default record for each subsite
            foreach($subsites as $subsite) {
                $res = DataModel::inst()->$className
                  ->filter([
                      'SubsiteID' => $subsite->ID,
                      'EventContactsDirectory' => 1
                  ])
                  ->first();
                
                if(!$res) {
                    $obj = DataModel::inst()->$className->newObject([
                        'Name' => $defaultRecordName,
                        'SubsiteID' => $subsite->ID,
                        'EventContactsDirectory' => 1
                    ]);
                    $obj->write();
                }
            }
            Subsite::$disable_subsite_filter = $disableFilter;
        } else {
            // Check for existing record
            $res = DataModel::inst()->$className
                  ->filter(['EventContactsDirectory' => 1])
                  ->first();
            if($res) {
                return;
            }

            // Create one default record
            $obj = DataModel::inst()->$className->newObject([
                'Name' => $defaultRecordName,
                'EventContactsDirectory' => 1
            ]);
            $obj->write();
        }
        
        DB::alteration_message("Added default record(s) to $className table","created");
	}
    
    public function updateCMSFields(FieldList $fields)
    {
        // Remove events gridfield
        $fields->removeByName('EventContactsDirectory');
    }
}
