<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @package   WeatherGET
 * @author    Christian Najjar,  info@christian-najjar.de
 * @license   MIT
 * @copyright Christian Najjar 2016
 */

/**
 * Namespace
 */

namespace Pdir\ContaoWeatherGetBundle\WeatherGet\Platform;

/**
 * Class WeatherAPI\YahooWeatherAPI
 *
 * @copyright  Christian Najjar 2016
 * @author     Christian Najjar,  info@christian-najjar.de
 * @package    Devtools
 */
class OpenWeatherMap
{
    protected $place;
    protected $language;
    protected $idType;
    protected $unit;
    protected $apikey;
    protected $weathertype;
    protected $maxdays;

    protected $cityname = "";
    protected string $apiRoot = 'https://api.openweathermap.org/data/2.5/';

    public function __construct($key, $place = "", $language = "de", $type = "Unique", $unit = "metric", $weathertype = "forecast", $maxdays = 7)
    {
        $this->apikey = $key;
        $this->place = $place;
        $this->language = $language;
        $this->idType = $type;
        $this->unit = $unit;
        $this->weathertype = $weathertype;
        $this->maxdays = $maxdays;
    }

    protected function BuildURL()
    {
        switch ($this->weathertype) {
            case 'forecast-daily':
                $type = "forecast/daily";
                $cnt = "&cnt=" . $this->maxdays;
                break;
            case 'forecast':
                $type = "forecast";
                $cnt = "";
                break;
            case 'current':
                $type = "weather";
                $cnt = "";
                break;
        }

        switch ($this->idType) {
            case 'Unique':
                //Absolute uniuqe identifier = yahoo woeid
                $url = $this->apiRoot . $type . '?id=' . $this->place . '&appid=' . $this->apikey . '&lang=' . $this->language . '&units=' . $this->unit . $cnt;
                break;
            case 'Name':
                //Try to Find City With Name
                $url = $this->apiRoot . $type . '?q=' . $this->place . '&appid=' . $this->apikey . '&lang=' . $this->language . '&units=' . $this->unit . $cnt;
                break;
            case 'Coordinates':
                //lat / lon Coordinates
                $coordinates = str_replace(' ', '', $this->place);
                $coordinates = explode(',', $coordinates);
                if ($coordinates[0] > 0) {
                    $url = $this->apiRoot . $type . '?lat=' . trim($coordinates[0], " ") . '&lon=' . trim($coordinates[1], " ") . '&appid=' . $this->apikey . '&lang=' . $this->language . '&units=' . $this->unit . $cnt;
                } else {
                    $url = "error";
                }
                break;
        }

        return $url;
    }

    public function calcAverage($data, $tmpArray)
    {

        $hour = date('H', $data['dt']);
        switch ($hour) {
            case '00':
                $tmpArray['nighttemp'] += $data['main']['temp'];
                break;
            case '01':
                $tmpArray['nighttemp'] += $data['main']['temp'];
                break;
            case '02':
                $tmpArray['nighttemp'] += $data['main']['temp'];
                break;
            case '03':
                $tmpArray['nighttemp'] += $data['main']['temp'];
                break;
            case '04':
                $tmpArray['nighttemp'] += $data['main']['temp'];
                break;
            case '05':
                $tmpArray['morntemp'] = $data['main']['temp'];
                break;
            case '06':
                $tmpArray['morntemp'] = $data['main']['temp'];
                break;
            case '07':
                $tmpArray['morntemp'] = $data['main']['temp'];
                break;
            case '08':
                $tmpArray['averagetemp'] += $data['main']['temp'];

                $tmpArray['averagecloud'] += $data['clouds']['all'];

                $tmpArray['averagewindspeed'] += $data['wind']['speed'];
                $tmpArray['averagewinddeg'] += $data['wind']['deg'];

                $tmpArray['averagpressure'] += $data['main']['pressure'];
                $tmpArray['averaghumidity'] += $data['main']['humidity'];
                break;
            case '09':
                $tmpArray['averagetemp'] += $data['main']['temp'];

                $tmpArray['averagecloud'] += $data['clouds']['all'];

                $tmpArray['averagewindspeed'] += $data['wind']['speed'];
                $tmpArray['averagewinddeg'] += $data['wind']['deg'];

                $tmpArray['averagpressure'] += $data['main']['pressure'];
                $tmpArray['averaghumidity'] += $data['main']['humidity'];
                break;
            case '10':
                $tmpArray['averagetemp'] += $data['main']['temp'];

                $tmpArray['averagecloud'] += $data['clouds']['all'];

                $tmpArray['averagewindspeed'] += $data['wind']['speed'];
                $tmpArray['averagewinddeg'] += $data['wind']['deg'];

                $tmpArray['averagpressure'] += $data['main']['pressure'];
                $tmpArray['averaghumidity'] += $data['main']['humidity'];
                break;
            case '11':
                $tmpArray['daytime'] = $data['dt'];
                $tmpArray['weather_icon'] = $data['weather'][0]['icon'];
                $tmpArray['weather_id'] = $data['weather'][0]['id'];
                $tmpArray['weather_desc'] = $data['weather'][0]['description'];

                $tmpArray['averagetemp'] += $data['main']['temp'];

                $tmpArray['averagecloud'] += $data['clouds']['all'];

                $tmpArray['averagewindspeed'] += $data['wind']['speed'];
                $tmpArray['averagewinddeg'] += $data['wind']['deg'];

                $tmpArray['averagpressure'] += $data['main']['pressure'];
                $tmpArray['averaghumidity'] += $data['main']['humidity'];

                break;
            case '12':
                $tmpArray['daytime'] = $data['dt'];
                $tmpArray['weather_icon'] = $data['weather'][0]['icon'];
                $tmpArray['weather_id'] = $data['weather'][0]['id'];
                $tmpArray['weather_desc'] = $data['weather'][0]['description'];

                $tmpArray['averagetemp'] += $data['main']['temp'];

                $tmpArray['averagecloud'] += $data['clouds']['all'];

                $tmpArray['averagewindspeed'] += $data['wind']['speed'];
                $tmpArray['averagewinddeg'] += $data['wind']['deg'];

                $tmpArray['averagpressure'] += $data['main']['pressure'];
                $tmpArray['averaghumidity'] += $data['main']['humidity'];

                break;
            case '13':
                $tmpArray['daytime'] = $data['dt'];
                $tmpArray['weather_icon'] = $data['weather'][0]['icon'];
                $tmpArray['weather_id'] = $data['weather'][0]['id'];
                $tmpArray['weather_desc'] = $data['weather'][0]['description'];

                $tmpArray['averagetemp'] += $data['main']['temp'];

                $tmpArray['averagecloud'] += $data['clouds']['all'];

                $tmpArray['averagewindspeed'] += $data['wind']['speed'];
                $tmpArray['averagewinddeg'] += $data['wind']['deg'];

                $tmpArray['averagpressure'] += $data['main']['pressure'];
                $tmpArray['averaghumidity'] += $data['main']['humidity'];

                break;
            case '14':
                $tmpArray['averagetemp'] += $data['main']['temp'];

                $tmpArray['averagecloud'] += $data['clouds']['all'];

                $tmpArray['averagewindspeed'] += $data['wind']['speed'];
                $tmpArray['averagewinddeg'] += $data['wind']['deg'];

                $tmpArray['averagpressure'] += $data['main']['pressure'];
                $tmpArray['averaghumidity'] += $data['main']['humidity'];
                break;
            case '15':
                $tmpArray['averagetemp'] += $data['main']['temp'];

                $tmpArray['averagecloud'] += $data['clouds']['all'];

                $tmpArray['averagewindspeed'] += $data['wind']['speed'];
                $tmpArray['averagewinddeg'] += $data['wind']['deg'];

                $tmpArray['averagpressure'] += $data['main']['pressure'];
                $tmpArray['averaghumidity'] += $data['main']['humidity'];
                break;
            case '16':
                $tmpArray['averagetemp'] += $data['main']['temp'];

                $tmpArray['averagecloud'] += $data['clouds']['all'];

                $tmpArray['averagewindspeed'] += $data['wind']['speed'];
                $tmpArray['averagewinddeg'] += $data['wind']['deg'];

                $tmpArray['averagpressure'] += $data['main']['pressure'];
                $tmpArray['averaghumidity'] += $data['main']['humidity'];
                break;
            case '17':
                $tmpArray['evetemp'] = $data['main']['temp'];
                break;
            case '18':
                $tmpArray['evetemp'] = $data['main']['temp'];
                break;
            case '19':
                $tmpArray['evetemp'] = $data['main']['temp'];
                break;
            case '20':
                $tmpArray['nighttemp'] += $data['main']['temp'];
                break;
            case '21':
                $tmpArray['nighttemp'] += $data['main']['temp'];
                break;
            case '22':
                $tmpArray['nighttemp'] += $data['main']['temp'];
                break;
            case '23':
                $tmpArray['nighttemp'] += $data['main']['temp'];
                break;
        }

        return $tmpArray;
    }

    public function FetchWeather()
    {


        $url = $this->BuildURL();

        if ($url != "error") {
            $json = file_get_contents($url);
            $data = json_decode($json, true);
        }
        $weatherData = array();

        switch ($this->weathertype) {
            case 'forecast':
                $this->cityname = $data['city']['name'];
                $day = date('d', time());

                if (isset($data['list'])) {
                    foreach ($data['list'] as $dayweather) {

                        if ($day == date('d', $dayweather['dt'])) {

                            $tmpArray['mintemp'] = min($dayweather['main']['temp_min'], $tmpArray['mintemp']);
                            $tmpArray['maxtemp'] = max($dayweather['main']['temp_max'], $tmpArray['maxtemp']);

                            $tmpArray = $this->calcAverage($dayweather, $tmpArray);


                            //echo"<pre>";var_dump($tmpArray);

                        } else {

                            $weatherData[] = array(
                                'tstamp' => time(),
                                'daytime' => $tmpArray['daytime'],

                                'temp' => (round(($tmpArray['averagetemp'] / 3), 2)),
                                'mintemp' => $tmpArray['mintemp'],
                                'maxtemp' => $tmpArray['maxtemp'],


                                'pressure' => (round(($tmpArray['averagpressure'] / 3), 2)),
                                'humidity' => (round(($tmpArray['averaghumidity'] / 3), 2)),

                                'weather_id' => $tmpArray['weather_id'],
                                'weather_desc' => $tmpArray['weather_desc'],
                                'weather_icon' => $tmpArray['weather_icon'],

                                'speed' => (round(($tmpArray['averagewindspeed'] / 3), 2)),
                                'deg' => (round(($tmpArray['averagewinddeg'] / 3), 2)),
                                'clouds' => (round(($tmpArray['averagecloud'] / 3), 2)),

                                'nighttemp' => (round(($tmpArray['nighttemp'] / 3), 2)),
                                'evetemp' => $tmpArray['evetemp'],
                                'morntemp' => $tmpArray['morntemp']

                            );
                            $tmpArray = array();
                            $day = date('d', $dayweather['dt']);

                            $tmpArray['mintemp'] = $dayweather['main']['temp_min'];
                            $tmpArray['maxtemp'] = $dayweather['main']['temp_max'];

                            $tmpArray = $this->calcAverage($dayweather, $tmpArray);
                        }
                    }

                    $weatherData[] = array(
                        'tstamp' => time(),
                        'daytime' => $tmpArray['daytime'],

                        'temp' => ($tmpArray['averagetemp'] / 3),
                        'mintemp' => $tmpArray['mintemp'],
                        'maxtemp' => $tmpArray['maxtemp'],


                        'pressure' => ($tmpArray['averagpressure'] / 3),
                        'humidity' => ($tmpArray['averaghumidity'] / 3),

                        'weather_id' => $tmpArray['weather_id'],
                        'weather_desc' => $tmpArray['weather_desc'],
                        'weather_icon' => $tmpArray['weather_icon'],

                        'speed' => ($tmpArray['averagewindspeed'] / 3),
                        'deg' => ($tmpArray['averagewinddeg'] / 3),
                        'clouds' => ($tmpArray['averagecloud'] / 3),

                        'nighttemp' => ($tmpArray['nighttemp'] / 3),
                        'evetemp' => $tmpArray['evetemp'],
                        'morntemp' => $tmpArray['morntemp']
                    );

                    $weatherData[0]['temp'] = $data['list'][0]['main']['temp'];
                    $weatherData[0]['daytime'] = $data['list'][0]['dt'];
                    $weatherData[0]['mintemp'] = $data['list'][0]['main']['temp_min'];
                    $weatherData[0]['maxtemp'] = $data['list'][0]['main']['temp_max'];
                    $weatherData[0]['pressure'] = $data['list'][0]['main']['pressure'];
                    $weatherData[0]['humidity'] = $data['list'][0]['main']['humidity'];
                    $weatherData[0]['speed'] = $data['list'][0]['wind']['speed'];
                    $weatherData[0]['deg'] = $data['list'][0]['wind']['deg'];
                    $weatherData[0]['clouds'] = $data['list'][0]['clouds']['all'];
                    $weatherData[0]['weather_desc'] = $data['list'][0]['weather'][0]["description"];
                    $weatherData[0]['weather_icon'] = $data['list'][0]['weather'][0]["icon"];
                    $weatherData[0]['weather_id'] = $data['list'][0]['weather'][0]["id"];
                }
                break;
            case 'forecast-daily':
                $this->cityname = $data['city']['name'];
                if (isset($data['list'])) {
                    foreach ($data['list'] as $dayweather) {
                        $weatherData[] = array(
                            'tstamp' => time(),
                            'daytime' => $dayweather['dt'],

                            'temp' => $dayweather['temp']['day'],
                            'mintemp' => $dayweather['temp']['min'],
                            'maxtemp' => $dayweather['temp']['max'],


                            'pressure' => $dayweather['pressure'],
                            'humidity' => $dayweather['humidity'],

                            'weather_id' => $dayweather['weather'][0]['id'],
                            'weather_desc' => $dayweather['weather'][0]['description'],
                            'weather_icon' => $dayweather['weather'][0]['icon'],

                            'speed' => $dayweather['speed'],
                            'deg' => $dayweather['deg'],
                            'clouds' => $dayweather['clouds'],
                            'rain' => $dayweather['rain']
                        );
                    }
                }
                break;
            case 'current':
                $dayweather = $data;
                $this->cityname = $dayweather['name'];
                if (isset($data['main'])) {
                    $weatherData[] = array(
                        'tstamp' => time(),
                        'daytime' => $dayweather['dt'],
                        'sunrise' => $dayweather['sys']['sunrise'],
                        'sunset' => $dayweather['sys']['sunset'],

                        'temp' => $dayweather['main']['temp'],
                        'mintemp' => $dayweather['main']['temp_min'],
                        'maxtemp' => $dayweather['main']['temp_max'],


                        'pressure' => $dayweather['main']['pressure'],
                        'humidity' => $dayweather['main']['humidity'],

                        'weather_id' => $dayweather['weather'][0]['id'],
                        'weather_desc' => $dayweather['weather'][0]['description'],
                        'weather_icon' => $dayweather['weather'][0]['icon'],

                        'speed' => $dayweather['wind']['speed'],
                        'deg' => $dayweather['wind']['deg'],
                        'clouds' => $dayweather['clouds']['all']
                    );
                }
                break;
        }

        if (empty($weatherData)) {
            $weatherData[] = array(
                'tstamp' => time(),
                'daytime' => 'error',
                'sunrise' => 'error',
                'sunset' => 'error',

                'temp' => 'error',
                'mintemp' => 'error',
                'maxtemp' => 'error',


                'pressure' => 'error',
                'humidity' => 'error',

                'weather_id' => 'error',
                'weather_desc' => 'error',
                'weather_icon' => 'error',

                'speed' => 'error',
                'deg' => 'error',
                'clouds' => 'error'
            );
            $this->cityname = "error";
        }
        return $weatherData;
    }

    public function FetchName()
    {
        return $this->cityname;
    }

}
