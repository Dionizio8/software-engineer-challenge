<?php

namespace App\Console\Commands;

use App\Console\Commands\BaseCommandCsv;
use Illuminate\Support\Facades\DB;
use App\Repositories\UserRepository;
use Exception;

class UploadUsersCsv extends BaseCommandCsv
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upload:users-csv {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upload all users through a csv file';
    
    /**
     * @var UserRepository
     */
    protected $userRepository;

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

            $this->setFile($this->argument('file'));
            $this->header = ['uuid','name','username'];
            $this->limitChunk = 5000;

            $this->info("Starting file import.");

            $this->startInteraction();

            $this->info('Committing transaction...');

            DB::commit();

            $this->info("Import successfully completed.");
        } catch (Exception $e) {
            DB::rollBack();
            $this->error($e->getMessage());
        }
    }

    public function interactionAction($chunk){
        $this->userRepository->bulk($chunk);
        
        $this->info("Number of lines persisted: {$this->lineCount}");
    }
}
