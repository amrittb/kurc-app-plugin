<?php namespace Kurc\Transformers;

class AttachmentTransformer extends BaseTransformer {

    protected $removingFields = [
        'type',
        'slug',
        'author',
        'alt_text',
    ];
	
	/**
	* Returns the transforming entity name.
	*/
	public function getTransformEntityName() {
		return "attachment";
	}

    /**
     * Transforms a data response.
     *
     * @param $data
     * @param $post
     * @param $request
     * @return mixed
     */
	public function transform($data, $post, $request) {
		$_data = $data->data;

		if(isset($_data['title']['rendered'])) {
	        $_data['title'] = $_data['title']['rendered'];
		}

        $_data["sizes"] = $_data["media_details"]["sizes"];

        unset($_data["media_details"]);

        $this->removeFields($_data);

		$data->data = $_data;

		return $data;
	}
}