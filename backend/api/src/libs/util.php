<?php

function GetMapDiff($arrayOldData, $arrayNewData)
{
    $differ = new Diff\Differ\MapDiffer();
    $result = [];
    $diffs = $differ->doDiff($arrayOldData, $arrayNewData);
    foreach ($diffs as $key => $diff) {
        if ($diff->getType() == 'change') {
            $newValue = $diff->getNewValue();
            $oldValue = $diff->getOldValue();
            if (is_array($newValue) && is_array($oldValue)) {
                $result[$key] = GetMapDiff($oldValue, $newValue);
            } else {
                $result[$key] = $diff->toArray();
            }
        }else{
            $result[$key] = $diff->toArray();
        }
    }
    return $result;
}

function Str2Time($str)
{
    if (strlen($str) != 8)
    return '0000-00-00';

$arr = str_split($str, 2);
return "$arr[0]$arr[1]-$arr[2]-$arr[3]";
}