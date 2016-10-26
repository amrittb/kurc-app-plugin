<?php namespace Kurc\Transformers;

interface TransformerContract {

	/**
	* Returns the transforming entity name.
	*/
	public function getTransformEntityName();

    /**
     * Transforms a data response.
     *
     * @param $data
     * @param $post
     * @param $request
     * @return mixed
     */
	public function transform($data, $post, $request);
}