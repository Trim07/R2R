<?php

namespace Trimcorp\R2r\utils\Interfaces;

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