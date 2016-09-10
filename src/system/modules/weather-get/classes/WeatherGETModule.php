<?php
namespace cnajjar\WeatherGET;


class WeatherGETModule extends \Backend {

    public function WeatherGETList()
    {
        $res = \Database::GetInstance()->prepare("SELECT id,title FROM tl_weatherget_info")->execute();
        $arrElem = array();
        while ($res->next()) {
            if (trim($res->title) == '') continue;
            $arrElem[$res->id] = $res->title;
        }
        return ($arrElem);
    }


    public function WeatherLanguageOptions(\Contao\DC_Table $dc)
    {

        //echo"<pre>";var_dump();die;
        if(strpos($dc->getPalette(),"yahooweather")){
            return array('en','de');
        }
        if(strpos($dc->getPalette(),"openweather")){
            return array('de','en','ru','it','es','uk','pt','fr');
        }
         if(strpos($dc->getPalette(),"forecastio")){
            return array('de','en','ar','az','be','bs','cz','el','es','fr','hr','hu','id','it','is','kw','nb','nl','pl','pt','ru','sk','sr','sv','tet','tr','uk','x-pig-latin','zh','zh-tw');
        }
        //echo "<pre>";var_dump($dc);die;
    }
    public function WeatherIdentificationOptions(\Contao\DC_Table $dc)
    {
        if(strpos($dc->getPalette(),"forecastio")){
            return array('Coordinates');
        }else{
            return array('Unique','Name','Coordinates');  
        }
        
    }
    public function EmptyCache(\Contao\DC_Table $dc)
    {
        //FORCE to 0 lastupdate info 
        $set = array('lastupdate'=>0);
        $this->Database->prepare('UPDATE tl_weatherget_info %s WHERE id=?')->set($set)->execute($dc->__get('id'));
    }
    public function getElementTemplates(\Contao\DC_Table $dc)
    {
        if(strpos($dc->getPalette(),"yahooweather")){
           return $this->getTemplateGroup('mod_wg_yahoo');
        }
        if(strpos($dc->getPalette(),"openweather")){
           return $this->getTemplateGroup('mod_wg_openweather');
        }
        if(strpos($dc->getPalette(),"forecastio")){
           return $this->getTemplateGroup('mod_wg_forecastio');
        }
        
    }
    public function MaxDays(\Contao\DC_Table $dc)
    {
        if(strpos($dc->getPalette(),"yahooweather")){
           return array('1','2','3','4','5','6','7','8','9','10');
        }
        if(strpos($dc->getPalette(),"openweather")){
           return array('1','2','3','4','5');
        }
        if(strpos($dc->getPalette(),"forecastio")){
           return array('1','2','3','4','5','6','7','8');
        }
        
    }
}
