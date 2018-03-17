<?php
/**
 * @created Alexey Kutuzov <lexus27.khv@gmail.com>
 * @Project: ceive.data-attribute-context
 */

namespace Ceive\Data\Autocomplete;

/**
 * @Author: Alexey Kutuzov <lexus27.khv@gmail.com>
 * Class AutocompleteWrapper
 * @package Ceive\Data\Autocomplete
 */
class AutocompleteWrapper extends Autocomplete{
	
	/** @var AutocompleteInterface  */
	protected $wrapped;
	
	/**
	 * AutocompleteWrapper constructor.
	 * @param $path
	 * @param AutocompleteInterface $autocomplete
	 * @param AutocompleteInterface|null $parent
	 */
	public function __construct($path, AutocompleteInterface $autocomplete, AutocompleteInterface $parent = null){
		if($path)$this->path = !is_array($path)?explode('.',$path):$path;
		$this->wrapped = $autocomplete;
		$this->setParent($parent);
	}
	
	/**
	 * @return mixed
	 */
	public function getAttributes(){
		return $this->wrapped->getAttributes();
	}
	
	
}


