<?php

namespace Conduit\Transformers;

use Conduit\Models\Article;
use League\Fractal\TransformerAbstract;

class ArticleTransformer extends TransformerAbstract
{

    /**
     * Include resources without needing it to be requested.
     *
     * @var array
     */
    protected $defaultIncludes = [
        'author',
    ];

    public function transform(Article $article)
    {
        return [
            "slug"           => $article->slug,
            "title"          => $article->title,
            "description"    => $article->description,
            "body"           => $article->body,
            "tagList"        => optional($article->tags()->get(['title']))->pluck('title'),
            'createdAt'      => $article->created_at->toIso8601String(),
            'updatedAt'      => isset($user->update_at) ? $article->update_at->toIso8601String() : $article->update_at,
            "favorited"      => false,
            "favoritesCount" => 0,
        ];
    }


    /**
     * Include Author
     *
     * @param \Conduit\Models\Article $article
     *
     * @return \League\Fractal\Resource\Item
     * @internal param \Conduit\Models\Comment $comment
     *
     */
    public function includeAuthor(Article $article)
    {
        $author = $article->user;

        return $this->item($author, new AuthorTransformer());
    }

}