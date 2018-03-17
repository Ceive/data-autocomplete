<?php
/**
 * @created Alexey Kutuzov <lexus27.khv@gmail.com>
 * @Project: ceive.data-attribute-context
 */

namespace Ceive\Data\Autocomplete;

/**
 * @Author: Alexey Kutuzov <lexus27.khv@gmail.com>
 * Class Autocomplete
 * @package Ceive\Data\Autocomplete\Older
 */
class Autocomplete implements AutocompleteInterface{
	
	/** @var  Manager */
	public $manager;
	
	/** @var AutocompleteInterface|null  */
	public $parent = null;
	
	public $classname;
	
	public $attributes = [];
	
	public $path = [];
	
	public function __construct(array $attributes){
		$this->setAttributes($attributes);
	}
	
	/**
	 * @param AutocompleteInterface|null $parent
	 * @return $this
	 */
	public function setParent(AutocompleteInterface $parent = null){
		$this->parent = $parent;
		return $this;
	}
	
	/**
	 * @param $path
	 * @return $this
	 */
	public function setPathAlias($path){
		$this->path = $this->parent? $this->parent->getPath() + [$path] : [$path];
		return $this;
	}
	
	/**
	 * @param Manager $manager
	 * @return $this
	 */
	public function setManager(Manager $manager){
		$this->manager = $manager;
		return $this;
	}
	
	/**
	 * @param $key
	 * @param $value
	 * @return $this
	 */
	public function set($key, $value){
		$this->attributes[$key] = $value;
		return $this;
	}
	
	public function setAttributes(array $attributes){
		foreach($attributes as $k=>$v){
			$this->set($k,$v);
		}
		return $this;
	}
	
	/**
	 * @param $path
	 * @return AutocompleteInterface|null
	 */
	public function in($path){
		
		$attributes = $this->getAttributes();
		
		if(!is_array($path)){
			$path = explode('.', $path);
		}
		$chunk = array_shift($path);
		$autocomplete = null;
		if(isset($attributes[$chunk])){
			if($attributes[$chunk] instanceof AutocompleteInterface){
				$autocomplete = $attributes[$chunk];
			}elseif(is_string($attributes[$chunk])){
				$reference = Reference::getReference($attributes[$chunk]);
				if( ($classname = $reference->getClass()) ){
					$autocomplete = $this->manager->getByClassname($classname, $this->path + [$chunk]);
					if(!$autocomplete){
						return null;
					}
					$autocomplete = new AutocompleteWrapper(array_merge($this->getPath(),[$chunk]), $autocomplete,$this);
					$autocomplete->setManager($this->manager);
				}
			}
			if($autocomplete && $path){
				return $autocomplete->in($path);
			}
		}
		return $autocomplete;
	}
	
	/**
	 * @return array
	 */
	public function entries(){
		return $this->getAttributes();
	}
	
	/**
	 * @return array
	 */
	public function entriesLocal(){
		$a = [];
		foreach($this->getAttributes() as $key => $attribute){
			if(!Reference::isClassReference($attribute)){
				$a[$key] = $attribute;
			}
		}
		return $a;
	}
	
	/**
	 * @return array
	 */
	public function entriesLink(){
		$a = [];
		foreach($this->getAttributes() as $key => $attribute){
			if(Reference::isClassReference($attribute)){
				$a[$key] = $attribute;
			}
		}
		return $a;
	}
	
	/**
	 * @param $query
	 * @param bool $caseless
	 * @param bool $whole_children
	 * @return array
	 */
	public function search($query, $caseless = false, $whole_children = false){
		$a = [];
		if(!$caseless){
			foreach($this->getAttributes() as $key => $val){
				if(mb_strpos($key,$query)!==false){
					$a[$key] = $val;
				}
			}
		}else{
			
		}
		
		return $a;
	}
	
	
	/**
	 * @return boolean
	 */
	public function isRoot(){
		if(!$this->parent){
			return true;
		}else{
			return $this->parent->isRoot();
		}
	}
	
	/**
	 * @return AutocompleteInterface
	 */
	public function getRoot(){
		if($this->parent){
			return $this->parent->getRoot();
		}
		return $this;
	}
	
	/**
	 * @return array
	 */
	public function getPath(){
		return (array)$this->path;
	}
	
	
	
	
	
	/**
	 * @return string|null
	 */
	public function getClassname(){
		return $this->classname;
	}
	
	/**
	 * recurse detect
	 * @param $classname
	 * @return boolean
	 */
	public function haveRecursionWith($classname){
		if($this->classname && is_a($classname, $this->classname, true)){
			return true;
		}
		if($this->parent){
			return $this->parent->haveRecursionWith($classname);
		}
		return false;
	}
	
	public function getAttributes(){
		return $this->attributes;
	}
}


