<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Admin;

class GenerateMenu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate-menu';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command For Generate Menu Admin Panel';

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
     *
     * @return mixed
     */
    public function handle()
    {
        if(Admin::generateMenu() == true)
        {
            $this->line('Menu berhasil di generate');
            \Artisan::call('cache:clear');
        }else{
            $this->line('Menu Gagal di generate');
        }
    }
}
