<?php
namespace app\admin\library;

class ArrayHelper
{

    /**
     * 从数组中删除空白的元素（包括只有空白字符的元素）
     *
     * 用法：
     * @code php
     * $arr = array('', 'test', '   ');
     * ArrayHelper::removeEmpty($arr);
     *
     * dump($arr);
     *   // 输出结果中将只有 'test'
     * @endcode
     *
     * @param array $arr 要处理的数组
     * @param boolean $trim 是否对数组元素调用 trim 函数
     */
    public static function removeEmpty(&$arr, $trim = true)
    {
        if (empty($arr)) {
            return [];
        }
        foreach ($arr as $key => $value) {
            if (is_array($value)) {
                self::removeEmpty($arr[$key]);
            } else {
                $value = ($trim && is_string($value)) ? trim($value) : $value;
                if ($value === '' || $value === null) {
                    unset($arr[$key]);
                } elseif ($trim) {
                    $arr[$key] = $value;
                }
            }
        }
    }

    /**
     * 将一个二维数组转换为 HashMap，并返回结果
     *
     * 用法1：
     * @code php
     * $rows = array(
     *     array('id' => 1, 'value' => '1-1'),
     *     array('id' => 2, 'value' => '2-1'),
     * );
     * $hashmap = ArrayHelper::toHashmap($rows, 'id', 'value');
     *
     * dump($hashmap);
     *   // 输出结果为
     *   // array(
     *   //   1 => '1-1',
     *   //   2 => '2-1',
     *   // )
     * @endcode
     *
     * 如果省略 $valueField 参数，则转换结果每一项为包含该项所有数据的数组。
     *
     * 用法2：
     * @code php
     * $rows = array(
     *     array('id' => 1, 'value' => '1-1'),
     *     array('id' => 2, 'value' => '2-1'),
     * );
     * $hashmap = ArrayHelper::toHashmap($rows, 'id');
     *
     * dump($hashmap);
     *   // 输出结果为
     *   // array(
     *   //   1 => array('id' => 1, 'value' => '1-1'),
     *   //   2 => array('id' => 2, 'value' => '2-1'),
     *   // )
     * @endcode
     *
     * @param array $arr 数据源
     * @param string $keyField 按照什么键的值进行转换
     * @param string $valueField 对应的键值
     *
     * @return array 转换后的 HashMap 样式数组
     */
    public static function toHashmap($arr, $keyField, $valueField = null)
    {
        $ret = array();
        if ($valueField) {
            foreach ($arr as $row) {
                $ret[$row[$keyField]] = $row[$valueField];
            }
        } else {
            foreach ($arr as $row) {
                $ret[$row[$keyField]] = $row;
            }
        }
        return $ret;
    }

    /**
     * 只取二维数组中的苛一key 并保持索引
     * 如果指定了可选参数 indexKey 那么input数组中的这一列的值将作为返回数组中对应值的键。
     * @param  [type] $arr      [description]
     * @param  [type] $keyField [description]
     * @param  string $indexKey [description]
     * @return [type]           [description]
     */
    public static function toHashmapOneKey($arr, $keyField, $indexKey = '')
    {
        $ret = array();
        foreach ($arr as $value) {
            if ($indexKey != '') {
                $ret[$value[$indexKey]][$keyField] = $value[$keyField];
            } else {
                $ret[][$keyField] = $value[$keyField];
            }
        }
        return $ret;
    }

    /**
     * 将一个二维数组按照指定字段的值分组
     *
     * 用法：
     * @endcode
     *
     * @param array $arr 数据源
     * @param string $keyField 作为分组依据的键名
     *
     * @return array 分组后的结果
     */
    public static function groupBy($arr, $keyField)
    {
        $ret = array();
        foreach ($arr as $row) {
            $key = $row[$keyField];
            $ret[$key][] = $row;
        }
        return $ret;
    }

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
    public static function toTree(
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

    /**
     * 构建无限 级分类
     * @param $rows
     * @param string $id
     * @param string $pid
     * @param string $child
     * @param int $root
     * @return array
     */
    public static function getDataTree($items, $id = 'id', $pid = 'parentid', $child = 'childrens')
    {
        if (empty($items)) {
            return [];
        }
        $array = [];
        foreach ($items as $val) {
            $array[$val[$id]] = $val;
        }

        $tree = array(); //格式化好的树
        foreach ($array as $item) {
            if (isset($array[$item[$pid]])) {
                $array[$item[$pid]][$child][] = &$array[$item[$id]];
            } else {
                $tree[] = &$array[$item[$id]];
            }
        }
        return $tree;
    }

    /**
     * 将树形数组展开为平面的数组
     *
     * 这个方法是 tree() 方法的逆向操作。
     *
     * @param array $tree 树形数组
     * @param string $keyChildrens 包含子节点的键名
     *
     * @return array 展开后的数组
     */
    public static function treeToArray($tree, $keyChildrens = 'childrens')
    {
        $ret = array();
        if (isset($tree[$keyChildrens]) && is_array($tree[$keyChildrens])) {
            foreach ($tree[$keyChildrens] as $child) {
                $ret = array_merge($ret, self::treeToArray($child, $keyChildrens));
            }
            unset($node[$keyChildrens]);
            $ret[] = $tree;
        } else {
            $ret[] = $tree;
        }
        return $ret;
    }

    /**
     * 根据指定的键对数组排序
     *
     * @endcode
     *
     * @param array $array 要排序的数组
     * @param string $keyname 排序的键
     * @param int $dir 排序方向
     *
     * @return array 排序后的数组
     */
    public static function sortByCol($array, $keyname, $dir = SORT_ASC)
    {
        return self::sortByMultiCols($array, array($keyname => $dir));
    }

    /**
     * 将一个二维数组按照多个列进行排序，类似 SQL 语句中的 ORDER BY
     *
     * 用法：
     * @code php
     * $rows = ArrayHelper::sortByMultiCols($rows, array(
     *     'parent' => SORT_ASC,
     *     'name' => SORT_DESC,
     * ));
     * @endcode
     *
     * @param array $rowset 要排序的数组
     * @param array $args 排序的键
     *
     * @return array 排序后的数组
     */
    public static function sortByMultiCols($rowset, $args)
    {
        $sortArray = array();
        $sortRule = '';
        foreach ($args as $sortField => $sortDir) {
            foreach ($rowset as $offset => $row) {
                $sortArray[$sortField][$offset] = $row[$sortField];
            }
            $sortRule .= '$sortArray[\'' . $sortField . '\'], ' . $sortDir . ', ';
        }
        if (empty($sortArray) || empty($sortRule)) {
            return $rowset;
        }
        eval('array_multisort(' . $sortRule . '$rowset);');
        return $rowset;
    }

    /**
     * 将一个有序数组[hashmap]转无序数组[list]
     * @param  [type] $array [description]
     * @return [type]        [description]
     */
    public static function hashmapToList($array)
    {
        $newArray = array();
        foreach ($array as $key => $value) {
            $newArray[] = $value;
        }
        return $newArray;
    }

    /**
     * 把两个数组进行合并，并把第二个数组的值放到 $key 索引中
     * @param  [type] $array1 [description]
     * @param  [type] $array2 [description]
     * @param  [type] $key    [description]
     * @return [type]         [description]
     */
    public static function arrayMerge($array1, $array2, $key = '')
    {
        foreach ($array1 as $key1 => $value1) {
            if (isset($array2[$key1])) {
                $array1[$key1][$key] = $array2[$key1];
            }
        }

        return $array1;
    }

    /**
     * 修改二维数组的某一列数据
     * @param  [type] $array [description]
     * @param  [type] $key   [description]
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public static function editArrayColumn($array, $columnKey, $columnValue)
    {
        foreach ($array as $key => $value) {
            $array[$key][$columnKey] = $columnValue;
        }
        return $array;
    }

    /**
     * 删除二维数组的某一列数据
     * @param  [type] $array       [description]
     * @param  [type] $columnKey   [description]
     * @return [type]              [description]
     */
    public static function delArrayColumn($array, $columnKey)
    {
        foreach ($array as $key => $value) {
            unset($array[$key][$columnKey]);
        }
        return $array;
    }

    /**
     * 对有可能 是对象的数据转数组
     * @param  [type] &$object [description]
     * @return [type]          [description]
     */
    public static function objectToArray(&$object)
    {
        $object = json_decode(json_encode($object), true);
        return $object;
    }

    /**
     * @param  [type]
     * @param  [type]
     * @param  [type]
     * @return [type]
     */
    public static function arrayColumn($input, $column_key, $index_key = null)
    {
        $arr = array_map(function ($d) use ($column_key, $index_key) {
            if (is_object($d)) {
                $d = (array) $d;
            }
            if (!isset($d[$column_key])) {
                return null;
            }
            if ($index_key !== null) {
                return array($d[$index_key] => $d[$column_key]);
            }
            return $d[$column_key];
        }, $input);

        if ($index_key !== null) {
            $tmp = array();
            foreach ($arr as $ar) {
                $tmp[key($ar)] = current($ar);
            }
            $arr = $tmp;
        }
        return $arr;
    }

    /**
     * 二维数组通过 $index_key 求 $column_key 的和
     * @method   arrayColumnSum
     * @DateTime 2016-11-16T17:52:09+0800
     * @param    string $value [description]
     * @return   [type]                          [description]
     */
    public static function arrayColumnSum($input, $column_key, $index_key)
    {
        $array = [];

        foreach ($input as $key => $value) {
            if (isset($value[$column_key]) && isset($value[$index_key])) {
                $array[$value[$index_key]] = isset($array[$value[$index_key]]) ? ($array[$value[$index_key]] + $value[$column_key]) : $value[$column_key];
            }
        }

        return $array;
    }
}
