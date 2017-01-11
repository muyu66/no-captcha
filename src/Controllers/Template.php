<?php

namespace Muyu\Controllers;

use Exception;

class Template
{
    public function view($name, $params = null)
    {
        $paths = $this->getViewPath($name);
        $path = $this->checkViewExist($paths);
        $context = file_get_contents($path);
        return $this->dataBind($context, $params);
    }

    public function checkViewExist($paths)
    {
        foreach ($paths as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }
        throw new Exception('This view is not found');
    }

    public function getViewPath($name)
    {
        /**
         * 获取根目录
         */
        $tmp = explode('/', dirname(__FILE__));
        array_pop($tmp);
        $tmp = implode('/', $tmp);

        return [
            'src/Views/' . $name . '.template.php',
            $tmp . '/Views/' . $name . '.template.php',
        ];
    }

    /**
     * @description 数据绑定，<-- o(*≧▽≦)ツ┏━┓ 拍桌狂笑 -->
     * @param $context
     * @param $params
     * @return mixed
     * @author Zhou Yu
     */
    public function dataBind($context, $params)
    {
        if (! $params) {
            return $context;
        }
        $context = str_replace('v-url:generate', $params['generate'], $context);
        $context = str_replace('v-url:valid', $params['valid'], $context);
        $context = str_replace('v-url:query', $params['query'], $context);
        return $context;
    }
}
