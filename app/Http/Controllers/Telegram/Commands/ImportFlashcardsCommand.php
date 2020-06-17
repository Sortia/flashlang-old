<?php

namespace App\Http\Controllers\Telegram\Commands;

use App\Exceptions\TelegramAuthException;
use App\Http\Controllers\Telegram\TelegramDocumentDownloader;
use App\Imports\FlashcardsImport;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Telegram\Bot\Commands\Command;

class ImportFlashcardsCommand extends Command
{
    use Authenticable;
    use TelegramDocumentDownloader;

    /**
     * @var string Command Name
     */
    protected $name = "import_flashcards";

    /**
     * @var string Command Description
     */
    protected $description = "Import flashcards";

    /**
     * Command handler
     *
     * @inheritDoc
     * @throws TelegramAuthException
     */
    public function handle()
    {
        $this->authUser();

        Storage::put('temp/flashcards.csv', $this->getFile());

        Excel::import(new FlashcardsImport(), storage_path('app/temp/flashcards.csv'));

        Storage::delete('temp/flashcards.csv');

        $this->replyWithMessage(['text' => 'Successful']);
    }

}
