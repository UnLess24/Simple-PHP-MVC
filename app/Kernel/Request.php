<?php

namespace App\Kernel;


class Request
{

    private $request = [];

    /**
     * Request constructor.
     * @param array $request
     */
    public function __construct($request = null)
    {
        if (is_array($request)) {
            foreach ($request as $key => $param)
                $this->setParam($key, $param);
        } else {
            if ($request && $request !== '') {
                $reqData = explode('&', $request);

                foreach ($reqData as $data) {
                    $data = explode('=', $data);
                    if (count($data) > 1)
                        $this->setParam($data[0], $data[1]);
                }
            }
        }
    }

    private function setParam($key, $param)
    {
        $this->request[$key] = $param;
        $this->$key = $param;
    }

    public function getParams()
    {
        return $this->request;
    }

    public function getParamsToString()
    {
        $array = [];

        foreach ($this->getParams() as $key => $value) {
            $array[] = '"' . $key . '":"' . $value . '"';
        }
        return '{' . implode(',', $array) . '}';
    }

    public function getParam(string $param)
    {
        if (isset($this->request[$param])) {
            return $this->request[$param];
        }
        return null;
    }
}
