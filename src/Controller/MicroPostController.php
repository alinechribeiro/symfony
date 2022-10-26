<?php

namespace App\Controller;

use DateTime;
use App\Entity\MicroPost;
use App\Form\MicroPostType;
use App\Repository\MicroPostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MicroPostController extends AbstractController
{
    #[Route('/micro-post', name: 'app_micro_post')]
    public function index(MicroPostRepository $posts): Response
    {
        // $microPost = new MicroPost();
        // $microPost->setTitle('It comes from controller');
        // $microPost->setText('HiHey');
        // $microPost->setCreated(new DateTime());

        // $microPost = $posts->find(8);
        // $microPost->setTitle('Welcome in general!');
        // $posts->save($microPost, true);
        // $posts->remove($microPost, true);
        // dd($posts->findBy(5));
        // dd($posts->findAll());
        return $this->render('micro_post/index.html.twig', [
            'posts' => $posts->findAll(),
        ]);
    }

    #[Route('/micro-post/{post}', name: 'app_micro_post_show')]
    public function showOne(MicroPost $post): Response 
    {
        return $this->render('micro_post/show.html.twig', [
            'post' => $post,
        ]);
    }

    #[Route('/micro-post/add', name: 'app_micro_post_add', priority: 2)]
    public function add(Request $request, MicroPostRepository $posts): Response
    {
        $form = $this->createForm(MicroPostType::class, new MicroPost());

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $post = $form->getData();
            $post->setCreated(new DateTime());
            $posts->add($post, true);

            // Add a flash message
            $this->addFlash('success', 'Your micro post has been added.');

            // Redirect for different page
            return $this->redirectToRoute('app_micro_post');
        }
        return $this->renderForm(
            'micro_post/add.html.twig', 
            [
                'form' => $form
            ]
        );
    }


    #[Route('/micro-post/{post}/edit', name: 'app_micro_post_edit')]
    public function edit(MicroPost $post, Request $request, MicroPostRepository $posts): Response
    {
        $form = $this->createForm(MicroPostType::class,  $post);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $post = $form->getData();
            $posts->add($post, true);

            // Add a flash message
            $this->addFlash('success', 'Your micro post has been updated.');

            // Redirect for different page
            return $this->redirectToRoute('app_micro_post');
        }
        return $this->renderForm(
            'micro_post/edit.html.twig', 
            [
                'form' => $form
            ]
        );
    }
}
