<?php declare(strict_types=1);

namespace Org\Controller;

use Arc\Framework\Controller;
use Arc\Validator\ModelValidator;
use Org\Repository\PostRepository;
use Org\Model\Post;
use Arc\Http\Request;
use Arc\View\View;

class PostsController extends Controller
{
    private PostRepository $repository;

    public function __construct(Request $request, View $view)
    {
        parent::__construct($request, $view);
        $this->repository = new PostRepository();
        $this->view->setLayout('layout');
    }

    public function index(): string
    {
        $posts = $this->repository->findAll();
        return $this->render('posts/index', ['posts' => $posts]);
    }

    public function viewPost(int $id): string
    {
        $post = $this->repository->getById($id);

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
        $post = $this->repository->getById($id);
        if ($post === null) {
            throw new \RuntimeException('Post not found for ID: ' . $id);
        }
        return $this->handleForm($post, 'edit');
    }

    public function delete(int $id): string
    {
        $this->repository->deletePost($id);
        header('Location: /posts');
        return '';
    }

    private function handleForm(Post $post, string $templateName): string
    {
        $errors = [];

        if ($this->request->isPost() &&
            $post->load($this->request->post()) &&
            empty($errors = (new ModelValidator())->validate($post))
        ) {
            $this->repository->save($post);
            header('Location: /posts');
            
            return '';
        }

        return $this->render('posts/' . $templateName, ['errors' => $errors, 'post' => $post]);
    }
}
