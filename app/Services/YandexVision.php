<?php


namespace Vanguard\Services;


use Illuminate\Support\Facades\Http;

class YandexVision
{
    const api_key = "AQVN2W9vvz5ciJTwUPEnn2k2k-H6UiWWEed1X50u";
    const folder_id = "b1g5chorkpegebu15223";


    public function analyze($file)
    {
        $encoded = base64_encode(file_get_contents($file));

        return Http::withHeaders([
            'Authorization' => "Api-Key " . self::api_key
        ])
            ->post('https://vision.api.cloud.yandex.net/vision/v1/batchAnalyze', [
            'folder_id' => self::folder_id,
            "analyze_specs" => [
                "content" => $encoded,
                "features" => [
                    "type" => "TEXT_DETECTION",
                    "text_detection_config" => [
                        "language_codes" => ["he"]
                    ]
                ]
            ]
        ]);
    }
}
