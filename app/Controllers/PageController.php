<?php

namespace App\Controllers;

class PageController
{
  public function home(): string
  {
    return 'Hello depuis le Front Controller !';
  }

  public function cours(): string
  {
    return 'Page des cours';
  }

  public function about(): string
  {
    return 'Page à propos';
  }
}