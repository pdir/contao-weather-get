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

use Contao\System;
use Pdir\ContaoWeatherGetBundle\Model\WeatherModel;

$assetsDir = 'bundles/pdircontaoweatherget/';

/*
 * Backend modules
 */
if (!isset($GLOBALS['BE_MOD']['pdir']) || !is_array($GLOBALS['BE_MOD']['pdir'])) {
    \array_splice($GLOBALS['BE_MOD'], 1, 0, ['pdir' => []]);
}

$GLOBALS['BE_MOD']['pdir']['WeatherGET'] = [
    'tables' => ['tl_weatherget_info', 'tl_weatherget_cache'],
    'icon' => $assetsDir . 'icon.png'
];

/*
 * Models
 */
$GLOBALS['TL_MODELS']['tl_weatherget_info'] = WeatherModel::class;

/*
 * CSS for Backend
 */
$request = System::getContainer()->get('request_stack')->getCurrentRequest();
$scopeMatcher = System::getContainer()->get('contao.routing.scope_matcher');

if ($request && $scopeMatcher->isBackendRequest($request)) {
    $GLOBALS['TL_CSS'][] = $assetsDir . 'be.css';
}
