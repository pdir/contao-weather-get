<?php


$GLOBALS['TL_DCA']['tl_module']['palettes']['WeatherShow'] = '{title_legend},name,type;{weather_legend},WeatherGETid;{expert_legend:hide}guests,cssID,space;';


$GLOBALS['TL_DCA']['tl_module']['fields']['WeatherGETid'] = array(
         'label' => &$GLOBALS['TL_LANG']['MOD']['WeatherGETid'], 
         'inputType' => 'select', 
         'options_callback' => array(
            'WeatherGETModule', 
            'WeatherGETList'
         ), 
         'eval' => array(
            'mandatory' => true, 
            'tl_class' => 'w50'), 
         'sql' => "int(10) unsigned NOT NULL default '0'"
);


?>