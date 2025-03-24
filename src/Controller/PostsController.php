<?php declare(strict_types=1);

namespace Org\Controller;

use Arc\Framework\Controller;
use Arc\Validator\ModelValidator;
use Org\Model\Post;
use Org\Repository\PostRepository;

class PostsController extends Controller
{
    public function index(): string
    {
        $repo = $this->repository(Post::class);
        $posts = $repo->findAll();

        return $this->render('posts/index', ['posts' => $posts]);
    }

    public function viewPost(int $id): string
    {
        $post = $this->postRepository()->findOne($id);
        if ($post === null) {
            throw new \RuntimeException('Post not found for ID: ' . $id);
        }

        return $this->render('posts/view', ['post' => $post]);
    }

    public function add(): string
    {
        return $this->handleForm(new Post, 'add');
    }

    public function edit(int $id): string
    {
        $post = $this->postRepository()->findOne($id);

        return $this->handleForm($post, 'edit');
    }

    public function delete(int $id): string
    {
        $this->postRepository()->delete($id);
        header('Location: /posts');
        return '';
    }

    private function handleForm(Post $post, string $templateName): string
    {
        $errors = [];
        if (
            $this->request->isPost() &&
            $post->load($this->request->post()) &&
            empty($errors = (new ModelValidator())->validate($post))
        ) {
            $this->postRepository()->save($post);
            header('Location: /posts');

            return '';
        }
        return $this->render('posts/' . $templateName, ['errors' => $errors, 'post' => $post]);
    }

    private function postRepository(): PostRepository
    {
        /** @var PostRepository $repo */
        $repo = $this->repository(Post::class);

        return $repo;
    }
}
