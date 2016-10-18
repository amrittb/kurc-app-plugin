<?php namespace Kurc\Controllers;

class Controller extends \WP_REST_Controller {

    const HTTP_OK = 200;

    /**
     * Responds OK with data.
     *
     * @param $data
     * @return \WP_REST_Response
     */
    public function respond($data) {
        return new \WP_REST_Response($data, self::HTTP_OK);
    }
}