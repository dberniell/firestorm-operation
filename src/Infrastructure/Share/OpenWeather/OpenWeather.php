<?php

declare(strict_types=1);

namespace App\Infrastructure\Share\OpenWeather;

use DateInterval;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\HttpClient\HttpClient;

class OpenWeather
{
    public function pronosticate()
    {
        $cachedForecasts = $this->redis->getItem('forecasts');
        if ($cachedForecasts->isHit()) {
            foreach ($cachedForecasts->get() as $forecast) {
                if ($forecast['dt']  >= time() + (24 * 60 * 60)) {
                    $nextDayForecast = $this->getNextDayForecast($forecast);
                    break;
                }
            }
        } else {
            $nextDayForecast = $this->getForecastFromOpenWeather();
        }

        return $nextDayForecast;

    }

    public function getNextDayForecast(array $nextDayForecast): string
    {
        $response = [
            "wind" => $nextDayForecast["wind"],
            "humidity" => $nextDayForecast["main"]["humidity"]
        ];

        return json_encode($response);
    }

    public function getForecastFromOpenWeather()
    {
        $client = HttpClient::create();
        $response = $client->request(
            'GET',
            'http://api.openweathermap.org/data/2.5/forecast?q=Barcelona,es&appid=12729676772ea2e927400f310f21a9eb'
        );
        $content = $response->toArray();

        return $this->getNextDayForeCastFromApiResponse($content["list"]);
    }
    public function getNextDayForecastFromApiResponse(array $list): string
    {
        $forecasts = (array) array_filter($list, function ($row) {
            return ((int) $row["dt"]) >= time() + (24 * 60 * 60);
        });

        $this->saveForecastsToCache($forecasts);

        return $this->getNextDayForecast(array_shift($forecasts));
    }

    private function saveForecastsToCache($forecasts): void
    {
        $cache = $this->redis->getItem('forecasts');
        $cache->set($forecasts);
        $cache->expiresAfter(DateInterval::createFromDateString('3 days'));
        $this->redis->save($cache);
    }

    public function __construct(AdapterInterface $redisAdapter )
    {
        $this->redis = $redisAdapter;
    }

    /**
     * @var AdapterInterface
     */
    private $redis;
}