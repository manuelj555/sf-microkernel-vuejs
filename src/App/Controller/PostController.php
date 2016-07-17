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

use Blog\Form\Type\PostType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
        $form = $this->createForm(PostType::class, null, [
            'author' => $this->getUser(),
        ]);
        $form->handleRequest($request);

        if (!$form->isSubmitted() or !$form->isValid()) {
            return $this->render('post/create.html.twig', [
                'form' => $form->createView(),
            ]);
        }

        $this->get('repository.post')->add($form->getData());
        $this->addFlash('success', 'Post creado con exito');

        return $this->redirectToRoute('post_create');
    }
}