<?php
/**
 * Routes for user controller.
 */
 // BookController
return [
    "routes" => [
        [
            "info" => "get all users",
            "requestMethod" => "get",
            "path" => "",
            "callable" => ["userController", "getIndex"],
        ],
        [
            "info" => "get user profile",
            "requestMethod" => "get",
            "path" => "profile/{id:digit}",
            "callable" => ["userController", "getIndexUser"],
        ],
        [
            "info" => "Login a user.",
            "requestMethod" => "get|post",
            "path" => "login",
            "callable" => ["userController", "getPostLogin"],
        ],
        [
            "info" => "Create a user.",
            "requestMethod" => "get|post",
            "path" => "create",
            "callable" => ["userController", "getPostCreateUser"],
        ],
        [
            "info" => "Logout user",
            "requestMethod" => "get",
            "path" => "logout",
            "callable" => ["userController", "logoutUser"],
        ],
        [
            "info" => "Edit profile",
            "requestMethod" => "get|post",
            "path" => "edit",
            "callable" => ["userController", "editProfile"],
        ],
    ]
];
