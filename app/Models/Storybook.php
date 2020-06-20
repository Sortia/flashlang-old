<?php

namespace App\Models;

use Elasticquent\ElasticquentTrait;
use Str;

class Storybook extends BaseModel
{
    use ElasticquentTrait;

    protected $fillable = [
        'text'
    ];

    protected $mappingProperties = [
        'text' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
    ];

    public function translation()
    {
        return $this->hasOne(Translation::class);
    }

    public function shortText()
    {
        return Str::limit($this->text, 250, '...');
    }
}
