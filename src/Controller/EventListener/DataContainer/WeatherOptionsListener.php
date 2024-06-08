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

use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

#[AsCallback(table: 'tl_content', target: 'fields.WeatherGETid.options')]
#[AsCallback(table: 'tl_module', target: 'fields.WeatherGETid.options')]
class WeatherOptionsListener
{
    public function __construct(private readonly Connection $connection)
    {
    }

    /**
     * @throws Exception
     */
    public function __invoke(): array
    {
        $statement = $this->connection->prepare('SELECT id,title FROM tl_weatherget_info');
        $arrElem = [];

        $rows = $statement->executeQuery();

        foreach ($rows->iterateAssociative() as $val) {
            if (null === $val['title'] || \trim($val['title']) === '') {
                continue;
            }
            $arrElem[$val['id']] = $val['title'];
        }

        return $arrElem;
    }
}
