<?php

namespace App\Models;

use App\Database;

class Lesson
{
    public static function create(array $data): bool
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare(
            'INSERT INTO lessons (instructor_id, level_code, date, time, max_spots)
             VALUES (?, ?, ?, ?, ?)'
        );
        $stmt->bind_param(
            'isssi',
            $data['instructorId'],
            $data['levelCode'],
            $data['date'],
            $data['time'],
            $data['maxSpots']
        );

        return $stmt->execute();
    }

    public static function findByInstructor(int $instructorId): array
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare(
            'SELECT s.id, s.date, s.time, s.max_spots,
                    l.name AS level,
                    COUNT(e.id) AS enrolled_count
             FROM lessons s
             JOIN levels l ON s.level_code = l.code
             LEFT JOIN enrollments e ON s.id = e.lesson_id
             WHERE s.instructor_id = ?
             GROUP BY s.id
             ORDER BY s.date ASC, s.time ASC'
        );
        $stmt->bind_param('i', $instructorId);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public static function findAvailableFor(int $studentId): array
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare(
            'SELECT s.id, u.email AS instructor_email, s.date, s.time,
                    l.name AS level,
                    s.max_spots - COUNT(e.id) AS available_spots
             FROM lessons s
             JOIN users u ON s.instructor_id = u.id
             JOIN levels l ON s.level_code = l.code
             LEFT JOIN enrollments e ON s.id = e.lesson_id
             WHERE s.id NOT IN (SELECT lesson_id FROM enrollments WHERE user_id = ?)
             GROUP BY s.id
             ORDER BY s.date ASC, s.time ASC'
        );
        $stmt->bind_param('i', $studentId);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
