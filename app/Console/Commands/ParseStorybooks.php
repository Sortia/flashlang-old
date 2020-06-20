<?php

namespace App\Console\Commands;

use App\Helpers\Timer;
use App\Models\Storybook;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ParseStorybooks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storybook:parse {text}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Loading storybooks from file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Timer::start();

        $text = $this->readFile($this->argument('text'));

        $this->process($text);
        $this->indexing();

        Timer::stop();
        $this->comment(Timer::get());
    }

    /**
     * Read $name file
     */
    private function readFile($name)
    {
        $this->comment('Start read ' . $name);

        $file = file($name);

        $this->comment('Finish read ' . $name);

        return $file;
    }

    /**
     * Add sentences in database
     */
    private function process($text): void
    {
        Storybook::truncate();

        $arrText = [];
        $countAdded = 0;

        $countLines = count($text);

        $this->comment('Total rows: ' . $countLines);
        $this->comment('Add to database');

        $bar = $this->output->createProgressBar($countLines);

        $bar->start();

        for ($i = 0; $i < $countLines; $i++) {

            if (Str::length($text[$i]) >= 50) {
                $arrText[]['text'] = $text[$i];
                ++$countAdded;
            }

            if (count($arrText) === 100) {
                Storybook::on()->insert($arrText);
                $arrText = [];
            }

            $bar->advance();
        }

        $bar->finish();

        $this->comment('');
        $this->comment('Added ' . $countAdded . ' rows');
        $this->comment('Ignored ' . ($countLines - $countAdded) . ' rows');
    }

    /**
     * Elasticsearch indexing
     */
    private function indexing(): void
    {
        Storybook::deleteIndex();

        $this->comment('Create index');
        Storybook::createIndex();

        $this->comment('Put mapping');
        Storybook::putMapping($ignoreConflicts = true);

        $this->comment('Add all to index');
        Storybook::addAllToIndex();

        $this->comment('Finish indexing');
    }
}
