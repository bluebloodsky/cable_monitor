<?php
/**
 * Created by PhpStorm.
 * User: libgcc
 * Date: 2017/11/20
 * Time: 16:39
 */

function gCastIntValue($fields, &$q, $isRow=false)
{
    if($isRow) {
        foreach ($fields as $field){
            if(!array_key_exists($field, $q))
                continue;
            $q[$field] = intval($q[$field]);
        }
    } else {
        foreach($q as &$row)
        {
            foreach ($fields as $field){
                if(!array_key_exists($field, $row))
                    continue;
                $row[$field] = intval($row[$field]);
            }
        }
    }
}