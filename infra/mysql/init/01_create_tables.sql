USE ctf_db;

CREATE TABLE IF NOT EXISTS flags (
    flag    VARCHAR(255)    CHARACTER SET utf8mb4 COLLATE utf8mb4_bin    NOT NULL UNIQUE PRIMARY KEY,
    points  INT             NOT NULL
);

CREATE TABLE IF NOT EXISTS players (
    user_name    VARCHAR(255)    CHARACTER SET utf8mb4 COLLATE utf8mb4_bin    NOT NULL UNIQUE PRIMARY KEY
);

CREATE TABLE IF NOT EXISTS user_flags (
    user_name    VARCHAR(255)    CHARACTER SET utf8mb4 COLLATE utf8mb4_bin    NOT NULL,
    flag         VARCHAR(255)    CHARACTER SET utf8mb4 COLLATE utf8mb4_bin    NOT NULL,

    PRIMARY KEY (user_name, flag),
    FOREIGN KEY (user_name) REFERENCES players(user_name),
    FOREIGN KEY (flag)       REFERENCES flags(flag)
);