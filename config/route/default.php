<?php
return [
    "routes" => [
        [
            "info" => "question Controller index.",
            "requestMethod" => "get",
            "path" => "",
            "callable" => ["questionController", "getHome"],
        ],
        [
            "info" => "create comment",
            "requestMethod" => "get|post",
            "path" => "create/{id:digit}/{type:digit}",
            "callable" => ["questionController", "comment2Create"],
        ],
    ]
];
