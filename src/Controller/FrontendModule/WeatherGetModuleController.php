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

namespace Pdir\ContaoWeatherGetBundle\Controller\FrontendModule;

use Contao\BackendTemplate;
use Contao\ContentElement;
use Contao\CoreBundle\Controller\FrontendModule\AbstractFrontendModuleController;
use Contao\CoreBundle\Exception\RedirectResponseException;
use Contao\CoreBundle\DependencyInjection\Attribute\AsFrontendModule;
use Contao\ModuleModel;
use Contao\ContentModel;
use Contao\System;
use Contao\Template;
use Pdir\ContaoWeatherGetBundle\Model\WeatherModel;
use Pdir\ContaoWeatherGetBundle\WeatherGet\FormOutput;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[AsFrontendModule(WeatherGetModuleController::TYPE, category: 'miscellaneous', template: 'mod_weatherget_show')]
class WeatherGetModuleController extends AbstractFrontendModuleController
{
    public const TYPE = 'WeatherShow';
    protected function getResponse(Template $template, ModuleModel $model, Request $request): Response
    {
        $this->template = $template;

        $scopeMatcher = System::getContainer()->get('contao.routing.scope_matcher');

        if ($scopeMatcher->isBackendRequest($request)) {
            $this->beOutput($model);
        }

        $template->results = $this->feOutput($model);

        return $template->getResponse();
    }

    public static function beOutput(ContentModel|ModuleModel $model): Response
    {
        $template = new BackendTemplate('be_wildcard');

        //Using Model and Contao find ROW as Object using id
        $objWeather = WeatherModel::findById($model->WeatherGETid);

        //Set Wildcard Template Data
        $template->title      = $objWeather->title;
        $template->wildcard   = "### WETTER MODUL Nr. : ".$objWeather->id." ###";

        return $template->getResponse();
    }


    public static function feOutput(ContentModel|ModuleModel $model): string
    {
        //Forming the Data "Outsourced" to WeatherGETFormOuput so it can be used for inserttags without using unnessacery resources.
        $output = new FormOutput();
        return $output->getrenderdweather($model->WeatherGETid);
    }
}
