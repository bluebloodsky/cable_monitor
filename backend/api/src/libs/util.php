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