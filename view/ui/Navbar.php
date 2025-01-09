<?php

namespace UI;

class Navbar implements Component
{
  private const HEADER = <<<HTML
    <!-- Header -->
  <header>
    <div id="logo">
      <img src="/view/static/logo.png" alt="NSS Logo" />
      <h2>IIT MADRAS</h2>
    </div>
    <i id="hamburger" class="fas fa-bars"></i>
    <nav>
    %s
    </nav>
  </header>
HTML;

  private const LINK = '<a href="%s" class="%s">%s</a>';

  public function __construct(public array $links, public string $active_field = "") {}

  public function render(): void
  {
    $header_html = sprintf(self::HEADER, $this->renderLinks());
    echo $header_html;
  }
  
  private function renderLinks(): string {
    $html = "";
    foreach($this->links as $name => $link) {
      $html .= sprintf(self::LINK, $link, $this->active_field == $name ? 'active' : '', $name);
    }

    return $html;
  }
}
