<?php
/**
 * Configuration file for routes.
 */
return [
    // Load these routefiles in order specified and optionally mount them
    // onto a base route.
    "routeFiles" => [
        [
            // These are for internal error handling and exceptions
            "mount" => null,
            "file" => __DIR__ . "/route/internal.php",
        ],
        [
            // For debugging and development details on Anax
            "mount" => "debug",
            "file" => __DIR__ . "/route/debug.php",
        ],
        [
            // To read flat file content in Markdown from content/
            "mount" => null,
            "file" => __DIR__ . "/route/flat-file-content.php",
        ],
        [
            // Add route home
            "mount" => null,
            "file" => __DIR__ . "/route/default.php",
        ],
        [
            // Add routes users
            "mount" => "user",
            "file" => __DIR__ . "/route/userController.php",
        ],
        [
            "mount" => "question",
            "file" => __DIR__ . "/route/question.php",
        ],
    ],
];
