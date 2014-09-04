<?php

define("DB_DRIVER", "pdo_mysql");
define("DB_USER", "bl2items");
define("DB_PASSWORD", "AxGdtXcS9CS8HEc8");
define("DB_NAME", "bl2items");

define("DEBUG_MODE", true);

define("SECRET_HASH_ALGORITHM", "sha512");

//password hashing

// These constants may be changed without breaking existing hashes.
define("PBKDF2_HASH_ALGORITHM", "sha512");
define("PBKDF2_ITERATIONS", 1000);
define("PBKDF2_SALT_BYTE_SIZE", 24);
define("PBKDF2_HASH_BYTE_SIZE", 24);

define("HASH_SECTIONS", 4);
define("HASH_ALGORITHM_INDEX", 0);
define("HASH_ITERATION_INDEX", 1);
define("HASH_SALT_INDEX", 2);
define("HASH_PBKDF2_INDEX", 3);

?>
