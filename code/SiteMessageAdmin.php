<?php

class SiteMessageAdmin extends ModelAdmin implements PermissionProvider {
	
	private static $managed_models = array("SiteMessage");
	private static $model_importers = array();
	private static $url_segment = "sitemessages";
	private static $menu_title = "Site Messages";
    
    /**
     * Add site message CRUD to permissions list for Members
     * @return NULL
     */
	function providePermissions(){
        return array(
            "SITEMESSAGES_VIEW" => array(
            	"category" => _t("SiteMessage.PERMISSION_TITLE", "Site Messages"),
                "name" => _t("SiteMessage.VIEW_NAME", "View site messages"),
            	"help" => _t("SiteMessage.VIEW_HELP", "Can view site messages in the CMS")
            ),
            "SITEMESSAGES_CREATE" => array(
            	"category" => _t("SiteMessage.PERMISSION_TITLE", "Site Messages"),
                "name" => _t("SiteMessage.CREATE_NAME", "Create site messages"),
            	"help" => _t("SiteMessage.CREATE_HELP", "Can create site messages in the CMS")
            ),
            "SITEMESSAGES_EDIT" => array(
            	"category" => _t("SiteMessage.PERMISSION_TITLE", "Site Messages"),
                "name" => _t("SiteMessage.EDIT_NAME", "Edit site messages"),
            	"help" => _t("SiteMessage.EDIT_HELP", "Can edit site messages in the CMS")
            ),
            "SITEMESSAGES_DELETE" => array(
            	"category" => _t("SiteMessage.PERMISSION_TITLE", "Site Messages"),
                "name" => _t("SiteMessage.DELETE_NAME", "Delete site messages"),
            	"help" => _t("SiteMessage.DELETE_HELP", "Can delete site messages in the CMS")
            )
        );
    }
    
}