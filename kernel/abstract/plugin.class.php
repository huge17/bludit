<?php defined('BLUDIT') or die('Bludit CMS.');

class Plugin {

	// (string) Plugin's directory
	public $directoryName;

	// (string) Database path and filename
	public $fileDb;

	// (array) Database
	public $db;

	// (array) Database fields, only for initialize.
	public $dbFields;

	public $className;

	public $data;

	function __construct()
	{
		$reflector = new ReflectionClass(get_class($this));

		$this->data = array(
			'name'=>'',
			'description'=>'',
			'author'=>'',
			'email'=>'',
			'website'=>''
		);

		// Directory name
		$this->directoryName = basename(dirname($reflector->getFileName())).DS;

		// Class Name
		$this->className = $reflector->getName();

		// Initialize dbFields from the children.
		$this->init();

		// Init empty database
		$this->db = $this->dbFields;

		$this->fileDb = PATH_PLUGINS_DATABASES.$this->directoryName.'db.php';

		// If the plugin installed then get the database.
		if($this->installed())
		{
			$Tmp = new dbJSON($this->fileDb);
			$this->db = $Tmp->db;
		}
	}

	public function getData($key)
	{
		if(isset($this->data[$key])) {
			return $this->data[$key];
		}

		return '';		
	}

	public function setData($array)
	{
		$this->data = $array;
	}

	public function name()
	{
		return $this->getData('name');
	}

	public function description()
	{
		return $this->getData('description');
	}

	public function author()
	{
		return $this->getData('author');
	}

	public function email()
	{
		return $this->getData('email');
	}

	public function website()
	{
		return $this->getData('website');
	}

	public function className()
	{
		return $this->className;
	}

	public function directoryName()
	{
		return $this->directoryName;
	}

	// Return TRUE if the installation success, otherwise FALSE.
	public function install()
	{
		if($this->installed()) {
			return false;
		}

		// Create plugin directory for databases and others files.
		mkdir(PATH_PLUGINS_DATABASES.$this->directoryName, 0755, true);

		if( !empty($this->dbFields) )
		{
			$Tmp = new dbJSON($this->fileDb);
			$Tmp->setDb($this->dbFields);
		}

		return true;
	}

	public function uninstall()
	{
		unlink($this->fileDb);
		rmdir(PATH_PLUGINS_DATABASES.$this->directoryName);
	}

	public function installed()
	{
		return file_exists($this->fileDb);
	}

	public function init()
	{
		// This method is used on childre classes.
		// The user can define your own dbFields.
	}

	// DEBUG: Ver si se usa
	public function showdb()
	{
		print_r( $this->db );
	}

	// EVENTS

	// Before the posts load.
	public function beforePostsLoad()
	{
		return false;
	}

	// After the posts load.
	public function afterPostsLoad()
	{
		return false;
	}

	// Before the pages load.
	public function beforePagesLoad()
	{
		return false;
	}

	// After the pages load.
	public function afterPagesLoad()
	{
		return false;
	}

	public function onSiteHead()
	{
		return false;
	}

	public function onSiteBody()
	{
		return false;
	}

	public function onAdminHead()
	{
		return false;
	}

	public function onAdminBody()
	{
		return false;
	}

	public function onSiteSidebar()
	{
		return false;
	}

	public function onAdminSidebar()
	{
		return false;
	}

}
