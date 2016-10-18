<?php namespace Kurc\Controllers;

class CategoriesController extends Controller {

    /**
     * Lists all the categories.
     * 
     * @return \WP_REST_Response
     */
    public function index() {
        $items = $this->getCategories();

        $data = [];
        foreach($items as $item) {
            $data[] = $this->prepareItemForResponse($item);
        }

        return $this->respond($data);
    }

    /**
     * Returns list of categories.
     *
     * @return mixed
     */
    private function getCategories() {
        return get_categories([
            'hide_empty' => false,
            'parent' => 0,
            'exclude' => array(1),
        ]);
    }

    /**
     * Prepares item for response.
     *
     * @param $item
     * @return array
     */
    private function prepareItemForResponse($item) {
        return [
            'id' => $item->cat_ID,
            'name' => $item->name,
            'slug' => $item->slug
        ];
    }


}