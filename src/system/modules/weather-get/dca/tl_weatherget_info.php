<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @package   WeatherGET
 * @author    Christian Najjar,  info@christian-najjar.de
 * @license   MIT
 * @copyright Christian Najjar 2016
 */


/**
 * Table tl_weatherget_info
 */
$GLOBALS['TL_DCA']['tl_weatherget_info'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'enableVersioning'            => true,
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary'
			)
		),
		'onsubmit_callback'            => array(array('\WeatherGET\WeatherGETModule', 'EmptyCache')),
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 2,
			'fields'                  => array("cityname",'title'),
			'headerFields'            => array("cityname",'title'),
			'flag'					  => 1,
			'panelLayout' 			  => 'filter;sort,limit',
		),
		'label' => array
		(
			'fields'                  => array('title','cityname','platform'),
			'showColumns'             => true,
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset();" accesskey="e"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_weatherget_info']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_weatherget_info']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_weatherget_info']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_weatherget_info']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),



	// Palettes
	'palettes' => array
	(
		'__selector__'  		=> array('platform','weathertype'),
		'default'               => '{title_legend},title,platform;',
		'openweather'   => '{title_legend},title,platform;{openweather_legend},apikey,idtype,cityid,Language,units,toupdate,weathertype;{template_legend:hide},customTpl;',
		'forecastio'    => '{title_legend},title,platform;{forecastio_legend},apikey,idtype,cityid,Language,units,toupdate,showdays;{template_legend:hide},customTpl;',
		'yahoo'   		=> '{title_legend},title,platform;{yahooweather_legend},idtype,cityid,Language,units,toupdate,showdays;{template_legend:hide},customTpl;'
	),
	'subpalettes' => array
	(
		'weathertype_forecast'	=> 'showdays'
	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_weatherget_info']['title'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'sorting'                 => true,
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),


		'platform'  => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_weatherget_info']['platform'],
			'inputType' => 'select',
		
			'options'   => array('openweather','forecastio', 'yahoo'),
			'reference' => &$GLOBALS['TL_LANG']['tl_weatherget_info'],
			'eval'      => array(
				'includeBlankOption' => true,
				'submitOnChange'     => true,
				'mandatory'          => true,
				'tl_class'           => 'w50',
			),
			'sql'       => "varchar(20) NOT NULL default ''"
		),


		'apikey' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_weatherget_info']['apikey'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array(
								'mandatory'=>true, 
								'maxlength'=>255,
								'tl_class' => 'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),

		'idtype' => array
		(
			'label'     		=> &$GLOBALS['TL_LANG']['tl_weatherget_info']['idType'],
			'inputType' 		=> 'select',
			'options'   		=> array('Unique','Name','Coordinates'),
			'reference' 		=> &$GLOBALS['TL_LANG']['tl_weatherget_info'],
			'options_callback'	=> array('\WeatherGET\WeatherGETModule', 'WeatherIdentificationOptions'),
			'flag'      		=> 1,
			'eval'      		=> array('mandatory' => true,'tl_class'  => 'w50',),
			'sql' 			    => "varchar(255) NOT NULL default ''"
		),

		'cityid' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_weatherget_info']['cityid'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array(
								'mandatory'=>true, 
								'maxlength'=>255,
								'tl_class' => 'w50 '),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'cityname' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_weatherget_info']['cityname'],
			'sorting'   => true,
			'sql'                     => "varchar(255) NOT NULL default ''"
		),

		'customTpl' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_weatherget_info']['customTpl'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'options_callback'        => array('\WeatherGET\WeatherGETModule', 'getElementTemplates'),
			'eval'                    => array('includeBlankOption'=>true, 'chosen'=>true, 'tl_class'=>'w50'),
			'sql'                     => "varchar(64) NOT NULL default ''"
		),

		'lastupdate' => array
		(
			'sql'       => "int(10) unsigned NOT NULL default '0'"
		),




		'Language' => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_weatherget_info']['Language'],
			'inputType' => 'select',
			'options'   => array('de','en','ru','it','es','uk','pt','fr'),
			'reference' 		=> &$GLOBALS['TL_LANG']['tl_weatherget_info']['languages'],
			//'options_callback'  => array('\WeatherGET\WeatherGETModule', 'WeatherLanguageOptions'),
			'options_callback'           => array('\WeatherGET\WeatherGETModule', 'WeatherLanguageOptions'),
			'flag'      => 1,
			'search'    => true,
			'eval'      => array(
				'mandatory' => true,
				'tl_class'  => 'w50',
			),
			'sql' 		=> "varchar(255) NOT NULL default ''"
		),

		'units' => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_weatherget_info']['units'],
			'inputType' => 'select',
			'options'   => array('metric','imperial'),
			'reference' 		=> &$GLOBALS['TL_LANG']['tl_weatherget_info'],
			'flag'      => 1,
			'search'    => true,
			'eval'      => array(
				'mandatory' => true,
				'tl_class'  => 'w50',
			),
			'sql' 		=> "varchar(255) NOT NULL default ''"
		),



		'weathertype'    => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_weatherget_info']['weathertype'],
			'default'   => 'current',
			'inputType' => 'select',
			'options'   => array('current','forecast'),
			'reference' => &$GLOBALS['TL_LANG']['tl_weatherget_info'],
			'eval'      => array(
				'submitOnChange' => true,
				'mandatory' => true,
				'tl_class'  => 'w50',
			),
			'sql'       => "varchar(12) NOT NULL default ''"
		),
		'toupdate'    => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_weatherget_info']['toupdate'],
			'inputType' => 'select',
			'options'   => array('1','2','3','4','5','6','12','24'),
			
			'eval'      => array(
				'mandatory' => true,
				'tl_class'  => 'w50',
			),
			'sql' 		=> "int(10) NOT NULL"
		),
		'showdays' => array
		(
			'label'     => &$GLOBALS['TL_LANG']['tl_weatherget_info']['showdays'],
			'inputType' => 'select',
			'options'   => array('1','2','3','4','5','6','7','8','9','10'),
			'options_callback'           => array('\WeatherGET\WeatherGETModule', 'MaxDays'),
			'flag'      => 1,
			'search'    => true,
			'eval'      => array(
				'mandatory' => true,
				'tl_class'  => 'w50',
			),
			'sql' 		=> "int(10) NOT NULL"
		),

	)
);
