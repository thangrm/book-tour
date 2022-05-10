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
    public static function clearXSS(?string $string)
    {
        if ($string == null) {
            return $string;
        }

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
//            return 'a day';
            return 'một ngày';
        }

        $night = $duration - 1;
        if ($night == 1) {
            return "$duration ngày, $night đêm";
//            return "$duration days, $night night";
        }

        return "$duration ngày, $night đêm";
//        return "$duration days, $night nights";
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
            'fiveStar' => 0,
            'countReviews' => [$reviews->count(), 0, 0, 0, 0, 0],
            //countReviews is [total, oneStar, twoStar, threeStar, fourStar, fiveStar]
        ];

        foreach ($reviews as $review) {
            $rate['countReviews'][1] += ($review->rate == 1) ? 1 : 0;
            $rate['countReviews'][2] += ($review->rate == 2) ? 1 : 0;
            $rate['countReviews'][3] += ($review->rate == 3) ? 1 : 0;
            $rate['countReviews'][4] += ($review->rate == 4) ? 1 : 0;
            $rate['countReviews'][5] += ($review->rate == 5) ? 1 : 0;

            $sumRate += $review->rate;
        }

        if ($reviews->count() > 0) {
            $rate['oneStar'] = $rate['countReviews'][1] / $reviews->count() * 100;
            $rate['twoStar'] = $rate['countReviews'][2] / $reviews->count() * 100;
            $rate['threeStar'] = $rate['countReviews'][3] / $reviews->count() * 100;
            $rate['fourStar'] = $rate['countReviews'][4] / $reviews->count() * 100;
            $rate['fiveStar'] = $rate['countReviews'][5] / $reviews->count() * 100;
        }

        $rate['total'] = 5;

        if (count($reviews) > 0) {
            $rate['total'] = ceil($sumRate / count($reviews) * 10) / 10;
        }

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

    public static function dateRange($first, $last, $step = '+1 day', $format = 'Y-m-d')
    {
        $dates = array();
        $current = strtotime($first);
        $last = strtotime($last);

        while ($current <= $last) {
            $dates[] = date($format, $current);
            $current = strtotime($step, $current);
        }

        return $dates;
    }
}
