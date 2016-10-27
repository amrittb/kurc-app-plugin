<?php namespace Kurc\Transformers;

abstract class BaseTransformer implements TransformerContract {

	/**
	* Removes fields from the response data.
	* 
	* @param $_data
	*/
	protected function removeFields($_data) {
		if(isset($this->removingFields)) {
	        foreach($this->removingFields as $field) {
	            unset($_data[$field]);
	        }
		}
    }

}