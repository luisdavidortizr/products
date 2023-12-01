<?php

class Validate {
    public function format_price($price) {
        return number_format($price, 2, '.', ',');
    }

    public function check_empty($data, $fields) {
        $msg = null;
        foreach ($fields as $field) {
            if(empty($data[$field])) {
                $msg .= "<p>$field field is empty</p>";
            }
        }
        return $msg;
    }
}

?>