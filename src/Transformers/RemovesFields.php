<?php namespace Kurc\Transformers;

trait RemovesFields {

	/**
	* Removes fields from the response data.
	* 
	* @param $_data
	*/
	protected function removeFields(array& $_data) {
        foreach($this->getRemovingFields() as $field) {
            unset($_data[$field]);
        }
    }

    protected abstract function getRemovingFields();
}