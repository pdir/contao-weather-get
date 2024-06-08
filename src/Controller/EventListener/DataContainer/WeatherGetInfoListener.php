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

namespace Pdir\ContaoWeatherGetBundle\Controller\EventListener\DataContainer;

use Contao\Controller;
use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\DataContainer;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

class WeatherGetInfoListener
{
    public function __construct(private readonly Connection $connection)
    {
    }

    #[AsCallback(table: 'tl_weatherget_info', target: 'fields.customTpl.options')]
    public function getElementTemplates(DataContainer $dc)
    {
        if(strpos($dc->getPalette(),"yahooweather")){
            return Controller::getTemplateGroup('mod_wg_yahoo');
        }
        if(strpos($dc->getPalette(),"openweather")){
            return Controller::getTemplateGroup('mod_wg_openweather');
        }
        if(strpos($dc->getPalette(),"forecastio")){
            return Controller::getTemplateGroup('mod_wg_f');
        }
        if(strpos($dc->getPalette(),"darksky")){
            return Controller::getTemplateGroup('mod_wg_d');
        }
    }

    #[AsCallback(table: 'tl_weatherget_info', target: 'fields.idType.options')]
    public function getIdentificationOptions(DataContainer $dc): array
    {
        if ((\strpos($dc->getPalette(), "forecastio")) || (\strpos($dc->getPalette(), "darksky"))) {
            return array('Coordinates');
        } else {
            return array('Unique', 'Name', 'Coordinates');
        }
    }

    #[AsCallback(table: 'tl_weatherget_info', target: 'fields.Language.options')]
    public function getLanguageOptions(DataContainer $dc): array
    {
        if (\strpos($dc->getPalette(),"yahooweather")) {
            return array('en','de');
        }
        if (\strpos($dc->getPalette(),"openweather")) {
            return array('de','en','ru','it','es','uk','pt','fr');
        }
        if (\strpos($dc->getPalette(),"forecastio")) {
            return array('de','en','ar','az','be','bs','cz','el','es','fr','hr','hu','id','it','is','kw','nb','nl','pl','pt','ru','sk','sr','sv','tet','tr','uk','x-pig-latin','zh','zh-tw');
        }
        if (\strpos($dc->getPalette(),"darksky")) {
            return array('de','en','ar','az','be','bs','cz','el','es','fr','hr','hu','id','it','is','kw','nb','nl','pl','pt','ru','sk','sr','sv','tet','tr','uk','x-pig-latin','zh','zh-tw');
        }

        return [];
    }

    #[AsCallback(table: 'tl_weatherget_info', target: 'fields.showdays.options')]
    public function getMaxDaysOptions(DataContainer $dc)
    {
        if(\strpos($dc->getPalette(),"yahooweather")){
            return array('1','2','3','4','5','6','7','8','9','10');
        }
        if(\strpos($dc->getPalette(),"openweather")){
            return array('1','2','3','4','5');
        }
        if(\strpos($dc->getPalette(),"forecastio")){
            return array('1','2','3','4','5','6','7','8');
        }
        if(\strpos($dc->getPalette(),"darksky")){
            return array('1','2','3','4','5','6','7','8');
        }

    }

    #[AsCallback(table: 'tl_weatherget_info', target: 'config.onsubmit')]
    public function emptyCache(DataContainer $dc): void
    {
        //FORCE to 0 lastupdate info
        $statement = $this->connection->prepare('UPDATE tl_weatherget_info SET lastupdate=? WHERE id=?');
        $statement->executeQuery([0, $dc->__get('id')]);
    }
}
