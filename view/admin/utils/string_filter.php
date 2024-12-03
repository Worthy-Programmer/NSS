<?php
// Param : $string_filter_selected 

$options = [
    "=" => '=',
    "!=" => "!=",
    "LIKE" => "LIKE",
    "NOT LIKE" => "NOT LIKE",
    "REGEXP" => "REGEXP",
    "NOT REGEXP" => "NOT REGEXP",
    "IN" => "IN (...)",
    "NOT IN" => "NOT IN (...)"
];

foreach ($options as $name => $value) {
    $is_selected = $string_filter_selected === $name;
    $selected_text = $is_selected ? "selected" : "";

    echo <<<HTML
        <option value="$name" $selected_text>$value</option>
      HTML;
}
// <!--     
// <option value="=">=</option>
//     <option value="!=">!=</option>
//     <option value="LIKE">LIKE</option>
//     <option value="LIKE %...%">LIKE %...%</option>
//     <option value="NOT LIKE">NOT LIKE</option>
//     <option value="NOT LIKE %...%">NOT LIKE %...%</option>
//     <option value="REGEXP">REGEXP</option>
//     <option value="REGEXP ^...$">REGEXP ^...$</option>
//     <option value="NOT REGEXP">NOT REGEXP</option>
//     <option value="IN">IN (...)</option>
//     <option value="NOT IN">NOT IN (...)</option> -->

