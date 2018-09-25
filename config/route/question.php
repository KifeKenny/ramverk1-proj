<?php
/**
 * Routes for questionController.
 */
return [
    "routes" => [
        [
            "info" => "question Controller index.",
            "requestMethod" => "get",
            "path" => "",
            "callable" => ["questionController", "getIndex"],
        ],
    ]
];
