<?php

namespace Vanguard\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Vanguard\Document;
use Vanguard\Services\YandexVision;

class ProcessDocument implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $file;
    /**
     * @var Document
     */
    protected $document;

    /**
     * Create a new job instance.
     *
     * @param $file
     * @param Document $document
     */
    public function __construct($file, Document $document)
    {
        $this->file = $file;
        $this->document = $document;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $yandex = new YandexVision();

        $response = $yandex->analyze($this->file)->json();

        $text = array_map(function ($block) {
            return array_map(function ($line) {
                return implode(" ", array_map(function ($word) {
                    return $word['text'];
                }, $line['words']));
            }, $block['lines']);
        }, $response['results'][0]['results'][0]['textDetection']['pages'][0]['blocks']);

        $text = join("\n", array_map(function ($t) {
            return $t[0];
        }, $text));

        $this->document->document_text = $text;
        $this->document->save();
    }
}
