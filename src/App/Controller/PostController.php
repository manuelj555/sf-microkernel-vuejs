<?php
/*
 * This file is part of the Manuel Aguirre Project.
 *
 * (c) Manuel Aguirre <programador.manuel@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use Blog\Post;
use Blog\Form\Type\PostType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @author Manuel Aguirre <programador.manuel@gmail.com>
 *
 * @Route("/post")
 */
class PostController extends Controller
{
    /**
     * @Route("/list", name="post_list")
     */
    public function listAction()
    {
        $posts = $this->get('repository.post')->findAll();

        return $this->render('post/list.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * @Route("/create", name="post_create")
     */
    public function createAction(Request $request)
    {
        $form = $this->createForm(PostType::class, new Post($this->getUser()));
        $form->handleRequest($request);

        if (!$form->isSubmitted() or !$form->isValid()) {
            return $this->render('post/create.html.twig', [
                'form' => $form->createView(),
            ]);
        }

        $this->get('repository.post')->add($form->getData());
        $this->addFlash('success', 'Post creado con exito');

        return $this->redirectToRoute('post_list');
    }

    /**
     * @Route("/edit/{id}", name="post_edit")
     */ 
    public function editAction(Request $request, $id)
    {
        $post = $this->get('repository.post')->find($id);
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if (!$form->isSubmitted() or !$form->isValid()) {
            return $this->render('post/edit.html.twig', [
                'form' => $form->createView(),
                'post' => $post,
            ]);
        }

        $this->get('repository.post')->update($post);
        $this->addFlash('success', 'Post editado con exito');

        return $this->redirectToRoute('post_list');
    }
}