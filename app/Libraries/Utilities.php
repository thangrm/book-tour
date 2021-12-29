<?php

namespace App\Libraries;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Utilities
{
    /**
     * @param string $string
     * @return string
     */
    public static function clearXSS(string $string)
    {
        $string = nl2br($string);
        $string = trim(strip_tags($string));
        $string = self::removeScripts($string);

        return $string;
    }

    /**
     * @param array $rawData
     * @return array
     */
    public static function clearAllXSS(array $rawData)
    {
        foreach ($rawData as $key => $value) {
            $value = nl2br($value);
            $value = trim(strip_tags($value));
            $value = self::removeScripts($value);
            $string[$key] = self::clearXSS($value);
        }

        return $rawData;
    }

    /**
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
     * @param int $duration
     * @return string
     */
    public static function durationToString(int $duration)
    {
        if ($duration < 1 || empty($duration)) {
            return '';
        } elseif ($duration == 1) {
            return 'a day';
        } else {
            $night = $duration - 1;
            if ($night == 1) {
                return "$duration days, $night night";
            } else {
                return "$duration days, $night nights";
            }
        }

    }

    /**
     * @param Request $request
     * @param string $nameFile
     * @param string $path
     * @return string
     */
    public static function storeImage(Request $request, string $nameFile, string $path)
    {
        $file = $request->file($nameFile)->getClientOriginalName();
        $file_name = Str::slug(pathinfo($file, PATHINFO_FILENAME));
        $extension = pathinfo($file, PATHINFO_EXTENSION);
        $imageName = date('YmdHis') . '-' . uniqid() . $file_name . '.' . $extension;
        $request->file($nameFile)->storeAs($path, $imageName);

        return $imageName;
    }
}
