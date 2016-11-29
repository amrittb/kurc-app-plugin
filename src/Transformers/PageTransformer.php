<?php namespace Kurc\Transformers;

class PageTransformer implements TransformerContract {

	use RemovesFields;

	protected $removingFields = [
									"guid",
									"type",
									"parent",
									"menu_order",
									"comment_status",
									"ping_status",
									"template",
									"excerpt",
								];

	/**
	* Returns the transforming entity name.
	*/
	public function getTransformEntityName() {
		return "page";
	}

    /**
     * Transforms a data response.
     *
     * @param $dat 
     * @param $post
     * @param $request
     * @return mixed
     */
	public function transform($data, $post, $request) {
		$_data = $data->data;

		if(isset($_data["title"]["rendered"])) {
			$_data["title"] = $_data["title"]["rendered"];
		}

		if(isset($_data["content"]["rendered"])) {
			$_data["content"] = $_data["content"]["rendered"];
		}

		$this->removeFields($_data);

		$data->data = $_data;

		return $data;
	}

	/**
	 * Returns fields array to be removed from response.
	 * 
	 * @return Array Array of fields to be removed.
	 */
    protected function getRemovingFields() {
    	return $this->removingFields;
    }
}