<?php
/**
 * @created Alexey Kutuzov <lexus27.khv@gmail.com>
 * @Project: ceive.data-autocomplete
 */

namespace Ceive\Data\Autocomplete\Tests;

use Ceive\Data\Autocomplete\Autocomplete;
use Ceive\Data\Autocomplete\AutocompleteClass;
use Ceive\Data\Autocomplete\Manager;

/**
 * @Author: Alexey Kutuzov <lexus27.khv@gmail.com>
 * Class AutocompleteTestCase
 * @package Ceive\Data\AttributeContext\Tests
 */
class AutocompleteTestCase extends \PHPUnit_Framework_TestCase{
	
	
	public function testAutocomplete(){
		$manager = new Manager();
		
		
		$manager->register(new AutocompleteClass('User',[
			'username'      => 'string',
			'password'      => 'string',
			'login_counts'  => 'int',
			'profile'       => '<User\Profile>'
		]));
		
		$manager->register(new AutocompleteClass('User\Profile',[
			'first_name'        => 'string',
			'last_name'         => 'string',
			'second_name'       => 'string',
			'user'              => '<User>'
		]));
		
		$manager->register($autocomplete = new Autocomplete([
			'user' => '<User>',
			'value' => 'mixed',
		]));
		
		
		$user = $manager->getByClassname('User');
		
		$entries = $autocomplete->entries();
		
		$this->assertEquals([
			'user' => '<User>',
			'value' => 'mixed',
		],$autocomplete->entries());
		
		
		$this->assertEquals([
			'user' => '<User>',
		],$autocomplete->entriesLink());
		
		// Language Labeled
		//$autocomplete->getTitle($entry);
		//$autocomplete->getDescription($entry);
		//$autocomplete->getType($entry);
		
		// AbsolutePath
		//$autocomplete->getAbsolutePath($entry_key);
		
		
		$label = [
			'lang'          => null,
			'key'           => 'user',
			'description'   => null,
			
			'cases' => [[
				'lang'          => 'ru_RU',
				'title'         => 'пользователь',
				'description'   => 'описание'
			]]
		];
		
		$label = [
			'lang'          => null,
			'key'           => 'current_user',
			'description'   => null,
			
			'cases' => [[
				'lang'          => 'ru_RU',
				'title'         => 'текущий пользователь',
				'description'   => 'пользователь, который в момент выполнения проводит авторизованное действие'
			]]
		];
		
	}
}
