<?php

namespace App\Console\Commands;

use App\Console\Commands\BaseCommandCsv;
use Illuminate\Support\Facades\DB;
use App\Repositories\UserRepository;
use Exception;

class UploadUsersRelevanceCsv extends BaseCommandCsv
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upload:users-relevance-csv {file} {relevance}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the relevance of each user of the file';

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * Relevance
     * 
     * @var int
     */
    protected $relevance;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository)
    {
        parent::__construct();

        $this->userRepository = $userRepository;
    }

    /**
     * Execute the console command.
     *
     * @param  
     * @return mixed
     */
    public function handle()
    {
        try {
            DB::disableQueryLog();
            DB::beginTransaction();

            $this->relevance = $this->isRelevance();

            $this->setFile($this->argument('file'));
            $this->header = ['uuid'];
            $this->limitChunk = 1;

            $this->info("Starting relevance update.");

            $this->startInteraction();

            $this->info('Committing transaction...');

            DB::commit();

            $this->info("Relevances updated successfully.");
        } catch (Exception $e) {
            DB::rollBack();
            $this->error($e->getMessage());
        }
    }

    public function interactionAction($chunk)
    {
        $uuid = $chunk[0]['uuid'];

        $this->userRepository->updateRelevanceByUuid($uuid, $this->relevance);

        $this->info("Number of lines persisted: {$this->lineCount}");
    }

    public function isRelevance()
    {
        $relevance = $this->argument('relevance');

        if (!is_numeric($relevance)) {
            throw new Exception("The relevance value is not valid.");
        }

        return (int) $relevance;
    }
}
