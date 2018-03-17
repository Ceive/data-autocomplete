<?php
/**
 * @created Alexey Kutuzov <lexus27.khv@gmail.com>
 * @Project: ceive.data-attribute-context
 */

namespace Ceive\Data\Autocomplete;

/**
 * @Author: Alexey Kutuzov <lexus27.khv@gmail.com>
 * Class AutocompleteClass
 * @package Ceive\Data\Autocomplete\Older
 */
class AutocompleteClass extends Autocomplete{
	
	public $classname;
	
	/**
	 * AutocompleteClass constructor.
	 * @param string $classname
	 * @param array $attributes
	 */
	public function __construct($classname, $attributes = null){
		$this->classname = $classname;
		if(is_array($attributes))$this->setAttributes($attributes);
	}
	
}


