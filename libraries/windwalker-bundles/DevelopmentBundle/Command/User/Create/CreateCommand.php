<?php
/**
 * Part of joomlarad project.
 *
 * @copyright  Copyright (C) 2017 ${ORGANIZATION}.
 * @license    __LICENSE__
 */

namespace DevelopmentBundle\Command\User\Create;

use Windwalker\Console\Command\Command;
use Windwalker\Console\Prompter\NotNullPrompter;
use Windwalker\Console\Prompter\PasswordPrompter;

/**
 * The CreateCommand class.
 *
 * @since  __DEPLOY_VERSION__
 */
class CreateCommand extends Command
{
	/**
	 * Superuser group id.
	 *
	 * @var  int
	 */
	const SUPER_USER_GROUP_ID = 8;

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
	protected $name = 'create';

	/**
	 * The command description.
	 *
	 * @var  string
	 */
	protected $description = 'Create User profile.';

	/**
	 * The usage to tell user how to use this command.
	 *
	 * @var string
	 */
	protected $usage = 'create <option>[option]</option>';

	/**
	 * Initialise command information.
	 *
	 * @return void
	 */
	public function initialise()
	{
		parent::initialise();

		$this->addOption('gid')
			->description('Group ID of super user.');
	}

	/**
	 * Execute this command.
	 *
	 * @return int|void
	 * @throws \RuntimeException
	 * @throws \InvalidArgumentException
	 */
	protected function doExecute()
	{
		\JFactory::getLanguage()->load('lib_joomla');

		// Install User
		$userdata = array();

		$userdata['username']  = with(new NotNullPrompter)->ask('Please enter account: ');
		$userdata['name']      = with(new NotNullPrompter)->ask('Please enter user name: ');
		$userdata['email']     = with(new NotNullPrompter)->ask('Please enter your email: ');
		$userdata['password']  = with(new PasswordPrompter)->ask('Please enter password: ');
		$userdata['password2'] = with(new PasswordPrompter)->ask('Please valid password: ');

		if ($userdata['password'] !== $userdata['password2'])
		{
			throw new \InvalidArgumentException('ERROR: Password not matched.');
		}

		$userdata['groups'] = array(1);
		$userdata['block'] = 0;
		$userdata['sendEmail'] = 1;

		$user = new \JUser;

		if (!$user->bind($userdata))
		{
			throw new \RuntimeException('[Error] ' . $user->getError());
		}

		if (!$user->save())
		{
			throw new \RuntimeException('[Error] ' . $user->getError());
		}

		$userId = $user->id;

		// Save Super admin
		$db = \JFactory::getDbo();

		$group = $this->getOption('gid', self::SUPER_USER_GROUP_ID);

		$query = $db->getQuery(true)
			->update('#__user_usergroup_map')
			->set('group_id = ' . $group)
			->where('user_id = ' . $userId);

		$db->setQuery($query)->execute();

		$this->out()->out('Create user success.');

		return true;
	}
}
