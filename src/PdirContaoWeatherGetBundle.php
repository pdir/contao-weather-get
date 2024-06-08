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

namespace Pdir\ContaoWeatherGetBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Configures the Contao WeatherGet Bundle.
 *
 * @author Mathias Arzberger <develop@pdir.de>
 */
class PdirContaoWeatherGetBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
