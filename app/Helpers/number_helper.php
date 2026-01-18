<?php
// app/Helpers/number_helper.php

if (! function_exists('numberToWordsFr')) {
    function numberToWordsFr($number)
    {
        $number = (string) $number;
        // gérer éventuellement les signes et décimales côté wrapper si besoin
        if (! is_numeric($number)) {
            return false;
        }

        $n = (int) $number;
        if ($n === 0) {
            return 'zéro';
        }

        $units = [
            0  => 'zéro', 1  => 'un', 2     => 'deux', 3    => 'trois', 4     => 'quatre', 5 => 'cinq',
            6  => 'six', 7   => 'sept', 8   => 'huit', 9    => 'neuf', 10     => 'dix',
            11 => 'onze', 12 => 'douze', 13 => 'treize', 14 => 'quatorze', 15 => 'quinze',
            16 => 'seize',
        ];

        $tens = [
            20 => 'vingt', 30 => 'trente', 40 => 'quarante', 50 => 'cinquante', 60 => 'soixante',
        ];

        $underHundred = function ($num) use (&$units, &$tens, &$underHundred) {
            $num = (int) $num;
            if ($num < 17) {
                return $units[$num];
            }
            if ($num < 20) {
                return 'dix-' . $units[$num - 10];
            }
            if ($num < 70) {
                $ten  = intdiv($num, 10) * 10;
                $unit = $num % 10;
                $word = $tens[$ten];
                if ($unit === 1) {
                    // vingt et un, trente et un, ... (et uniquement pour 21,31,41,51,61)
                    return $word . ' et un';
                } elseif ($unit > 0) {
                    return $word . '-' . $units[$unit];
                } else {
                    return $word;
                }
            }
            if ($num < 80) {
                // 70..79 -> soixante + 10..19
                $unit = $num - 60;
                if ($unit == 11) {
                    return 'soixante et onze';
                }
                return 'soixante-' . $underHundred($unit);
            }
            // 80..99
            $unit = $num - 80;
            if ($unit === 0) {
                return 'quatre-vingts';
            }
            if ($unit === 1) {
                return 'quatre-vingt-un';
            }
            return 'quatre-vingt-' . $underHundred($unit);
        };

        $underThousand = function ($num) use (&$underHundred) {
            $num = (int) $num;
            if ($num < 100) {
                return $underHundred($num);
            }
            $hundreds = intdiv($num, 100);
            $rest     = $num % 100;
            if ($hundreds === 1) {
                $word = 'cent';
            } else {
                $word = $underHundred($hundreds) . ' cent';
            }
            // pluriel 'cents' si multiple de 100
            if ($rest === 0 && $hundreds > 1) {
                $word .= 's';
                return $word;
            }
            if ($rest > 0) {
                $word .= ' ' . $underHundred($rest);
            }
            return $word;
        };

        $words  = '';
        $scales = [
            1000000000 => 'milliard',
            1000000    => 'million',
            1000       => 'mille',
        ];

        foreach ($scales as $value => $name) {
            if ($n >= $value) {
                $count = intdiv($n, $value);
                $n     = $n % $value;
                if ($value === 1000) {
                    // "mille" ne prend pas "un" devant
                    if ($count === 1) {
                        $words .= ($words ? ' ' : '') . 'mille';
                    } else {
                        $words .= ($words ? ' ' : '') . numberToWordsFr($count) . ' mille';
                    }
                } else {
                    $words .= ($words ? ' ' : '') . numberToWordsFr($count) . ' ' . $name;
                    if ($count > 1) {
                        $words .= 's';
                    }

                }
            }
        }

        if ($n > 0) {
            // si déjà des mots, ajouter un espace
            $words .= ($words ? ' ' : '') . $underThousand($n);
        }

        return $words;
    }
}

if (! function_exists('numberToWordsFrCurrency')) {
    /**
     * Convertit un montant (float) en mots français, avec unité principale et cents.
     * Ex: 1234.56 -> "mille deux cent trente-quatre francs cinquante-six centimes"
     *
     * @param float|string $amount
     * @param string $main  unité principale (ex: 'francs')
     * @param string $sub   sous-unité (ex: 'centimes')
     * @return string
     */
    function numberToWordsFrCurrency($amount, $main = 'franc', $sub = 'centime')
    {
        if (! is_numeric($amount)) {
            return '';
        }

        $amount   = (float) $amount;
        $integer  = floor($amount);
        $fraction = (int) round(($amount - $integer) * 100);

        $mainWord = numberToWordsFr($integer);
        // Pluriel unité principale
        $mainLabel = $main . ($integer > 1 ? 's' : '');

        $result = trim($mainWord . ' ' . $mainLabel);

        if ($fraction > 0) {
            $fractionWord = numberToWordsFr($fraction);
            $subLabel     = $sub . ($fraction > 1 ? 's' : '');
            $result .= ' et ' . $fractionWord . ' ' . $subLabel;
        }

        // première lettre en majuscule
        return mb_strtoupper(mb_substr($result, 0, 1)) . mb_substr($result, 1);
    }
}
