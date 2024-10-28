<?php

namespace App\Helpers;

class TreeListHelper
{
    public static function filterFields(array $items, array $fields): array
    {
        return array_map(function ($item) use ($fields) {
            $filteredItem = array_intersect_key($item, array_flip($fields));

            if (isset($item['children'])) {
                $filteredItem['children'] = self::filterFields($item['children'], $fields);
            }
            return $filteredItem;
        }, $items);
    }
}
