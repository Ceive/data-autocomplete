<?php
/**
 * @created Alexey Kutuzov <lexus27.khv@gmail.com>
 * @Project: ceive.data-attribute-context
 */

namespace Ceive\Data\Autocomplete\Older;

/**
 * @Author: Alexey Kutuzov <lexus27.khv@gmail.com>
 * Class Manager
 * @package Ceive\Data\AttributeContext\AutocompleteInterface
 */
class Manager{
	
	const INITIATOR_EXTERNAL = '{external}';
	
	protected $collector;
	
	protected $class_rules = [];
	
	protected $location_rules = [];
	
	public function __construct(){
		$this->collector = new Collector();
	}
	
	/**
	 * @param $classname
	 * @param array $autocomplete
	 * @param null $initiatorClass
	 * @return $this
	 */
	public function setClassAutocomplete($classname,array $autocomplete, $initiatorClass = null){
		if(!$initiatorClass)$initiatorClass = self::INITIATOR_EXTERNAL;
		$this->class_rules[$initiatorClass][] = [ is_array($classname)?$classname: [$classname], $autocomplete ];
		return $this;
	}
	
	/**
	 * @param $location
	 * @param $autocomplete
	 * @param null $initiatorClass
	 * @return $this
	 */
	public function setLocationAutocomplete($location, $autocomplete, $initiatorClass = null){
		if(!$initiatorClass)$initiatorClass = self::INITIATOR_EXTERNAL;
		$this->location_rules[$initiatorClass][] = [ is_array($location)?$location: [$location] , $autocomplete ];
		return $this;
	}
	
	/**
	 * @param $classname
	 * @param null $initiatorClass
	 * @return null|array
	 */
	public function getByClassname($classname, $initiatorClass = null){
		if(!$initiatorClass)$initiatorClass = self::INITIATOR_EXTERNAL;
		if(isset($this->class_rules[$initiatorClass])){
			foreach($this->class_rules[$initiatorClass] as list($classes, $autocomplete)){
				if(in_array($classname, $classes, true)){
					return $initiatorClass!==self::INITIATOR_EXTERNAL && $initiatorClass !== $classname
						? array_replace( (array)$this->getByClassname($classname, self::INITIATOR_EXTERNAL), $autocomplete)
						: $autocomplete;
				}
			}
		}
		return null;
	}
	
	/**
	 * @param $location
	 * @param null $initiatorClass
	 * @return null|array|mixed
	 */
	public function getByLocation($location, $initiatorClass = null){
		if(!$initiatorClass)$initiatorClass = self::INITIATOR_EXTERNAL;
		if(isset($this->location_rules[$initiatorClass])){
			foreach($this->location_rules[$initiatorClass] as list($locations, $autocomplete)){
				if(in_array($location, $locations, true)){
					return $initiatorClass===self::INITIATOR_EXTERNAL
						? $autocomplete
						: array_replace(
							(array)$this->getByLocation($location, self::INITIATOR_EXTERNAL),
							$autocomplete
						);
				}
			}
		}
		return null;
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


