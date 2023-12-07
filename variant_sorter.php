<?php

// Veritabanından gelebilecek karışık varyantları olması gerektiği gibi bir sıraya sokar. Ayakkabı numaraları gibi numerik değerleri sıralı bir şekilde en sol tarafa; S,M,L,XL gibi beden bilgilerini sıralı bir şekilde orta tarafa; geri kalan tüm string ifadeleri natural comparison yaparak sıralı bir şekilde en sağ tarafa koyar. En sol, orta, en sağ hizalamaları veritabanından gelebilecek karışık yani düzensiz varyantları da bir düzene koymak içindir. Gelen varyantların ['7xl', 'l', 'XXXL', 'M', 'S', 'XL', 'XXS', 10, 'XXXS', '12', '20x120', '10x120', '30x120', '100x120', '45', '43'] gibi olduğunu düşünürsek bunu bile bir düzene sokacaktır.

function sortVariants(array &$array, bool $indexAssocFlag): bool
{
    if ($indexAssocFlag) {
        // uasort index ilişkilendirmesini kaybettirmez
        return uasort($array, 'compare');
    }
    return usort($array, 'compare');
}

function compare($a, $b): int
{
    $sizes = array(
        'XXXXXXXXXXS',
        '10XS',
        'XXXXXXXXXS',
        '9XS',
        'XXXXXXXXS',
        '8XS',
        'XXXXXXXS',
        '7XS',
        'XXXXXXS',
        '6XS',
        'XXXXXS',
        '5XS',
        'XXXXS',
        '4XS',
        // Buradan öncesi mikroorganizmalara özel seri(malesef veritabanında böyle veriler var)
        'XXXS',
        '3XS',
        'XXXS/XXS',
        'XXXS-XXS',
        'XXS/XXXS',
        'XXS-XXXS',
        'XXSMALL',
        'XXS',
        'XXS/XS',
        'XXS-XS',
        'XS/XXS',
        'XS-XXS',
        'XSMALL',
        'XS',
        'XS/S',
        'XS-S',
        'S/XS',
        'S-XS',
        'SMALL',
        'S',
        'S/M',
        'S-M',
        'M/S',
        'M-S',
        'MEDIUM',
        'M',
        'M/L',
        'M-L',
        'L/M',
        'L-M',
        'LARGE',
        'L',
        'L/XL',
        'L-XL',
        'XL/L',
        'XL-L',
        'XLARGE',
        'XL',
        'XL/XXL',
        'XL-XXL',
        'XXL/XL',
        'XXL-XL',
        'XXLARGE',
        'XXL',
        '2XL',
        'XXL/XXXL',
        'XXL-XXXL',
        'XXXL/XXL',
        'XXXL-XXL',
        'XXXL',
        '3XL',
        'XXXXL',
        '4XL',
        'XXXXXL',
        '5XL',
        'XXXXXXL',
        '6XL',
        'XXXXXXXL',
        '7XL',
        // Buradan sonrası mutantlara, hayvanlar alemindeki çeşitli canlılara özel seri :)
        'XXXXXXXXL',
        '8XL',
        'XXXXXXXXXL',
        '9XL',
        'XXXXXXXXXXL',
        '10XL',
        'XXXXXXXXXXXL',
        '11XL',
        'XXXXXXXXXXXXL',
        '12XL',
        'XXXXXXXXXXXXXL',
        '13XL',
        'XXXXXXXXXXXXXXL',
        '14XL',
        'XXXXXXXXXXXXXXXL',
        '15XL',
    );

    $aUpper = strtoupper($a);
    $bUpper = strtoupper($b);

    $aIndex = -1;
    $aPosition  = -1;

    $bIndex = -1;
    $bPosition  = -1;

    foreach ($sizes as $sizeIndex => $size) {

        $positionDecider = ($aUpper == $size) ? 1 : -1;

        if ($positionDecider > 0) {
            $aIndex = $sizeIndex;
            $aPosition  = $positionDecider;
        }

        $positionDecider = ($bUpper == $size) ? 1 : -1;

        if ($positionDecider > 0) {
            $bIndex = $sizeIndex;
            $bPosition  = $positionDecider;
        }

        // Algoritma performans optimizasyonu
        // İkiside atandıysa döngüye devam etmesin
        if ($aIndex > -1 && $bIndex > -1) {
            break;
        }
    }

    if ($aPosition < 0) {
        if (is_numeric($a) && is_numeric($b)) {
            return ($a == $b) ? 0 : (($a > $b) ? 1 : -1);
        } else {
            return is_numeric($a) ? -1 : ((!is_numeric($b) && $bPosition < 0) ? strnatcmp($a, $b) : 1);
        }
    }

    if ($bPosition < 0) {
        if (is_numeric($a) && is_numeric($b)) {
            return ($a == $b) ? 0 : (($a > $b) ? 1 : -1);
        } else {
            return is_numeric($b) ? 1 : -1;
        }
    }

    return $aIndex == $bIndex ? 0 : (($aIndex > $bIndex) ? 1 : -1);
}

// Example usages:
$arr_ = ['100gr', '7xl', '50gr', 'l', 'XXXL', 'M', 'S', 'XL', 'XXS', 10, 'XXXS', '12', '20x120', '10x120', '30x120', '100x120', '45', '43', '300gr'];

$arr_ = ["50x100", "120X200", "100X200", "90X200", "130x200", "90X190", "80X180", "80X130", "60x120"];

$arr = ['1000gr', "3xl", "l", 36, "50x100", 45, "120X200", "s", "M", 43, 42, "100X200", 41, "10xL", "90X200", "130x200", "90X190", "Xl", "xXl", "80X180", "80X130", 41, "60x120", "3xs", 40, 37, 38, "500x100", "1200X200", "1000X200", "900X200", '50gr', "1300x200", "900X190", "800X180", 31, 'xxsMaLL', '250gr'];

sortVariants($arr, false);

print_r($arr);
