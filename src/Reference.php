<?php
/**
 * @created Alexey Kutuzov <lexus27.khv@gmail.com>
 * @Project: ceive.data-attribute-context
 */

namespace Ceive\Data\Autocomplete;

/**
 * @Author: Alexey Kutuzov <lexus27.khv@gmail.com>
 * Class Reference
 * @package Ceive\Data\Autocomplete
 *
 * <Class\Name\InNamespace\Classname>
 *
 */
class Reference{
	
	protected static $references = [];
	
	
	static $classnameOpen       = '<';
	
	static $classnameClose      = '>';
	
	static $multipleIdentifier  = '[]';
	
	
	static $types = [
		['string','str','text'],
		['integer','int','digit','digits'],
		['float','double'],
		['object', 'obj', 'stdClass'],
		['array','arr','list'],
		['any','null','mixed']
	];
	
	/**
	 * @param $reference
	 * @return bool
	 */
	public static function isClassReference($reference){
		if(substr($reference,0,1) === self::$classnameOpen && substr($reference,-1) === self::$classnameClose){
			return true;
		}else{
			$miLen = strlen(self::$multipleIdentifier);
			if(substr($reference,-$miLen) === self::$multipleIdentifier){
				$reference = substr($reference,0,-$miLen);
			}
			foreach(static::mergeRecursive(self::$types) as $type){
				if(strnatcasecmp($type,$reference) === 0){
					return false;
				}
			}
			return true;
		}
	}
	
	/**
	 * @param array $arrays
	 * @return array
	 */
	public static function mergeRecursive(array $arrays){
		$a = [];
		foreach($arrays as $item){
			if(is_array($item)){
				$a = array_merge($a, static::mergeRecursive($item) );
			}else{
				$a[] = $item;
			}
		}
		return $a;
	}
	/**
	 * @param $reference
	 * @return Reference
	 */
	public static function getReference($reference){
		if(!isset(self::$references[$reference])){
			self::$references[$reference] = new Reference($reference);
		}
		return self::$references[$reference];
	}
	
	
	protected $processed = false;
	
	protected $reference;
	
	protected $multiple = false;
	
	protected $classname;
	
	protected $vartype;
	
	/**
	 * Reference constructor.
	 * @param $reference
	 */
	public function __construct($reference){
		$this->reference = $reference;
	}
	
	/**
	 * @param $reference
	 * @return $this
	 */
	public function setReferenceString($reference){
		$this->processed = false;
		$this->reference = $reference;
		return $this;
	}
	
	/**
	 * @return bool
	 */
	public function isMultiple(){
		$this->process();
		return $this->multiple;
	}
	
	/**
	 * @return mixed
	 */
	public function getClass(){
		$this->process();
		return $this->classname;
	}
	
	public function getVartype(){
		$this->process();
		return $this->vartype;
	}
	
	/**
	 *
	 */
	protected function process(){
		if(!$this->processed){
			$this->processed = true;
			
			$this->classname = null;
			$this->multiple = false;
			
			
			
			$reference = $this->reference;
			
			$miLen = strlen(self::$multipleIdentifier);
			if(substr($reference,0,1) === self::$classnameOpen && substr($reference,-1) === self::$classnameClose){
				$reference = substr($reference,1,-1);
				if(substr($reference,-$miLen) === self::$multipleIdentifier){
					$reference = substr($reference,0,-$miLen);
					$this->multiple = true;
				}
				
				$this->vartype      = 'object';
				$this->classname    = $reference;
			}else{
				
				if(substr($reference,-$miLen) === self::$multipleIdentifier){
					$reference = substr($reference,0,-$miLen);
					$this->multiple = true;
				}
				
				$types = $this->mergeRecursive(self::$types);
				foreach($types as $type){
					if(strnatcasecmp($type,$reference) === 0){
						$this->vartype = $type;
						return;
					}
				}
				
				$this->vartype      = 'object';
				$this->classname    = $reference;
				
			}
			
		}
	}
	
	
	/**
	 * @return string
	 */
	public function __toString(){
		return $this->reference;
	}
	
}


