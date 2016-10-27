<?php namespace Kurc\Transformers;

class UserTransformer implements TransformerContract {

    /**
     * Fields to remove from response.
     *
     * @var array
     */
    protected $removingFields = ['url', 'description'];

    /**
     * Returns the transforming entity name.
     */
    public function getTransformEntityName() {
        return "user";
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

        foreach($this->removingFields as $field) {
            unset($_data[$field]);
        }

        $_data["avatar"] = $_data["avatar_urls"]["96"];

        unset($_data["avatar_urls"]);

        $data->data = $_data;

        return $data;
    }
}