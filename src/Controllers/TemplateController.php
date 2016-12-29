<?php

namespace Muyu\Controllers;

use Exception;

class TemplateController
{
    public function view($name, $params = null)
    {
        $path = $this->getViewPath($name);
        $this->checkViewExist($path);
        $context = file_get_contents($path);
        return $this->dataBind($context, $params);
    }

    private function checkViewExist($path)
    {
        if (!file_exists($path)) {
            throw new Exception('This view is not found');
        }
    }

    private function getViewPath($name)
    {
        return 'src/Views/' . $name . '.template.php';
    }

    /**
     * @description 数据绑定，<-- o(*≧▽≦)ツ┏━┓ 拍桌狂笑 -->
     * @param $context
     * @param $params
     * @return mixed
     * @author Zhou Yu
     */
    private function dataBind($context, $params)
    {
        if (!$params) {
            return $context;
        }
        $context = str_replace('v-url:generate', $params['generate'], $context);
        $context = str_replace('v-url:valid', $params['valid'], $context);
        $context = str_replace('v-url:query', $params['query'], $context);
        return $context;
    }
}
