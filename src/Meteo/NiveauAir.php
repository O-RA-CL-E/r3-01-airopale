<?php

namespace App\Meteo;

final class NiveauAir
{
    /**
     * @return array{libelle: string, classe: string}
     */
    public static function depuisIndice(int $indice): array
    {
        return match (true) {
            $indice < 20 => ['libelle' => 'Bon', 'classe' => 'bon'],
            $indice < 40 => ['libelle' => 'Correct', 'classe' => 'correct'],
            $indice < 60 => ['libelle' => 'Moyen', 'classe' => 'moyen'],
            $indice < 80 => ['libelle' => 'Médiocre', 'classe' => 'mediocre'],
            $indice <= 100 => ['libelle' => 'Très médiocre', 'classe' => 'tres-mediocre'],
            default => ['libelle' => 'Extrêmement médiocre', 'classe' => 'extremement-mediocre'],
        };
    }
}