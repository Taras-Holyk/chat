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

    public static function reindex()
    {
        $instance = new static;
        $all = $instance->newQuery()->get(['*']);

        $all->transform(function ($item) {
            $item->id = $item->_id;
            unset($item->_id);

            return $item;
        });

        return $all->reindex();
    }

    public function addToIndex()
    {
        if (!$this->exists) {
            throw new Exception('Document does not exist.');
        }

        $params = $this->getBasicEsParams();

        // Get our document body data.
        $params['body'] = $this->getIndexDocumentData();

        if (isset($params['body']['_id'])) {
            $params['body']['id'] = $params['body']['_id'];
            unset($params['body']['_id']);
        }

        // The id for the document must always mirror the
        // key for this model, even if it is set to something
        // other than an auto-incrementing value. That way we
        // can do things like remove the document from
        // the index, or get the document from the index.
        $params['id'] = $this->getKey();

        return $this->getElasticSearchClient()->index($params);
    }
}