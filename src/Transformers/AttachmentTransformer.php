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

    	if(isset($_data['sizes']['full'])) {
        	$_data["full_image"] = $_data['sizes']['full'];
        	unset($_data['sizes']['full']);
    	} else {
			$_data["full_image"]["file"] = $_data["media_details"]["file"];
			$_data["full_image"]["width"] = $_data["media_details"]["width"];
			$_data["full_image"]["height"] = $_data["media_details"]["height"];
			$_data["full_image"]["mime_type"] = $_data["mime_type"];
			$_data["full_image"]["source_url"] = $_data["source_url"];
    	}

        $this->removeFields($_data);

		$data->data = $_data;

		return $data;
	}

    protected function getRemovingFields() {
        return $this->removingFields;
    }
}