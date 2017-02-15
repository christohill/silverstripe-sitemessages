<?php

class SiteMessage extends DataObject {
	
	private static $singular_name = "Site Message";
	private static $plural_name = "Site Messages";
	private static $default_sort = "Created DESC";

	private static $db = array(
		"Unique" => "Varchar(255)",
		"Permanent" => "Boolean",
		"CanClose" => "Boolean",
		"CloseColor" => "Color",
		"Title" => "Varchar(255)",
		"Content" => "HTMLText",
		"ButtonText" => "Varchar(255)",
		"Start" => "SS_Datetime",
		"End" => "SS_Datetime",
		"BackgroundColor" => "Color",
		"TextColor" => "Color",
		"ButtonColor" => "Color",
		"ButtonTextColor" => "Color"
	);

	private static $has_one = array(
		"Page" => "Page"
	);
	
	private static $defaults = array(
		'CanClose' => 1,
		'CloseColor' => "000000"
	);

	private static $searchable_fields = array(
		'Title',
		'Content'
	);

	private static $summary_fields = array(
		'Title' => 'Title',
		'stripContent' => 'Content',
		'Start.Nice' => 'Start',
		'EndStatus' => 'End'
	);

	public function getCMSFields() {
		$fields = parent::getCMSFields();

		// Remove fields
		$fields->removeByName(array(
			'Unique',
			'Permanent',
			'CanClose',
			'CloseColor',
			'LinkID'
		));

		// Add fields

		// Main tab
		$fields->addFieldToTab("Root.Main", $test = TextField::create("ButtonText")
			->setTitle(_t("SiteMessage.LABELBUTTONTEXT", "Button Text"))
		);
		$fields->addFieldToTab("Root.Main", TreeDropdownField::create("PageID")
			->setTitle(_t("SiteMessage.LABELLINKTO", "Link to"))
			->setSourceObject("SiteTree")
		);
		$fields->addFieldToTab("Root.Main", HTMLEditorField::create("Content")
			->setTitle(_t("SiteMessage.LABELCONTENT", "Message content"))
			->setRows(15)
		);

		// Design tab
		$fields->addFieldToTab("Root.Design", HeaderField::create("ColorSettings")
			->setTitle(_t("SiteMessage.HEADERCOLORSETTINGS", "Color settings"))
		);
		$fields->addFieldToTab("Root.Design", ColorField::create("BackgroundColor")
			->setTitle(_t("SiteMessage.LABELBACKGROUNDCOLOR", "Background Color"))
		);
		$fields->addFieldToTab("Root.Design", ColorField::create("TextColor")
			->setTitle(_t("SiteMessage.LABELTEXTCOLOR", "Text Color"))
		);
		$fields->addFieldToTab("Root.Design", ColorField::create("ButtonColor")
			->setTitle(_t("SiteMessage.LABELBUTTONCOLOR", "Button Color"))
		);
		$fields->addFieldToTab("Root.Design", ColorField::create("ButtonTextColor")
			->setTitle(_t("SiteMessage.LABELBUTTONTEXTCOLOR", "Button Text Color"))
		);
		$fields->addFieldToTab("Root.Design", HeaderField::create("CloseSettings")
			->setTitle(_t("SiteMessage.HEADERCLOSESETTINGS", "Close button settings"))
		);
		$fields->addFieldToTab("Root.Design", FieldGroup::create(
			_t("SiteMessage.LABELCANCLOSE", "Show close button?"),
			Checkboxfield::create("CanClose", "")
		));
		$fields->addFieldToTab("Root.Design", ColorField::create("CloseColor")
			->setTitle(_t("SiteMessage.LABELCLOSECOLOR", "Close button color"))
		);

		// Schedule tab
		$fields->addFieldToTab("Root.Schedule", FieldGroup::create(	
			_t("SiteMessage.LABELPERMANENT","Is this message permanent?"),
			CheckboxField::create("Permanent", "")		
		));
		$fields->addFieldToTab("Root.Schedule", $Start = new DatetimeField("Start"));
		$fields->addFieldToTab("Root.Schedule", $End = new DatetimeField("End"));
		
		$Start->setConfig('datavalueformat', 'YYYY-MM-dd HH:mm')
		->setTitle(_t("SiteMessage.LABELSTART", "Start Date"))
		->getDateField('Start')
				->setConfig('showcalendar', TRUE);
				
		$End->setConfig('datavalueformat', 'YYYY-MM-dd HH:mm')
		->setTitle(_t("SiteMessage.LABELEND", "End Date"))
		->getDateField('End')
				->setConfig('showcalendar', TRUE);

		return $fields;
	}
	
	public function getCMSValidator() {
		return new SiteMessageValidator();
	}


	public function onBeforeWrite() {

		parent::onBeforeWrite();
		
		// Set default title of one is not entered
		if(!$this->Title) {
			$this->Title = _t("SiteMessage.DEFAULTTITLE", "Site message ({date})", NULL, array('date' => date('F j Y')));
		}
		
		// If no start date is set, set Start to right now
		if(!$this->Start) {
			$this->Start = date('Y-m-d');
		}
		
		// If no end date is set, set to Permanent
		if(!$this->End && !$this->Permanent) {
			$this->Permanent = TRUE;
		}
		
		// If permanent is set, remove end date
		if($this->Permanent) {
			$this->End = NULL;
		}
		
		// Create unique id for cookies
		if(!$this->Unique) {
			$this->Unique = "sm_" . time();
		}

	}
	
	/**
	 * If there is no end date return permanent
	 * @return String
	 */
	public function getEndStatus() {
    	if(!$this->End || $this->Permanent) {
    		return _t("SiteMessage.GRIDPERMANENT", 'Permanent');
    	}else {
    		return $this->dbObject('End')->Nice();
    	}
    }
    
    /**
     * Strip the HTML tags from the content for GridField view
     * @return String Stripped HTML content
     */
    public function stripContent() {
    	if($this->Content) {
    		return strip_tags($this->Content);
    	}
    }
    
    // DataObject permission functions
	public function canView($member = null) {
        return Permission::check('SITEMESSAGES_VIEW', 'any', $member);
    }

    public function canEdit($member = null) {
        return Permission::check('SITEMESSAGES_EDIT', 'any', $member);
    }

    public function canDelete($member = null) {
        return Permission::check('SITEMESSAGES_DELETE', 'any', $member);
    }

    public function canCreate($member = null) {
        return Permission::check('SITEMESSAGES_CREATE', 'any', $member);
    }

}