USE target_db;

CREATE TABLE IF NOT EXISTS users (
    id           INT             NOT NULL UNIQUE PRIMARY KEY,
    user_name    VARCHAR(255)    CHARACTER SET utf8mb4 COLLATE utf8mb4_bin    NOT NULL UNIQUE,
    passwd       VARCHAR(255)    CHARACTER SET utf8mb4 COLLATE utf8mb4_bin    NOT NULL
);