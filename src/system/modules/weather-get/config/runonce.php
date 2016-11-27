<?php/**
 * inserttags extension for Contao Open Source CMS
 *
 * @copyright  Copyright (c) 2008-2014, terminal42 gmbh
 * @author     terminal42 gmbh <info@terminal42.ch>
 * @license    http://opensource.org/licenses/lgpl-3.0.html LGPL
 * @link       http://github.com/terminal42/contao-inserttags
 */
class changeForecastToDarkSky extends Controller
{
	/**
	 * Initialize the object
	 */
	public function __construct()
	{
		parent::__construct();
		$this->import('Database');
	}
	/**
	 * Execute all runonce files in module config directories
	 */
	public function run()
	{
        if ($this->Database->tableExists('tl_weatherget_info'))
        {
        	$set = array('platform'=>'darksky');
		
			$this->Database->prepare('UPDATE tl_weatherget_info %s WHERE platform=?')->set($set)->execute('forecastio');
        }
	}
}
/**
 * Instantiate controller
 */
$objchangeForecastToDarkSky = new changeForecastToDarkSky();
$objchangeForecastToDarkSky->run();