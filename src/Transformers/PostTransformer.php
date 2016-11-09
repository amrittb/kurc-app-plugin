<?php namespace Kurc\Transformers;

class PostTransformer implements TransformerContract {

    use RemovesFields;

    /**
     * Fields to be removed from original response.
     *
     * @var array
     */
    protected $removingFields = [
                                    'type',
                                    'guid',
                                    'comment_status',
                                    'ping_status',
                                    'format',
                                ];

    /**
     * Returns the transforming entity name.
     */
    public function getTransformEntityName() {
        return "post";
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

        $params = $request->get_params();

        $_data['title'] = $_data['title']['rendered'];
        $_data['excerpt'] = $_data['excerpt']['rendered'];
        $_data['content'] = $_data['content']['rendered'];

        if( ! isset($params['id'])) {
            if(!in_array('include_content',array_keys($params))) {
                unset($_data['content']);
            }
        }

        $this->removeFields($_data);

        $data->data = $_data;

        return $data;
    }

    protected function getRemovingFields() {
        return $this->removingFields;
    }
}