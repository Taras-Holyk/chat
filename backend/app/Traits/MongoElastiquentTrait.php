<?php

namespace App\Traits;

use Elasticquent\ElasticquentTrait;
use Exception;

trait MongoElastiquentTrait
{
    use ElasticquentTrait {
        ElasticquentTrait::addAllToIndex as parentAddAllToIndex;
    }

    public static function addAllToIndex()
    {
        $instance = new static;
        $all = $instance->newQuery()->get(['*']);

        $all->transform(function ($item) {
            $item->id = $item->_id;
            unset($item->_id);

            return $item;
        });


        return $all->addToIndex();
    }

    public function addToIndex()
    {
        if (!$this->exists) {
            throw new Exception('Document does not exist.');
        }

        $params = $this->getBasicEsParams();

        $params['body'] = $this->getIndexDocumentData();

        if (isset($params['body']['_id'])) {
            $params['body']['id'] = $params['body']['_id'];
            unset($params['body']['_id']);
        }
        $params['id'] = $this->getKey();

        return $this->getElasticSearchClient()->index($params);
    }
}