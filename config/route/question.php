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
        [
            "info" => "question comments index.",
            "requestMethod" => "get",
            "path" => "comments/{id:digit}",
            "callable" => ["questionController", "getQuesComments"],
        ],
        [
            "info" => "question comments index.",
            "requestMethod" => "get",
            "path" => "comment/answer/{id:digit}",
            "callable" => ["questionController", "getComComments"],
        ],
        [
            "info" => "create question",
            "requestMethod" => "get|post",
            "path" => "create",
            "callable" => ["questionController", "question2Create"],
        ],
    ]
];
