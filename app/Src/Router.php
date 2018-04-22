<?php

namespace App\Src;

class Router implements \App\Api\Contracts\RouterInterface
{
    /**
     * @var raw request
     */
    protected $request = [];

    /**
     * @var parsed request parameters
     */
    protected $requestParameters;

    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * @return void
     */
    public function execute()
    {
        $this->parseRequest();
        $this->run();
    }

    /**
     * @return void
     */
    protected function parseRequest()
    {
        if (!array_key_exists(1, $this->request)) {
            $this->stopProcessing();
        }

        if (array_key_exists(1, $this->request)) {

            $args = explode(":", $this->request[1]);

            if (!array_key_exists(0, $args) || !array_key_exists(1, $args)) {
                $this->stopProcessing();
            }

            $this->requestParameters['class'] = $args[0];
            $this->requestParameters['method'] = $args[1];
            $this->requestParameters['param'] = null;

            if (array_key_exists(2, $this->request)) {
                $this->requestParameters['param'] = array_slice($this->request, 2)[0];
            }
        }
    }

    /**
     * TODO: Take out display error logic into a specific class.
     * Stops query processing
     * @return void
     */
    protected function stopProcessing()
    {
        echo "Query is invalid. Use query structure like: <class>:<method> [arg1]" . PHP_EOL;
        exit;
    }

    /**
     * TODO: implement more wise way to pass parameters
     * TODO: implement more wise error handling
     */
    protected function run()
    {
        try {
            $className = '\App\Src\\' . ucfirst($this->requestParameters['class']);
            $methodName = $this->requestParameters['method'];
            $argument = $this->requestParameters['param'];

            $object = new $className();
            $object->$methodName($argument);
        } catch (\ErrorException $e) {
            echo $e->getMessage();
        }
    }
}