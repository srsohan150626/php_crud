<?php

$arr = [
    [
        "id" => "1001",
        "name" => "Bangladesh",
        "parent_id" => "null"
    ],
    [
        "id" => "1002",
        "name" => "Dhaka",
        "parent_id" => "1001"
    ],
    [
        "id" => "1003",
        "name" => "Mirpur",
        "parent_id" => "1002"
    ],
    [
        "id" => "1004",
        "name" => "Mirpur DOHS",
        "parent_id" => "1003"
    ],
    [
        "id" => "1005",
        "name" => "Rajshahi",
        "parent_id" => "1001"
    ],
   
];
$new = array();
foreach ($arr as $a){
    $new[$a['parent_id']][] = $a;
}

$tree = createMenu($new, array($arr[0]));


displayRecursive($tree);


function displayRecursive($array){
    echo "<ul>";
        foreach($array as $value){
        echo "<li>".$value['name'];
            if(isset($value['children']) && !empty($value['children'])){
                displayRecursive($value['children']);
            }
        }
    echo "</ul>";
}


function createMenu(&$list, $parent){
    $tree = array();
    foreach ($parent as $k=>$l){
        if(isset($list[$l['id']])){
            $l['children'] = createMenu($list, $list[$l['id']]);
        }
        $tree[] = $l;
    } 
    return $tree;
}
