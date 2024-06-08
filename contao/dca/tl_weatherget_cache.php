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
 * Table tl_weatherget_cache
 */
$GLOBALS['TL_DCA']['tl_weatherget_cache'] = array
(
    // Config
    'config' => array
    (
        'sql' => array
        (
            'keys' => array
            (
                'id' => 'primary'
            )
        )
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
        'wid' => array
        (
            'sql'       => "int(10) unsigned NOT NULL default '0'"
        ),

        'daytime' => array
        (
            'sql'       => "int(10) unsigned NOT NULL default '0'"
        ),
        'sunset' => array
        (
            'sql'       => "int(10) unsigned NOT NULL default '0'"
        ),
        'sunrise' => array
        (
            'sql'       => "int(10) unsigned NOT NULL default '0'"
        ),

        'temp' => array
        (
            'sql'    => "varchar(255) NOT NULL default '0'"
        ),
        'mintemp' => array
        (
            'sql'    => "varchar(255) NOT NULL default '0'"
        ),
        'maxtemp' => array
        (
            'sql'    => "varchar(255) NOT NULL default '0'"
        ),
        'nighttemp' => array
        (
            'sql'    => "varchar(255) NOT NULL default '0'"
        ),
        'evetemp' => array
        (
            'sql'    => "varchar(255) NOT NULL default '0'"
        ),
        'morntemp' => array
        (
            'sql'    => "varchar(255) NOT NULL default '0'"
        ),
        'pressure' => array
        (
            'sql'    => "varchar(255) NOT NULL default '0'"
        ),
        'humidity' => array
        (
            'sql'    => "varchar(255) NOT NULL default '0'"
        ),
        'weather_id' => array
        (
            'sql'       => "int(10) unsigned NOT NULL default '0'"
        ),
        'weather_desc' => array
        (
            'sql'    => "varchar(255) NOT NULL default '0'"
        ),
        'weather_icon' => array
        (
            'sql'    => "varchar(255) NOT NULL default '0'"
        ),
        'speed' => array
        (
            'sql'    => "varchar(255) NOT NULL default '0'"
        ),
        'deg' => array
        (
            'sql'    => "int(10) unsigned NOT NULL default '0'"
        ),
        'clouds' => array
        (
            'sql'    => "int(10) unsigned NOT NULL default '0'"
        ),
        'rain' => array
        (
            'sql'    => "varchar(10) NOT NULL default '0'"
        )
    )
);


