<?php namespace Kurc\Transformers;

class Registrar {

    /**
     * Invoker method prefix.
     */
    const INVOKER_METHOD_PREFIX = 'invoke';

    /**
     * Invoker method suffix.
     */
    const INVOKER_METHOD_SUFFIX = 'Transformers';

    /**
     * List of transformers.
     *
     * @var array
     */
	protected $transformers = [];

    /**
     * Registers transformers.
     *
     * @param $transformers
     */
    public function registerTransformers($transformers) {
		foreach($transformers as $transformerClass) {
			$transformer = new $transformerClass();

            if( ! ($transformer instanceof TransformerContract)) {
            	continue;
            }

            $entityName = $transformer->getTransformEntityName();

            if($this->transformers[$entityName]) {
                array_push($this->transformers[],$transformer);
            } else {
                $this->transformers[$entityName] = [$transformer];
            }
        }
	}

    /**
     * Registers transformers to WordPress.
     */
	public function registerTransformersToWP() {
		foreach(array_keys($this->transformers) as $entity) {
            $method = $this->getTransformInvokerMethodName($entity);
			add_filter($this->getTransformFilterName($entity),array($this, $method),10,3);
		}
	}

    /**
     * Returns transform invoker method name.
     *
     * @param $entity
     * @return string
     */
    private function getTransformInvokerMethodName($entity) {
		return self::INVOKER_METHOD_PREFIX .ucfirst($entity). self::INVOKER_METHOD_SUFFIX;
	}

    /**
     * Returns transform filter name.
     *
     * @param $entity
     * @return string
     */
    private function getTransformFilterName($entity) {
        return 'rest_prepare_'.$entity;
    }

    /**
     * Returns transform entity name from invoker method name.
     *
     * @param $method
     * @return string
     */
    private function getTransformEntityName($method) {
        $prefixLen = strlen(self::INVOKER_METHOD_PREFIX);
        $len = strpos($method,self::INVOKER_METHOD_SUFFIX) - $prefixLen;
        return strtolower(substr($method,$prefixLen, $len));
    }

    /**
     * Invokes transformers.
     *
     * @param $transformers
     * @param $data
     * @param $post
     * @param $request
     * @return mixed
     */
    private function invokeTransformer($transformers, $data, $post, $request) {
        foreach($transformers as $transformer) {
            $data = $transformer->transform($data, $post, $request);
        }

        return $data;
    }

    /**
     * Magic call method.
     *
     * @param $method
     * @param $args
     * @return mixed
     * @throws \Exception
     */
    public function __call($method, $args) {
        if(method_exists($this,$method)) {
            // Checks if method exists in this object.
            return call_user_func_array(array($this,$method),$args);
        } else {
            $entity = $this->getTransformEntityName($method);

            if(in_array($entity,array_keys($this->transformers))) {
                array_unshift($args, $this->transformers[$entity]);
                return call_user_func_array(array($this,"invokeTransformer"),$args);
            } else {
                throw new \Exception("Method {$method} not found in Registrar.php");

            }
        }
    }
}