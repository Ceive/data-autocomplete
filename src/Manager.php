<?php
/**
 * @created Alexey Kutuzov <lexus27.khv@gmail.com>
 * @Project: ceive.data-attribute-context
 */

namespace Ceive\Data\Autocomplete;

/**
 * @Author: Alexey Kutuzov <lexus27.khv@gmail.com>
 * Class Manager
 * @package Ceive\Data\Autocomplete
 */
class Manager{
	
	/** @var AutocompleteInterface[]  */
	public $autocompletes = [];
	
	/** @var int[] */
	public $aliases       = [];
	
	/** @var  Analyzer */
	public $analyzer;
	
	/**
	 * @param AutocompleteInterface $autocomplete
	 * @return $this
	 */
	public function register(AutocompleteInterface $autocomplete, $alias = null){
		$i = count($this->autocompletes);
		$this->autocompletes[$i] = $autocomplete;
		if($alias)$this->aliases[$alias] = $i;
		
		$autocomplete->setManager($this);
		return $this;
	}
	
	
	/**
	 * @param $classname
	 * @param null $inPath
	 * @return AutocompleteInterface|null
	 */
	public function getByClassname($classname, $inPath = null){
		foreach($this->autocompletes as $autocomplete){
			if($autocomplete->getClassname() === $classname){
				return $autocomplete;
			}
		}
		return null;
	}
	
	/**
	 * @param $object
	 * @return array
	 */
	public function analyze($object){
		return $this->analyzer->analyze($object);
	}
	
	/**
	 * @param $container
	 * @param null $initiator
	 * @param array $initiator_location
	 * @return array|mixed
	 */
	public function collect($container, $initiator = null,array $initiator_location = null){
		if($initiator === null){
			$initiator = $container;
		}
		
		$initiatorClass = is_object($initiator)?get_class($initiator):null;
		$autocomplete = null;
		if(is_object($container)){
			$autocomplete = $this->getByClassname(get_class($container), $initiatorClass);
		}
		
		if($initiator_location){
			$location = implode('.',$initiator_location);
			if($autocomplete){
				$autocomplete = array_replace(
					(array) $autocomplete,
					(array) $this->getByLocation($location, $initiatorClass)
				);
			}else{
				$autocomplete = $this->getByLocation($location, $initiatorClass);
			}
		}
		
		if($autocomplete){
			return $autocomplete;
		}
		
		$this->collector->setManager($this);
		$autocomplete = $this->collector->collect($container, $initiator, $initiator_location);
		
		return $autocomplete;
	}
	
}


