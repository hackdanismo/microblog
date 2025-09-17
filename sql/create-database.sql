-- Create the database (if not exists), wrap the name in backticks because of the hyphen used
CREATE DATABASE IF NOT EXISTS `db-microblog`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_general_ci;

-- Select the database
USE `db-microblog`;