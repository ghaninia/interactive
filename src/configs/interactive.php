<?php

return [
    "cache" => [
        "default" => "file",
        "drivers" => [
            "file" => [
                "extension" => ".txt",
                "ttl" => 3600,
                "cache_dir" => storage_path("interactive-terminal"),
            ],
        ]
    ]
];

