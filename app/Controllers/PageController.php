<?php

namespace App\Controllers;

class PageController extends Controller
{
  public function home(): string
  {
    return $this->view('home');
  }

  public function courses(): string
  {
    return $this->view('courses');
  }

  public function about(): string
  {
    return $this->view('about');
  }
}
