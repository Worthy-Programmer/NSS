  <?php
  // Param : $number_filter_selected 

    $options = [
      "=" => '=',
      ">" => "&gt;",
      ">=" => "&gt;=",
      "<" => "&lt;",
      "<=" => "&lt;=",
      "!=" => "!="
    ];

    foreach ($options as $name => $value) {
      $is_selected = $number_filter_selected === $name;
      $selected_text = $is_selected ? "selected" : "";

      echo <<<HTML
        <option value="$name" $selected_text>$value</option>
      HTML;
    }
