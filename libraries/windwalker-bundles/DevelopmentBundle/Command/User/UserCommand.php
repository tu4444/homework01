<?php
/**
 * Part of joomlarad project.
 *
 * @copyright  Copyright (C) 2017 ${ORGANIZATION}.
 * @license    __LICENSE__
 */

namespace DevelopmentBundle\Command\User;

use DevelopmentBundle\Command\User\Create\CreateCommand;
use Windwalker\Console\Command\Command;

/**
 * The UserCommand class.
 *
 * @since  __DEPLOY_VERSION__
 */
class UserCommand extends Command
{
	/**
	 * An enabled flag.
	 *
	 * @var bool
	 */
	public static $isEnabled = true;

	/**
	 * Console(Argument) name.
	 *
	 * @var  string
	 */
	protected $name = 'user';

	/**
	 * The command description.
	 *
	 * @var  string
	 */
	protected $description = 'User operation.';

	/**
	 * The usage to tell user how to use this command.
	 *
	 * @var string
	 */
	protected $usage = 'user <cmd><command></cmd> <option>[option]</option>';

	/**
	 * Initialise command information.
	 *
	 * @return void
	 * @throws \LogicException
	 */
	public function initialise()
	{
		$this->addCommand(new CreateCommand);
	}

	/**
	 * Execute this command.
	 *
	 * @return int|void
	 */
	protected function doExecute()
	{
		return parent::doExecute();
	}
}
