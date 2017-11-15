<?php
/**
 * Created by PhpStorm.
 * User: dubin
 * Date: 2016/6/27
 * Time: 17:31
 */
function strsToArray($strs) {
    $result = array();
    $array = array();
    $strs = str_replace('，', ',', $strs);
    $strs = str_replace("n", ',', $strs);
    $strs = str_replace("rn", ',', $strs);
    $strs = str_replace(' ', ',', $strs);
    $array = explode(',', $strs);
    foreach ($array as $key => $value) {
        if ('' != ($value = trim($value))) {
            $result[] = $value;
        }
    }
    return $result;
}


function emptyreplace($str) {
    $str = str_replace('　', ' ', $str); //替换全角空格为半角
    $str = str_replace(' ', ' ', $str); //替换连续的空格为一个
    $noe = false; //是否遇到不是空格的字符
    for ($i=0 ; $i<strlen($str); $i++) { //遍历整个字符串
        if($noe && $str[$i]==' ') $str[$i] = ','; //如果当前这个空格之前出现了不是空格的字符
        elseif($str[$i]!=' ') $noe=true; //当前这个字符不是空格，定义下 $noe 变量
    }
    return $str;
}