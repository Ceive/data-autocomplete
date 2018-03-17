<?php
/**
 * @created Alexey Kutuzov <lexus27.khv@gmail.com>
 * @Project: ceive.data-attribute-context
 */

namespace Ceive\Data\Autocomplete;

/**
 * @Author: Alexey Kutuzov <lexus.1995@mail.ru>
 * Interface AutocompleteInterface
 * @package Ceive\Data\Autocomplete\Older
 */
interface AutocompleteInterface{
	
	/**
	 * @param AutocompleteInterface $parent
	 * @return $this
	 */
	public function setParent(AutocompleteInterface $parent);
	
	/**
	 * @return boolean
	 */
	public function isRoot();
	
	/**
	 * @return AutocompleteInterface
	 */
	public function getRoot();
	
	/**
	 * @param $alias
	 * @return $this
	 */
	public function setPathAlias($alias);
	
	/**
	 * @return array
	 */
	public function getPath();
	
	/**
	 * @param $path
	 * @return AutocompleteInterface|null
	 */
	public function in($path);
	
	/**
	 * @return array
	 */
	public function entries();
	
	
	
	
	
	/**
	 * @return string|null
	 */
	public function getClassname();
	
	/**
	 * recurse detect
	 * @param $classname
	 * @return boolean
	 */
	public function haveRecursionWith($classname);
	
	/**
	 * @param Manager $manager
	 * @return $this
	 */
	public function setManager(Manager $manager);
	
	/**
	 * @param $key
	 * @param $value
	 */
	public function set($key, $value);
	
	public function setAttributes(array $attributes);
	public function getAttributes();
	
}


