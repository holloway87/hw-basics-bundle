<?php

namespace Hw\BasicsBundle\Controller;

use Hw\BasicsBundle\Menu\Menu;
use Hw\BasicsBundle\Menu\MenuInterface;
use Hw\BasicsBundle\Menu\MenuTypeInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * Base controller which provides useful methods.
 *
 * @author Thomas Rudolph <me@holloway-web.de>
 * @since 2014.07.27
 */
class BaseController extends Controller
{

	/**
	 * Returns the encoded password which can be set in an entity.
	 *
	 * To encode the password the SecurityBundle has to be activated.
	 * The given entity must at least implement the UserInterface.
	 *
	 * @see Symfony\Bundle\SecurityBundle\SecurityBundle
	 * @param UserInterface $entity
	 * @return string
	 */
	protected function _encodePassword(UserInterface $entity)
	{
		$factory = $this->get('security.encoder_factory');
		/** @var \Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface $encoder */
		$encoder = $factory->getEncoder($entity);
		return $encoder->encodePassword($entity->getPassword(), $entity->getSalt());
	}

	/**
	 * Creates a new menu with the given type.
	 *
	 * Per default it uses the Menu class from the HwBasicsBundle.
	 *
	 * @param MenuTypeInterface $type
	 * @param MenuInterface|null $menu
	 * @return MenuInterface
	 */
	public function createMenu(MenuTypeInterface $type, $menu = null)
	{
		if (is_null($menu))
		{
			$menu = new Menu();
		}
		return $this->get('hw_basics.menufactory')->create($type, $menu);
	}

	/**
	 * Creates a random password from a set of characters.
	 *
	 * With the optional $chars parameter you can specify the characters to choose from.
	 *
	 * @param int $length
	 * @param string|null $chars
	 * @return string
	 */
	public static function generatePassword($length = 8, $chars = null)
	{
		if (!$chars)
		{
			$chars = 'abcdefghijklmnoqrstuvwxyz-_ABCDEFGHIJKLMNOQRSTUVWXYZ0123456789';
		}
		$charsCnt = strlen($chars);
		$password = '';
		for($i = 0; $i < $length; $i++)
		{
			$char = $chars[rand(0, $charsCnt - 1)];
			$password .= $char;
		}
		return $password;
	}

}
