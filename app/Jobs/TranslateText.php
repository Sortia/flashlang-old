<?php

namespace App\Jobs;

use App\Http\Services\TranslateTextService;
use App\Models\Storybook;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TranslateText implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected TranslateTextService $service;

    protected Storybook $storybook;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Storybook $storybook)
    {
        $this->storybook = $storybook;
        $this->service   = new TranslateTextService();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $translated = $this->service->translate($this->storybook->text);

        $this->storybook->translation()->create([
            'text' => $translated,
            'language' => 'ru'
        ]);
    }
}
