<?php


namespace Vanguard\Services;


use Illuminate\Support\Facades\Http;

class AbbyOCR
{
    const base_url = "https://cloud-eu.ocrsdk.com/v2/";
    const applicationId = 'c888008e-2189-4401-8cff-c614b82ae16a';
    const password = 'N66VxqIbR+qe1uE08L5h2vCW';


    public static function processDocument($file) {
        $url = self::base_url . "processImage?language=Hebrew&profile=textExtraction";

        $encoded = base64_encode(self::applicationId . ":" . self::password);

        dump($file);

        return Http::withHeaders([
            'Authorization' => "Basic $encoded"
        ])->attach('file', file_get_contents($file))->post($url);
    }
}
