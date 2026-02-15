<?php

namespace App\Models;

use App\Database;

class User
{
    public static function findByEmail(string $email): ?array
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare('SELECT id, email, password, role FROM users WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc() ?: null;
    }

    public static function emailExists(string $email): bool
    {
        return self::findByEmail($email) !== null;
    }

    public static function create(array $data): bool
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare(
            'INSERT INTO users (email, password, first_name, last_name, address, postal_code, city, phone, role)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->bind_param(
            'sssssssss',
            $data['email'],
            $data['password'],
            $data['firstName'],
            $data['lastName'],
            $data['address'],
            $data['postalCode'],
            $data['city'],
            $data['phone'],
            $data['role']
        );

        return $stmt->execute();
    }
}
