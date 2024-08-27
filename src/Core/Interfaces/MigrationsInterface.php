<?php

namespace App\Core\Interfaces;

interface MigrationsInterface
{

    /**
     * used to up a migration to the database
     * @return string
     */
    function up(): string;

    /**
     * used to down a migration to the database
     * @return string
     */
    function down(): string;

}