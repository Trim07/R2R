<?php

use App\Core\Interfaces\MigrationsInterface;

return new class implements MigrationsInterface
{
    /**
     * Up migration
     * @return string
     */
    public function up(): string
    {
        $sql = "
                CREATE TABLE `users`(
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(100) NOT NULL,
                    email VARCHAR(100) NOT NULL UNIQUE,
                    password VARCHAR(255) NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                ) ENGINE=INNODB;
                
                ALTER TABLE
                    `users` ADD INDEX `users_id_index`(`id`);
                ALTER TABLE
                    `users` ADD INDEX `users_name_index`(`name`);

                ALTER TABLE `customers` ADD COLUMN `user_id` INT NOT NULL;
                ALTER TABLE `customers` ADD CONSTRAINT fk_users_user_id FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE;
            ";

        return $sql;
    }

   /**
     * Reverse migration
     * @return string
     */
    public function down(): string
    {
        $sql = "DROP TABLE IF EXISTS users;";
        return $sql;
    }
};
