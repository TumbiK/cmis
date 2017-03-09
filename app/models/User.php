<?php
use Zizaco\Confide\ConfideUser;
use Zizaco\Confide\ConfideUserInterface;


class User extends Eloquent implements ConfideUserInterface {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
		use ConfideUser;

}
