<?php

namespace App\Models;

use App\Database;

class Enrollment
{
    public static function exists(int $lessonId, int $userId): bool
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare('SELECT id FROM enrollments WHERE lesson_id = ? AND user_id = ?');
        $stmt->bind_param('ii', $lessonId, $userId);
        $stmt->execute();

        return $stmt->get_result()->num_rows > 0;
    }

    public static function create(int $lessonId, int $userId): bool
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare('INSERT INTO enrollments (lesson_id, user_id) VALUES (?, ?)');
        $stmt->bind_param('ii', $lessonId, $userId);

        return $stmt->execute();
    }

    public static function delete(int $lessonId, int $userId): bool
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare('DELETE FROM enrollments WHERE lesson_id = ? AND user_id = ?');
        $stmt->bind_param('ii', $lessonId, $userId);

        return $stmt->execute();
    }

    public static function findByStudent(int $userId): array
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare(
            'SELECT s.id, u.email AS instructor_email, s.date, s.time,
                    l.name AS level
             FROM lessons s
             JOIN enrollments e ON s.id = e.lesson_id
             JOIN levels l ON s.level_code = l.code
             JOIN users u ON s.instructor_id = u.id
             WHERE e.user_id = ?
             ORDER BY s.date ASC, s.time ASC'
        );
        $stmt->bind_param('i', $userId);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
