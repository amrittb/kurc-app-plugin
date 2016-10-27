<?php namespace Kurc\Transformers;

class UserTransformer extends BaseTransformer {

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

        $_data["avatar"] = $_data["avatar_urls"]["96"];

        unset($_data["avatar_urls"]);

        $this->removeFields($_data);

        $data->data = $_data;

        return $data;
    }
}