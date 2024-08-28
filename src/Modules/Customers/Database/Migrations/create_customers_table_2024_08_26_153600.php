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
                CREATE TABLE `customers`(
                    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    `name` VARCHAR(100) NOT NULL,
                    `birthday` DATE NOT NULL,
                    `cpf` CHAR(11) UNIQUE NOT NULL,
                    `rg` VARCHAR(10) UNIQUE NOT NULL,
                    `phone` VARCHAR(11) UNIQUE NOT NULL,
                    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                ) ENGINE=INNODB;
                
                ALTER TABLE
                    `customers` ADD INDEX `customers_id_index`(`id`);
                ALTER TABLE
                    `customers` ADD INDEX `customers_name_index`(`name`);
                ALTER TABLE
                    `customers` ADD INDEX `customers_birthday_index`(`birthday`);
                ALTER TABLE
                    `customers` ADD INDEX `customers_cpf_index`(`cpf`);
                ALTER TABLE
                    `customers` ADD INDEX `customers_rg_index`(`rg`);
                ALTER TABLE
                    `customers` ADD INDEX `customers_phone_index`(`phone`);
                ALTER TABLE
                    `customers` ADD UNIQUE `customers_cpf_unique`(`cpf`);
                ALTER TABLE
                    `customers` ADD UNIQUE `customers_rg_unique`(`rg`);
                ALTER TABLE
                    `customers` ADD UNIQUE `customers_phone_unique`(`phone`);
            ";

        return $sql;
    }

   /**
     * Reverse migration
     * @return string
     */
    public function down(): string
    {
        $sql = "DROP TABLE IF EXISTS customers;";
        return $sql;
    }
};
