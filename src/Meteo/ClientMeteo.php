<?php

namespace App\Meteo;

use App\Entity\Ville;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class ClientMeteo
{
    public function __construct(
        private HttpClientInterface $client,
        #[Autowire(env: 'METEO_URL')] private string $urlMeteo,
        #[Autowire(env: 'AIR_URL')] private string $urlAir,
    ) {
    }

    /**
     * @return array{heure: string, temperature: float, vent: float, code: int, libelle: string}
     */
    public function meteoActuelle(Ville $ville): array
    {
        $reponse = $this->client->request('GET', $this->urlMeteo . '/v1/forecast', [
            'query' => [
                'latitude' => $ville->getLatitude(),
                'longitude' => $ville->getLongitude(),
                'current' => 'temperature_2m,wind_speed_10m,weather_code',
                'timezone' => 'Europe/Paris',
            ],
        ]);

        $actuel = $reponse->toArray()['current'];

        return [
            'heure' => $actuel['time'],
            'temperature' => (float) $actuel['temperature_2m'],
            'vent' => (float) $actuel['wind_speed_10m'],
            'code' => (int) $actuel['weather_code'],
            'libelle' => CodeMeteo::libelle((int) $actuel['weather_code']),
        ];
    }

        /**
     * @return array{heure: string, indice: int, pm25: float, pm10: float, no2: float}
     */
    public function qualiteAir(Ville $ville): array
    {
        $reponse = $this->client->request('GET', $this->urlAir . '/v1/air-quality', [
            'query' => [
                'latitude' => $ville->getLatitude(),
                'longitude' => $ville->getLongitude(),
                'current' => 'european_aqi,pm2_5,pm10,nitrogen_dioxide',
                'timezone' => 'Europe/Paris',
            ],
        ]);

        $actuel = $reponse->toArray()['current'];

        return [
            'heure' => $actuel['time'],
            'indice' => (int) $actuel['european_aqi'],
            'pm25' => (float) $actuel['pm2_5'],
            'pm10' => (float) $actuel['pm10'],
            'no2' => (float) $actuel['nitrogen_dioxide'],
        ];
    }
}