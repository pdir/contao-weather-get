<?php

declare(strict_types=1);

/*
 * pdir WeatherGet bundle for Contao Open Source CMS
 *
 * Copyright (c) 2024 pdir / digital agentur // pdir GmbH
 *
 * @package    contao-weather-get-bundle
 * @link       https://github.com/pdir/contao-weather-get
 * @license    https://opensource.org/licenses/MIT
 * @copyright  Christian Najjar 2016
 * @author     Christian Najjar,  info@christian-najjar.de
 * @author     pdir GmbH <https://pdir.de>
 * @author     Mathias Arzberger <develop@pdir.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pdir\ContaoWeatherGetBundle\Controller\EventListener;

use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Pdir\ContaoWeatherGetBundle\Model\WeatherModel;
use Pdir\ContaoWeatherGetBundle\WeatherGET\FormOutput;

#[AsHook('replaceInsertTags')]
class WeatherInsertTagListener
{
    public function __invoke(string $tag)
    {
        [$name, $param] = explode('::', $tag) + [null, null];

        //Check WeatherInfo by Weather ID
        if ($name == 'weatherg' || $name == 'cache_weatherg')
        {
            if (isset($param))
            {
                $weatherid=$param;

                $objWeather = WeatherModel::findById($weatherid);
                if($objWeather!=NULL){
                    $output = new FormOutput();
                    return '<div class="insertblock block weather-block">'.$output->getrenderdweather($objWeather->id).'</div>';
                }else{
                    //IF ObjWeater NULL (Weather not Found) give out Error Message
                    return '<div class="insertblock block weather-block"><p class="error">'.$GLOBALS['TL_LANG']['MSC']['notFound'].'</p></div>';
                }
            }

        }


        //Check WeatherInfo by Weather Titel
        if ($name === 'weathergBt' || $name === 'cache_weathergBt')
        {
            if (isset($param))
            {
                $weathername=$param;
                $objWeather = WeatherModel::findOneBy('title',$weathername );

                if($objWeather!=NULL){
                    $output = new FormOutput();
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
