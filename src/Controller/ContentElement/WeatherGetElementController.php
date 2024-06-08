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

namespace Pdir\ContaoWeatherGetBundle\Controller\ContentElement;

use Contao\ContentModel;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsContentElement;
use Contao\System;
use Contao\Template;
use Pdir\ContaoWeatherGetBundle\Controller\FrontendModule\WeatherGetModuleController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[AsContentElement(WeatherGetElementController::TYPE, category: 'miscellaneous', template: 'mod_weatherget_show')]
class WeatherGetElementController extends AbstractContentElementController
{
    public const TYPE = 'WeatherShow';
    protected function getResponse(Template $template, ContentModel $model, Request $request): Response
    {
        $scopeMatcher = System::getContainer()->get('contao.routing.scope_matcher');

        if ($scopeMatcher->isBackendRequest($request)) {
            WeatherGetModuleController::beOutput($model);
        }

        $template->results = WeatherGetModuleController::feOutput($model);

        return $template->getResponse();
    }
}
