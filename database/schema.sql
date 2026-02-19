-- Base de données : inline_skate
-- Encodage : utf8mb4 / utf8mb4_unicode_ci

CREATE DATABASE IF NOT EXISTS inline_skate
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE inline_skate;

-- Niveaux de cours (référentiel)
CREATE TABLE levels (
  code        VARCHAR(3)         NOT NULL,
  sort_order  TINYINT UNSIGNED   NOT NULL,
  name        VARCHAR(50)        NOT NULL,
  price       DECIMAL(6,2)       NOT NULL,
  PRIMARY KEY (code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Utilisateurs
CREATE TABLE users (
  id          INT UNSIGNED       NOT NULL AUTO_INCREMENT,
  email       VARCHAR(180)       NOT NULL,
  password    VARCHAR(255)       NOT NULL,
  first_name  VARCHAR(100)       NOT NULL,
  last_name   VARCHAR(100)       NOT NULL,
  address     VARCHAR(255)       NOT NULL,
  postal_code VARCHAR(10)        NOT NULL,
  city        VARCHAR(100)       NOT NULL,
  phone       VARCHAR(20)        NOT NULL,
  role        ENUM('admin','instructor','student') NOT NULL DEFAULT 'student',
  created_at  DATETIME           NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at  DATETIME           NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_users_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Séances de cours
CREATE TABLE lessons (
  id            INT UNSIGNED     NOT NULL AUTO_INCREMENT,
  instructor_id INT UNSIGNED     NOT NULL,
  level_code    VARCHAR(3)       NOT NULL,
  date          DATE             NOT NULL,
  time          TIME             NOT NULL,
  max_spots     TINYINT UNSIGNED NOT NULL DEFAULT 6,
  created_at    DATETIME         NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  CONSTRAINT fk_lessons_instructor FOREIGN KEY (instructor_id) REFERENCES users (id)   ON DELETE CASCADE,
  CONSTRAINT fk_lessons_level      FOREIGN KEY (level_code)    REFERENCES levels (code) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Inscriptions
CREATE TABLE enrollments (
  id         INT UNSIGNED  NOT NULL AUTO_INCREMENT,
  lesson_id  INT UNSIGNED  NOT NULL,
  user_id    INT UNSIGNED  NOT NULL,
  paid       BOOLEAN       NOT NULL DEFAULT FALSE,
  created_at DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_enrollment (lesson_id, user_id),
  CONSTRAINT fk_enrollments_lesson FOREIGN KEY (lesson_id) REFERENCES lessons (id) ON DELETE CASCADE,
  CONSTRAINT fk_enrollments_user   FOREIGN KEY (user_id)   REFERENCES users (id)   ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
