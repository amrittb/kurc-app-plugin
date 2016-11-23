<?php namespace Kurc\Transformers;

class AttachmentTransformer implements TransformerContract {

	use RemovesFields;

    protected $removingFields = [
    	'guid',
        'type',
        'slug',
        'author',
        'alt_text',
        'mime_type',
        'source_url',
    	'media_details',
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

    	if(is_object($_data["sizes"]) && count(get_object_vars($_data["sizes"])) == 0) {
			$_data["sizes"]->full["file"] = $_data["media_details"]["file"];
			$_data["sizes"]->full["width"] = $_data["media_details"]["width"];
			$_data["sizes"]->full["height"] = $_data["media_details"]["height"];
			$_data["sizes"]->full["mime_type"] = $_data["mime_type"];
			$_data["sizes"]->full["source_url"] = $_data["source_url"];
    	}

        $this->removeFields($_data);

		$data->data = $_data;

		return $data;
	}

    protected function getRemovingFields() {
        return $this->removingFields;
    }
}