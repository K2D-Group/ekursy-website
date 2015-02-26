<?php namespace App\Console\Commands;

use App\Repositories\SourceRepository;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class BitBucketSync extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'bitbucket:sync';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Sync courses with BitBucket.';

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
	public function fire()
	{
        $r = new SourceRepository();
        $r->get();
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
//			['example', InputArgument::REQUIRED, 'An example argument.'],
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
//			['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
		];
	}

}
