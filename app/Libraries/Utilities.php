<?php

namespace App\Libraries;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Utilities
{
    /**
     * Clear XSS for a string
     *
     * @param string|null $string
     * @return string
     */
    public static function clearXSS(?string $string): string
    {
        $string = nl2br($string);
        $string = trim(strip_tags($string));
        return self::removeScripts($string);
    }

    /**
     * Clear XSS for array
     *
     * @param array $rawData
     * @return array
     */
    public static function clearAllXSS(array $rawData, $except = [])
    {
        foreach ($rawData as $key => $value) {
            if (!in_array($key, $except)) {
                $rawData[$key] = self::clearXSS($value);
            }
        }

        return $rawData;
    }

    /**
     * Remove tag script
     *
     * @param string $str
     * @return string
     */
    public static function removeScripts(string $str)
    {
        $regex =
            '/(<link[^>]+rel="[^"]*stylesheet"[^>]*>)|' .
            '<script[^>]*>.*?<\/script>|' .
            '<style[^>]*>.*?<\/style>|' .
            '<!--.*?-->/is';

        return preg_replace($regex, '', $str);
    }

    /**
     * render duration string
     *
     * @param int $duration
     * @return string
     */
    public static function durationToString(int $duration)
    {
        if ($duration < 1 || empty($duration)) {
            return '';
        }

        if ($duration == 1) {
            return 'a day';
        }

        $night = $duration - 1;
        if ($night == 1) {
            return "$duration days, $night night";
        }

        return "$duration days, $night nights";
    }

    /**
     * Calculate rate for reviews
     *
     * @param $reviews
     * @return float[]
     */
    public static function calculatorRateReView($reviews)
    {
        $sumRate = 0;
        $rate = [
            'oneStar' => 0,
            'twoStar' => 0,
            'threeStar' => 0,
            'fourStar' => 0,
            'fiveStar' => 0
        ];

        foreach ($reviews as $review) {
            $rate['oneStar'] += ($review->rate == 1) ? 1 : 0;
            $rate['twoStar'] += ($review->rate == 2) ? 1 : 0;
            $rate['threeStar'] += ($review->rate == 3) ? 1 : 0;
            $rate['fourStar'] += ($review->rate == 4) ? 1 : 0;
            $rate['fiveStar'] += ($review->rate == 5) ? 1 : 0;

            $sumRate += $review->rate;
        }

        $rate['total'] = ceil($sumRate / count($reviews) * 10) / 10;

        return $rate;
    }

    /**
     * Store a image
     *
     * @param $image
     * @param string $path
     * @return string
     */
    public static function storeImage($image, string $path)
    {
        $file = $image->getClientOriginalName();
        $file_name = Str::slug(pathinfo($file, PATHINFO_FILENAME));
        $extension = pathinfo($file, PATHINFO_EXTENSION);
        $imageName = date('YmdHis') . '-' . uniqid() . $file_name . '.' . $extension;
        $image->storeAs($path, $imageName);

        return $imageName;
    }

    /**
     * Multiple store images
     *
     * @param $images
     * @param string $path
     * @return array
     */
    public static function storeMultiImage($images, string $path)
    {
        $listNameImages = [];
        foreach ($images as $image) {
            $listNameImages[] = self::storeImage($image, $path);
        }

        return $listNameImages;
    }
}
