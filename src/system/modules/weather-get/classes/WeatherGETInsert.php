<?php



/**
 * Namespace
 */
namespace cnajjar\WeatherGET;



class WeatherGETInsert extends \Frontend{

public function byInsertTag($strTag){

        $arrSplit = explode('::', $strTag);

        //Check WeatherInfo by Weather ID
        if ($arrSplit[0] == 'weatherg' || $arrSplit[0] == 'cache_weatherg')
        {
            if (isset($arrSplit[1]))
            {
                $weatherid=$arrSplit[1];              

                $objWeather = \WeatherModel::findById($weatherid);
                if($objWeather!=NULL){
                    $output = new \WeatherGETFormOutput();
                    return '<div class="insertblock block weather-block">'.$output->getrenderdweather($objWeather->id).'</div>';
                }else{
                    //IF ObjWeater NULL (Weather not Found) give out Error Message
                    return '<div class="insertblock block weather-block"><p class="error">'.$GLOBALS['TL_LANG']['MSC']['notFound'].'</p></div>';
                }
            } 

        }


        //Check WeatherInfo by Weather Titel

        if ($arrSplit[0] == 'weathergBt' || $arrSplit[0] == 'cache_weathergBt')
        {
            if (isset($arrSplit[1]))
            {
                $weathername=$arrSplit[1];
                $objWeather = \WeatherModel::findOneBy('title',$weathername );

                if($objWeather!=NULL){
                    $output = new \WeatherGETFormOutput();
                    return '<div class="insertblock block weather-block">'.$output->getrenderdweather($objWeather->id).'</div>';
                }else{
                    //IF ObjWeater NULL (Weather not Found) give out Error Message
                    return '<div class="insertblock block weather-block"><p class="error">'.$GLOBALS['TL_LANG']['MSC']['notFound'].'</p></div>';
                }

            } 

        }

        //Return false to tell the system that the inserttag is not from us
        return false;

 }

}

?>