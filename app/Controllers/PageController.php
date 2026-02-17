<?php

namespace App\Controllers;

class PageController extends Controller
{
  public function home(): string
  {
    return 'Hello depuis le Front Controller !';
  }

  public function courses(): string
  {
    return 'Page des cours';
  }

  public function about(): string
  {
    return 'Page à propos';
  }
}