<?php
/**
 * @created Alexey Kutuzov <lexus27.khv@gmail.com>
 * @Project: ceive.data-autocomplete
 */

namespace Ceive\Data\Autocomplete\Tests;


use Ceive\Data\Autocomplete\Older\Manager;

class OlderTestCase extends \PHPUnit_Framework_TestCase{
	
	
	public $data = [];
	
	/**
	 * todo: Recursive protect
	 */
	public function setUp(){
		$this->data = [
			'user' => [
				'username' => 'vasya2090',
				'password' => 'asdasdasdasd',
				'login_counts' => 299,
				'profile' => [
					'first_name'        => 'Alexey',
					'last_name'         => 'Kutuzov',
					'middle_name'       => 'Konstantinovich',
					
					'email' => 'lexus27.khv@gmail.com',
					'phone' => '+79141725729',
					
					'contacts' => [
						[
							'default' => true,
							'address' => 'lexus27.khv@gmail.com',
							'type' => 'email' // allow short in autocomplete (by key[=email])
						], [
							'default' => true,
							'address' => '+79141725729',
							'type' => 'phone'
						],[
							'default' => false,
							'address' => 'lexus.1995@mail.ru',
							'type' => 'email'
						]
					]
				]
			]
		];
	}
	
	public function testEntries(){
		$manager = new Manager();
		//todo context.autocomplete().set('user','<User>');
		// todo class sources
		//todo AutocompleteInterface->in('user')->entries()
		//todo AutocompleteInterface->in('user.profile')->entries()
		//todo AutocompleteInterface->in('user')->in('profile')->entries()
		//todo AutocompleteInterface->in(['user','profile'])->entries()
		//todo AutocompleteInterface->entries()
		$manager->setLocationAutocomplete('user','<User>');
		
		$manager->setClassAutocomplete('Contact',[
			'default' => 'bool',
			'address' => 'string',
			'type'    => 'string'
		]);
		
		
		
		$manager->setClassAutocomplete('User',[
			'username'      => 'string',
			'password'      => 'string',
			'login_counts'  => 'int',
			'profile'       => '<User\Profile>'
		]);
		$manager->setClassAutocomplete('User\Profile',[
			'first_name'        => 'Alexey',
			'last_name'         => 'Kutuzov',
			'middle_name'       => 'Konstantinovich',
			'email'             => 'lexus27.khv@gmail.com',
			'phone'             => '+79141725729',
			'contacts'          => '<Contact[]>'
		]);
		$autocomplete = $manager->collect($this->data);
		
		$this->assertNotEmpty($autocomplete);
		
	}
	
	
}


