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
    function treeSort(array $arr, int $parent_id = 0, string $id = 'id', string $parentId = 'parent_id')
    {
        if (empty($arr)) {
            return $arr;
        }
        $newArr = [];
        foreach ($arr as $key => $itme) {
            if ($parent_id == $itme[$parentId]) {
                in_array($itme, $newArr) || $newArr[] = $itme;
                unset($arr[$key]);
                $sub = treeSort($arr, $itme[$id]);
                $newArr = array_merge($newArr, $sub);
            }
        }
        return $newArr;
    }
}

if (!function_exists('toTree')) {
    /**
     * 将一个平面的二维数组按照指定的字段转换为树状结构
     *
     *
     * 如果要获得任意节点为根的子树，可以使用 $refs 参数：
     * @code php
     * $refs = null;
     * $tree = ArrayHelper::tree($rows, 'id', 'parent', 'nodes', $refs);
     *
     * // 输出 id 为 3 的节点及其所有子节点
     * $id = 3;
     * dump($refs[$id]);
     * @endcode
     *
     * @param array $arr 数据源
     * @param string $keyNodeId 节点ID字段名
     * @param string $keyParentId 节点父ID字段名
     * @param string $keyChildrens 保存子节点的字段名
     * @param boolean $refs 是否在返回结果中包含节点引用
     *
     * return array 树形结构的数组
     */
    function toTree(
        $arr,
        $keyNodeId = 'id',
        $keyParentId = 'parent_id',
        $keyChildrens = 'childrens',
        &$refs = null
    ) {
        $refs = array();
        foreach ($arr as $offset => $row) {
            $arr[$offset][$keyChildrens] = array();
            $refs[$row[$keyNodeId]] = &$arr[$offset];
        }

        $tree = array();
        foreach ($arr as $offset => $row) {
            $parentId = $row[$keyParentId];
            if ($parentId) {
                if (!isset($refs[$parentId])) {
                    $tree[] = &$arr[$offset];
                    continue;
                }
                $parent = &$refs[$parentId];
                $parent[$keyChildrens][] = &$arr[$offset];
            } else {
                $tree[] = &$arr[$offset];
            }
        }
        return $tree;
    }
}
