<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(protected PostService $postService)
    {
    }


    public function index(): JsonResponse
    {
        $posts = $this->postService->getAllPosts();
        return response()->json($posts);
    }

    public function show($id): JsonResponse
    {
        $post = $this->postService->getPostById($id);
        return response()->json($post);
    }

    public function store(PostStoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $post = $this->postService->createPost($data);
        return response()->json($post, 201);
    }

    public function update(PostUpdateRequest $request, $id): JsonResponse
    {
        $data = $request->validated();
        $post = $this->postService->updatePost($id, $data);
        return response()->json($post);
    }

    public function destroy($id): JsonResponse
    {
        $this->postService->deletePost($id);
        return response()->json(['message' => 'Post deleted successfully']);
    }
}
