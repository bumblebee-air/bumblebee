<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Elasticquent\ElasticquentTrait;

class Keyword extends Model
{
    use ElasticquentTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['keyword', 'weight', 'audio', 'support_type_id'];

    /**
     * Mapping with Elastic search service.
     *
     * @var array
     */
    protected $mappingProperties = array(
        'id' => [
            'type' => 'integer'
        ],
        'keyword' => [
            'type' => 'text',
            "analyzer" => "standard"
        ],
        'weight' => [
            'type' => 'integer'
        ],
    );

    /**
     * Use to get the index name.
     *
     * @return string index
     */
    public function getIndexName()
    {
        return 'keywords';
    }

    public function supportType()
    {
        return $this->hasOne('App\SupportType', 'id', 'support_type_id');
    }
}
