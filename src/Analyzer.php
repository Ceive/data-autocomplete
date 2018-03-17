<?php
/**
 * @created Alexey Kutuzov <lexus27.khv@gmail.com>
 * @Project: ceive.data-attribute-context
 */

namespace Ceive\Data\Autocomplete;

/**
 * @Author: Alexey Kutuzov <lexus27.khv@gmail.com>
 * Class Analyzer
 * @package Ceive\Data\Autocomplete
 */
class Analyzer{
	
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
	
	/**
	 * @param $container
	 * @param null $initiator
	 * @param array|null $initiator_location
	 * @return array
	 */
	public function analyze($container, $initiator = null,array $initiator_location = null){
		if($initiator===null){
			$initiator = $container;
		}
		
		$autocomplete = [];
		if(is_array($container) || $container instanceof \Traversable){
			$autocomplete = $this->traverse($container,$initiator,$initiator_location);
		}else{
			if(is_object($container)){
				foreach(get_class_vars($container) as $property =>$value){
					if(property_exists($container,$property)){
						$autocomplete[$property] = $value;
					}
				}
				$autocomplete = $this->traverse($autocomplete,$initiator,$initiator_location);
			}
		}
		return $autocomplete;
	}
	
}


