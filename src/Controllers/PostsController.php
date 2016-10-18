<?php namespace Kurc\Controllers;

class PostsController extends Controller  {

    /**
     * Shows a list of posts.
     *
     * @param $request
     * @return \WP_REST_Response
     */
    public function index($request) {
        $args = $this->prepareForDbQuery($request->get_params());

        $items = (new \WP_Query())->query($args);

        $data = [];
        foreach($items as $item) {
            $data[] = $this->prepareItemForResponse($item, $request);
        }

        return $this->respond($data);
    }

    /**
     * Prepare Parameters for Database Query.
     *
     * @param $params
     * @return array
     */
    private function prepareForDbQuery($params) {
        $args = [
            'posts_per_page' => $params['per_page'],
            'page' => $params['page'],
            'orderby' => $params['orderby'],
            'order' => strtoupper($params['order']),
        ];

        if(key_exists('after',$params)) {
            $args['date_query'] = [
                [
                    'column' => 'post_date',
                    'after' => $params['after']
                ]
            ];
        }

        if(key_exists('category_slug',$params)) {
            $args['category_name'] = $params['category_slug'];
        }

        return $args;
    }

    /**
     * Prepare an item for database response.
     *
     * @param $item
     * @param $request
     * @return array
     */
    private function prepareItemForResponse($item, $request) {
        return [
            'id' => $item->ID,
            'title' => $item->post_title,
            'date' => $item->post_date
        ];
    }
}