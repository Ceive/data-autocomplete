<?php
/**
 * @created Alexey Kutuzov <lexus27.khv@gmail.com>
 * @Project: ceive.data-attribute-context
 */

namespace Ceive\Data\Autocomplete\Older;

/**
 * @Author: Alexey Kutuzov <lexus27.khv@gmail.com>
 * Class Collector
 * @package Ceive\Data\AttributeContext\AutocompleteInterface
 */
class Collector{
	
	/** @var  Manager */
	public $manager;
	
	/**
	 * @param Manager $manager
	 * @return $this
	 */
	public function setManager(Manager $manager){
		$this->manager = $manager;
		return $this;
	}
	
	/**
	 * @return Manager
	 */
	public function getManager(){
		return $this->manager;
	}
	
	/**
	 * @param $container
	 * @param null $initiator
	 * @param array $initiator_location
	 * @return array
	 */
	public function collect($container, $initiator = null,array $initiator_location = null){
		if($initiator===null){
			$initiator = $container;
		}
		$autocomplete = [];
		if(is_array($container) || $container instanceof \Traversable){
			$autocomplete = $this->traverse($container,$initiator,$initiator_location);
		}else{
			if(is_object($container)){
				foreach(get_class_vars($container) as $property){
					if(property_exists($container,$property)){
						$autocomplete[$property] = $container->{$property};
					}
				}
				$autocomplete = $this->traverse($autocomplete,$initiator,$initiator_location);
			}
		}
		return $autocomplete;
	}
	
	
	/**
	 * @param \Traversable|array $traversable
	 * @param null $initiator
	 * @param array $initiator_location
	 * @return array
	 * @internal param null $as
	 */
	public function traverse($traversable, $initiator=null,array $initiator_location = null){
		$autocomplete = [];
		foreach($traversable as $key => $value){
			if(is_scalar($value)){
				$autocomplete[$key] = gettype($value);
			}else{
				$autocomplete[$key] = $this
					->getManager()
					->collect(
						$value,
						$initiator,
						array_merge((array)$initiator_location,[$key])
					);
			}
		}
		return $autocomplete;
	}
	
}


