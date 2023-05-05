<?php

namespace System;

use Illuminate\Support\Facades\Request;

class Tree {

    /**
     * Contains tree item
     *
     * @var array
     */
    public $items = [];

    /**
     * Contains acl roles
     *
     * @var array
     */
    public $roles = [];

    /**
     * Contains current item route
     *
     * @var string
     */
    public $current;

    /**
     * Contains current item key
     *
     * @var string
     */
    public $currentKey;

    /**
     * Create a new instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->current = Request::url();
    }

    /**
     * Shortcut method for create a Config with a callback.
     * This will allow you to do things like fire an event on creation.
     *
     * @param  callable  $callback Callback to use after the Config creation
     * @return object
     */
    public static function create($callback = null)
    {
        $tree = new Tree();

        if ($callback) {
            $callback($tree);
        }

        return $tree;
    }

    /**
     * Add a Config item to the item stack
     *
     * @param  string  $item
     * @return void
     */
    public function add($item, $type = '')
    {
        $item['children'] = [];

        if ($type == 'menu' && isset($item['route'])) {

            $item['url'] = route($item['route'], $item['params'] ?? []);

            if (strpos($this->current, $item['url']) !== false) {
                $this->currentKey = $item['key'];
            }
        }

        $children = str_replace('.', '.children.', $item['key']);

        return $this->array_set($this->items, $children, $item);
    }

    /**
     * Method to find the active links
     *
     * @param  array  $item
     * @return string|void
     */
    public function getActive($item)
    {
        $url = trim($item['url'], '/');

        if (
            (strpos($this->current, $url) !== false)
            || (strpos($this->currentKey, $item['key']) === 0)
        ) {
            return 'active';
        }
    }

    public function array_set(&$array, $key, $value)
    {
        if (is_null($key)) {
            return $array = $value;
        }

        $keys = explode('.', $key);
        $count = count($keys);

        while (count($keys) > 1) {
            $key = array_shift($keys);

            if (
                ! isset($array[$key])
                || ! is_array($array[$key])
            ) {
                $array[$key] = [];
            }

            $array = &$array[$key];
        }

        $finalKey = array_shift($keys);

        if (isset($array[$finalKey])) {
            $array[$finalKey] = $this->arrayMerge($array[$finalKey], $value);
        } else {
            $array[$finalKey] = $value;
        }

        return $array;
    }

    public function convertToAssociativeArray($items)
    {
        foreach ($items as $key1 => $level1) {
            unset($items[$key1]);
            $items[$level1['key']] = $level1;

            if (count($level1['children'])) {
                foreach ($level1['children'] as $key2 => $level2) {
                    $temp2 = explode('.', $level2['key']);
                    $finalKey2 = end($temp2);
                    unset($items[$level1['key']]['children'][$key2]);
                    $items[$level1['key']]['children'][$finalKey2] = $level2;

                    if (count($level2['children'])) {
                        foreach ($level2['children'] as $key3 => $level3) {
                            $temp3 = explode('.', $level3['key']);
                            $finalKey3 = end($temp3);
                            unset($items[$level1['key']]['children'][$finalKey2]['children'][$key3]);
                            $items[$level1['key']]['children'][$finalKey2]['children'][$finalKey3] = $level3;
                        }
                    }

                }
            }
        }

        return $items;
    }

    protected function arrayMerge(array &$array1, array &$array2)
    {
        $merged = $array1;

        foreach ($array2 as $key => &$value) {
            if (
                is_array($value)
                && isset($merged[$key])
                && is_array($merged[$key])
            ) {
                $merged[$key] = $this->arrayMerge($merged[$key], $value);
            } else {
                $merged[$key] = $value;
            }
        }

        return $merged;
    }

    public function sortItems($items)
    {
        foreach ($items as &$item) {
            if (count($item['children'])) {
                $item['children'] = $this->sortItems($item['children']);
            }
        }


        return $this->convertToAssociativeArray($items);
    }

}
