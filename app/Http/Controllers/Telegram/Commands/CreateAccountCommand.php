<?php

namespace App\Http\Controllers\Telegram\Commands;

use App\Http\Controllers\Telegram\TelegramDocumentDownloader;
use App\Http\Services\FileService;
use App\Models\User;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Exceptions\TelegramSDKException;

class CreateAccountCommand extends Command
{
    use TelegramDocumentDownloader;

    /**
     * @var string Command Name
     */
    protected $name = "create_account";

    /**
     * @var string Command Description
     */
    protected $description = "Create account";

    /**
     * @var FileService
     */
    protected FileService $fileService;

    /**
     * CreateAccountCommand constructor.
     */
    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * Command handler
     *
     * @inheritDoc
     * @throws TelegramSDKException
     */
    public function handle()
    {
        $this->createUser();
        $this->replyWithMessage(['text' => 'Successful']);
    }

    /**
     * @throws TelegramSDKException
     */
    private function getAvatar(): string
    {
        $fileId = $this->getTelegram()->getUserProfilePhotos([
            'user_id' => $this->getUpdate()->getChat()->id
        ])->photos[0][0]['file_id'];

        return $this->getDocumentByFileId($fileId);
    }

    /**
     * @throws TelegramSDKException
     */
    private function createUser()
    {
        $user = $this->getUpdate()->getMessage()->from;
        $avatar = $this->getAvatar();
        $path = $this->fileService->save($avatar);

        User::create([
            'name' => $user->firstName . ' ' . $user->lastName,
            'telegram_id' => $user->id,
            'avatar_path' => $path
        ]);
    }
}
