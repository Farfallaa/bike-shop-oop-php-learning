<?php
/**
 * Created by PhpStorm.
 * User: farfa
 * Date: 02/10/2018
 * Time: 22:03
 */
//keep database CREDENTIALS in a separate file
//1. easy to exclude this file from source code managers
//2. unique credentials on development and production servers
//3. unique credentials if working with multiple developers

define("DB_SERVER", "localhost");
define("DB_USER", "maria");
define("DB_PASS", "maria123");
define("DB_NAME", "chain_gang");

