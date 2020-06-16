<?php

namespace App\Http\Controllers\Telegram\Commands;

use App\Exports\FlashcardsExport;
use App\Http\Controllers\Telegram\TelegramDocumentSender;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Telegram\Bot\Commands\Command;

class ExportFlashcardsCommand extends Command
{
    use ShouldAuth;
    use TelegramDocumentSender;

    /**
     * @var string Command Name
     */
    protected $name = "export_flashcards";

    /**
     * @var string Command Description
     */
    protected $description = "Export user flashcards";

    public function __construct()
    {
        $this->authUser();
    }

    /**
     * @inheritDoc
     */
    public function handle()
    {
        Excel::store(new FlashcardsExport(), 'temp/flashcards.csv');

        $this->replyWithDocument(['document' => storage_path('app/temp/flashcards.csv')]);

        Storage::delete('temp/flashcards.csv');
    }
}
