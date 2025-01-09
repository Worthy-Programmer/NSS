<?php

namespace UI;

class Head implements Component
{
  public const FONT_AWESOME_SCRIPT = 'https://kit.fontawesome.com/6db7b46a37.js';

  public const START = <<<HTML
  <head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />     
  <link rel="icon" type="image/x-icon" href="/view/static/logo.png" /> 
HTML;

  private string $content = '';

  public function __construct(public string $title, public array $stylesheets, public array $scripts = [self::FONT_AWESOME_SCRIPT]) {}

  public function render(): void
  {
    $this->content = self::START . $this->renderTitle() . $this->renderStylesheets() . $this->renderScripts() . "</head>";
    echo $this->content;
  }

  private function renderStylesheets(): string
  {
    $html = '';
    foreach ($this->stylesheets as $stylesheet) {
      $html .= sprintf('<link rel="stylesheet" href="/view/styles/%s">', $stylesheet);
    }
    return $html;
  }

  private function renderTitle(): string
  {
    return sprintf('<title>%s | NSS IITM</title>', $this->title);
  }


  private function renderScripts(): string
  {
    $html = '';
    foreach ($this->scripts as $script) {
      $html .= sprintf('<script src="%s" crossorigin="anonymous"></script>', $script);
    }
    return $html;
  }
}
