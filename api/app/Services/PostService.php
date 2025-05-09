<?php

namespace App\Services;

use App\Repositories\Contracts\PostRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class PostService
{
    protected $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function getAllPosts()
    {
        return $this->postRepository->getAll();
    }

    public function getPostById($id)
    {
        return $this->postRepository->getById($id);
    }

    public function createPost(array $data)
    {
        $data['user_id'] = Auth::id();
        return $this->postRepository->create($data);
    }

    public function updatePost($id, array $data)
    {
        $post = $this->postRepository->getById($id);

        if (!$post) {
            throw new ModelNotFoundException('Post not found');
        }

        if ($post->user_id !== Auth::id()) {
            throw new AccessDeniedHttpException('You do not have permission to edit this post');
        }

        return $this->postRepository->update($id, $data);
    }

    public function deletePost($id)
    {
        $post = $this->postRepository->getById($id);

        if (!$post) {
            throw new ModelNotFoundException('Post not found');
        }

        if ($post->user_id !== Auth::id()) {
            throw new AccessDeniedHttpException('You do not have permission to delete this post');
        }

        return $this->postRepository->delete($id);
    }
}
