<?php
namespace app\admin\library;

use think\paginator\driver\Bootstrap;

/**
 *
 */
class Laypage extends Bootstrap
{
    public function __construct($items, $listRows, $currentPage = null, $total = null, $simple = false, $options = [])
    {
        if (empty($options['query'])) {
            $options['query'] = request()->get();
        }
        parent::__construct($items, $listRows, $currentPage, $total, false, $options);
    }

    /**
     * @method   render
     * @DateTime 2017-04-05T12:28:58+0800
     * @return   [type]                   [description]
     */
    public function toArray()
    {

        return [
            'pages' => [
                'curr' => $this->currentPage(),
                'pages' => $this->lastPage,
                'per_page' => $this->listRows(),
            ],
            'data' => $this->items->toArray(),
        ];
    }
}
