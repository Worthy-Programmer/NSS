<?php

namespace UI;

class SelectFilter implements Component
{
  private const SELECT = <<<HTML
    <select name="%s" id="%s" autocomplete="off">
      %s
    </select>
HTML;

  private const OPTION = '<option value="%s" %s>%s</option>';

  public const NUMBER_FILTER_OPTIONS =
  [
    "=" => '=',
    ">" => "&gt;",
    ">=" => "&gt;=",
    "<" => "&lt;",
    "<=" => "&lt;=",
    "!=" => "!="
  ];

  public const STRING_FILTER_OPTIONS =
  [
    "=" => '=',
    "!=" => "!=",
    "LIKE" => "LIKE",
    "NOT LIKE" => "NOT LIKE",
    "REGEXP" => "REGEXP",
    "NOT REGEXP" => "NOT REGEXP",
    "IN" => "IN (...)",
    "NOT IN" => "NOT IN (...)"
  ];

  public function __construct(public string $name, public string $id, public array $options, public string $selected_option_name = '') {
  }


  public function render(): void
  {
    $select_html = sprintf(self::SELECT, $this->name, $this->id, $this->renderOptions());
    echo $select_html;
  }

  private function renderOptions(): string
  {
    $html = "";
    foreach ($this->options as $name => $value) {
      // echo $n
      $is_selected = $this->selected_option_name == $name;
      $html .= sprintf(self::OPTION, $name, $is_selected ? "selected" : "", $value);
    }

    return $html;
  }
}
