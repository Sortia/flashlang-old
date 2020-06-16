<?php

namespace App\Http\Controllers\Telegram\Commands;

use App\Http\Controllers\Telegram\TelegramDocumentSender;
use App\Http\Controllers\Telegram\TelegramFileDownloader;
use App\Imports\FlashcardsImport;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Telegram\Bot\Commands\Command;

class ImportFlashcardsCommand extends Command
{
    use ShouldAuth;
    use TelegramDocumentSender;
    use TelegramFileDownloader;

    /**
     * @var string Command Name
     */
    protected $name = "import_flashcards";

    /**
     * @var string Command Description
     */
    protected $description = "Import flashcards";

    public function __construct()
    {
        $this->authUser();
    }

    /**
     * @inheritDoc
     */
    public function handle()
    {
        Storage::put('temp/flashcards.csv', $this->getFile());

        Excel::import(new FlashcardsImport(), storage_path('app/temp/flashcards.csv'));

        Storage::delete('temp/flashcards.csv');

        $this->replyWithMessage(['text' => 'Successful']);
    }

}
