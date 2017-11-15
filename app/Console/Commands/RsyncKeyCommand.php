<?php
namespace App\Console\Commands;

use App\Http\Logic\AlarmLogic;
use Illuminate\Console\Command;

class RsyncKeyCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'key:rsync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '同步售后规则';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        AlarmLogic::getInstance()->rsyncCustomerRule();
    }

}
