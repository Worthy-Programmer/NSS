<?php

namespace UI;

class TableRecords implements Component
{
  const SKELETON = <<<HTML
  <table class="table_records" id="%s">
        <thead>
          <tr>
            %s
          </tr>
        </thead>
        <tbody>
          %s
        </tbody>
  </table>
HTML;


  const TR = <<<HTML
  <tr>%s</tr>
HTML;

  const TH = <<<HTML
  <th> %s </th>
HTML;

  const TD = <<<HTML
  <td> %s </td>
HTML;

  const CHECKBOX = <<<HTML
  <input type="checkbox" name="%s" id="%s" >
HTML;
  const CHECKBOX_WITH_FORM = <<<HTML
  <input type="checkbox" name="%s" id="%s" form="%s">
HTML;


  const LINK = <<<HTML
  <a href="%s"> %s </a>
HTML;
  public function __construct(private string $id, private array $headers, private array $data, private $process_func) {}

  public function render(): void
  {
    printf(self::SKELETON, $this->id, $this->renderHeaderRows(), $this->renderBodyRows());
  }


  private function renderBodyRows(): string
  {
    $row_html = '';
    foreach ($this->data as $row) {
      $td_html = '';
      foreach (call_user_func($this->process_func, $row) as $cell) {
        if (is_array($cell)) {
          array_walk($cell[1], 'htmlentities');
          $td_html .= sprintf(self::TD, sprintf($cell[0], ...$cell[1]));
        } else
          $td_html .= sprintf(self::TD, htmlentities($cell));
      }
      $row_html .= sprintf(self::TR, $td_html);
    }

    return $row_html;
  }

  private function renderHeaderRows(): string
  {
    $th_html = '';

    foreach ($this->headers as $header) {
      $th_html .= sprintf(self::TH, htmlentities($header));
    }
    return $th_html;
  }
}
