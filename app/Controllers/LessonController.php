<?php

namespace App\Controllers;

use App\Models\Lesson;
use App\Models\Enrollment;
use App\Models\Level;

class LessonController extends Controller
{
  public function agenda(): string
  {
    $this->requireAuth();

    $role = $_SESSION['user_role'];
    $userId = $_SESSION['user_id'];

    if ($role === 'instructor') {
      $lessons = Lesson::findByInstructor($userId);
      $levels = Level::all();
      return $this->view('lesson/instructor', compact('lessons', 'levels'));
    }

    $available = Lesson::findAvailableFor($userId);
    $enrolled = Enrollment::findByStudent($userId);
    return $this->view('lesson/student', compact('available', 'enrolled'));
  }

  public function store(): string
  {
    $this->requireAuth('instructor');

    $maxSpots = min((int)($_POST['max_spots'] ?? 1), 10);

    Lesson::create([
      'instructorId' => $_SESSION['user_id'],
      'levelCode' => $_POST['level_code'] ?? '',
      'date' => $_POST['date'] ?? '',
      'time' => $_POST['time'] ?? '',
      'maxSpots' => $maxSpots,
    ]);

    $this->redirect('/agenda');
  }

  public function enroll(): string
  {
    $this->requireAuth('student');

    $lessonId = (int)($_POST['lesson_id'] ?? 0);
    $userId = $_SESSION['user_id'];

    if (!Enrollment::exists($lessonId, $userId)) {
      Enrollment::create($lessonId, $userId);
    }

    $this->redirect('/agenda');
  }

  public function cancel(): string
  {
    $this->requireAuth('student');

    $lessonId = (int)($_POST['lesson_id'] ?? 0);
    $userId = $_SESSION['user_id'];

    Enrollment::delete($lessonId, $userId);

    $this->redirect('/agenda');
  }

  private function requireAuth(?string $role = null): void
  {
    if (!isset($_SESSION['user_id'])) {
      $this->redirect('/login');
    }

    if ($role && $_SESSION['user_role'] !== $role) {
      $this->redirect('/');
    }
  }
}
