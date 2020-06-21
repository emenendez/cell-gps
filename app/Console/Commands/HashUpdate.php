<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Hashids;
use Illuminate\Support\Str;

class HashUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hash:update
                                        {connection? : This is the hashid connection to be used}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add hashes to table.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $connection = $this->argument('connection');

        if (!$connection) {
            $connection = $this->choice('Which hash connection?', array_keys(config('hashids.connections')));
        }

        $class = Str::studly(Str::singular($connection));

        $rows = $class::where('token', null)->get();

        if ($rows->count() == 0) {
            $this->info('nothing to hash');
            exit;
        }

        $bar = $this->output->createProgressBar($rows->count());

        foreach ($rows as $row) {
            $row->token      = Hashids::connection($connection)->encode($row->id);
            $row->timestamps = false;
            $row->save();

            $bar->advance();
        }

        $bar->finish();

        $this->info("\ndone");
    }
}
