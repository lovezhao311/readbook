<?php

if (!function_exists('treeSort')) {
    /**
     * 二维数组通过树排序
     * @method   treeSort
     * @DateTime 2017-03-31T16:06:36+0800
     * @param    array                    $arr 只能用于有序数组
     * @param    string                    $parentId 上级菜单
     * @return   [type]                        [description]
     */
    function treeSort(array $arr, string $id = 'id', string $parentId = 'parent_id')
    {
        if (empty($arr)) {
            return $arr;
        }
        $count = count($arr);

        $newArr = [];
        for ($i = 0; $i < $count; $i++) {
            if (!isset($arr[$i])) {
                continue;
            }
            $newArr[] = $arr[$i];
            unset($arr[$i]);
            $count2 = count($arr);
            for ($j = 0; $j < $count2; $j++) {
                if ($arr[$i][$id] == $arr[$j][$parentId]) {
                    $newArr[] = $arr[$j];
                    unset($arr[$i]);
                }
            }
        }

        return $newArr;

    }
}
