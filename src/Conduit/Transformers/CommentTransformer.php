<?php

namespace Conduit\Transformers;

use Conduit\Models\Article;
use Conduit\Models\Comment;
use League\Fractal\ItemResource;
use League\Fractal\TransformerAbstract;

class CommentTransformer extends TransformerAbstract
{

    /**
     * Include resources without needing it to be requested.
     *
     * @var array
     */
    protected $defaultIncludes = [
        'author',
    ];

    public function transform(Comment $comment)
    {
        return [
            'id'        => $comment->id,
            'createdAt' => $comment->created_at->toIso8601String(),
            'updatedAt' => isset($user->update_at) ? $comment->update_at->toIso8601String() : $comment->update_at,
            'body'      => $comment->body,
        ];
    }

    /**
     * Include Author
     *
     * @param \Conduit\Models\Comment $comment
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeAuthor(Comment $comment)
    {
        $author = $comment->user;

        return $this->item($author, new AuthorTransformer());
    }
}