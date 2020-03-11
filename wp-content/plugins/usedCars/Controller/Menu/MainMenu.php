<?php
namespace Menu;
/**
	Creating an administrative menu item
 */
class MainMenu {

	public $title;

	public $slug;

	/**
	 * User rights (features) required for the menu item to appear in the list.
	 *  Super Admin – somebody with access to the site network administration features and all other features. See the Create a Network article.
		Administrator (slug: ‘administrator’) – somebody who has access to all the administration features within a single site.
		Editor (slug: ‘editor’) – somebody who can publish and manage posts including the posts of other users.
		Author  (slug: ‘author’)  – somebody who can publish and manage their own posts.
		Contributor (slug: ‘contributor’) – somebody who can write and manage their own posts but cannot publish them.
		Subscriber (slug: ‘subscriber’) – somebody who can only manage their profile.
	 */
    public $capability='administrator';

    public $icon='';

    public $position;

    public $function='out';

    public function __construct( $title,$slug,$capability=NULL,$icon=NULL,$position,$function=NULL) {
        $this->title=$title;

	    $this->slug=$slug;

	    $this->capability=!empty($capability)?$capability:$this->capability;

	    $this->icon=!empty($icon)?plugin_dir_path( __DIR__ ).$icon:$this->icon;

	    $this->position=$position;

	    $this->function=!empty($function)?$function:[$this,$this->function];

	    $this->init();

	    return $this;
    }

    /**
     * Adds a submenu for this plugin to the 'Tools' menu.
     */
    public function init() {
        add_action( 'admin_menu', array( $this, 'add_options_page' ) );
    }

    /**
     * Creates the submenu item and calls on the Submenu Page object to render
     * the actual contents of the page.
     */
    public function add_options_page() {

    	add_menu_page(
            $this->title,
	        $this->title,
	        $this->capability,
	        $this->slug,
//	        $this->function,
		    NULL,
            $this->icon,
	        $this->position
        );
    }

	public function out(){
		return '';
	}
}