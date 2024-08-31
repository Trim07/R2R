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
                CREATE TABLE `customer_addresses`(
                    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    `customer_id` BIGINT UNSIGNED NOT NULL,
                    `name` VARCHAR(30) NOT NULL,
                    `street` VARCHAR(50) NOT NULL,
                    `number` VARCHAR(10) NOT NULL,
                    `neighborhood` VARCHAR(30) NOT NULL,
                    `city` VARCHAR(50) NOT NULL,
                    `state` CHAR(4) NOT NULL,
                    `country` CHAR(3) NOT NULL DEFAULT 'BRA',
                    `zipcode` CHAR(8) NOT NULL,
                    `complement` VARCHAR(50),
                    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                ) ENGINE=INNODB;
                ALTER TABLE
                    `customer_addresses` ADD INDEX `customer_addresses_id_index`(`id`);
                ALTER TABLE
                    `customer_addresses` ADD INDEX `customer_addresses_customer_id_index`(`customer_id`);
                ALTER TABLE
                    `customer_addresses` ADD INDEX `customer_addresses_city_index`(`city`);
                ALTER TABLE
                    `customer_addresses` ADD INDEX `customer_addresses_state_index`(`state`);
                ALTER TABLE
                    `customer_addresses` ADD INDEX `customer_addresses_country_index`(`country`);
                ALTER TABLE
                    `customer_addresses` ADD INDEX `customer_addresses_zipcode_index`(`zipcode`);
                ALTER TABLE
                    `customer_addresses` ADD CONSTRAINT `customer_addresses_customer_id_foreign` FOREIGN KEY(`customer_id`) REFERENCES `customers`(`id`);
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
