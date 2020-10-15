<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SfUtils\ArrayUtils;

class ElementsOp {

    public function containsObject(Array $arr, $element): bool {
        $flag = false;
        foreach ($arr as $a) {
            if ($a == $element) {
                $flag = true;
            } else {
                
            }
        }
        return $flag;
    }

}
