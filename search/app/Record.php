<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use ScoutElastic\Searchable;

class Record extends Model
{
    use Searchable;
    protected $table="records";
    public $timestamps=false;

    /**
     * @var string
     */
    protected $indexConfigurator = MyIndexConfigurator::class;

    /**
     * @var array
     */
    protected $searchRules = [
        //
    ];

    /**
     * @var array
     */
    protected $mapping = [
        'properties' => [
            'suggest' => [
                'type' => 'completion',
            ],
            'link' => [
                'type' => 'keyword',
            ],
            'title' => [
                'type' => 'text',
            ],
            'company' => [
                'type' => 'text',
            ],
            'city' => [
                'type' => 'text',
            ],
            'time' => [
                'type' => 'text',
            ],
        ]
    ];
}
