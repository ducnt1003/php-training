<?php

namespace App\Services;

use App\Repositories\Post\PostRepositoryInterface;
use Illuminate\Http\Request;

class PostService
{
    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function create(Request $request)
    {
        $data = [
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'url' => $request->input('url'),
        ];
        if ($data['title'] == "hello")
        {
            $data['title'] = "Hello 111";
        }
        $post = $this->postRepository->create($data);
        return $post;
    }
}
