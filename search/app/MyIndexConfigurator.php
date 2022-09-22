<?php

namespace App;

use ScoutElastic\IndexConfigurator;
use ScoutElastic\Migratable;

class MyIndexConfigurator extends IndexConfigurator
{
    use Migratable;
    // It's not obligatory to determine name. By default it'll be a snaked class name without `IndexConfigurator` part.
    protected $name = 'my_index';

    // You can specify any settings you want, for example, analyzers.
    protected $settings = [
        "analysis" => [
            "char_filter" => [
                "zero_width_spaces" => [
                    "type" => "mapping",
                    "mappings" => ["\\u200C=>\\u0020"]
                ]
            ],
            "filter" => [
                "persian_stop" => [
                    "type" => "stop",
                    "stopwords" => "_persian_"
                ]
            ],
            "analyzer" => [
                "rebuilt_persian" => [
                    "tokenizer" => "standard",
                    "char_filter" => ["zero_width_spaces"],
                    "filter" => [
                        "lowercase",
                        "decimal_digit",
                        "arabic_normalization",
                        "persian_normalization",
                        "persian_stop"
                    ]
                ]
            ]
        ]
    ];
}
