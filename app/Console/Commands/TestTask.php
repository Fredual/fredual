<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class TestTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hola mundo';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $texto = "[".date("Y-m-d H:i:s")."]: Hola mi nombfre es Fredual";

        Storage::append("archivo.txt", $texto);
    }
}
