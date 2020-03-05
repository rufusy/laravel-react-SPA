<?php

namespace App\Http\Resources;

use App\Article;
use App\Http\Resources\ApiResourceCollection;
use App\Http\Resources\ArticleResource;


class ArticleCollection extends ApiResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // Transform the collection to match format in ArticleResource.
        $this->collection->transform(function(Article $article){
            return (new ArticleResource($article));
        });
        
        return [
            'data' => $this->collection,
            'meta' => ['article_count' => $this->collection->count()],
        ];
    }
}
