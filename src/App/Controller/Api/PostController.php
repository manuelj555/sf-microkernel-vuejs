<?php
/*
 * This file is part of the Manuel Aguirre Project.
 *
 * (c) Manuel Aguirre <programador.manuel@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Api;

use Blog\Post;
use Blog\Form\Type\PostType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @author Manuel Aguirre <programador.manuel@gmail.com>
 *
 * @Route("/api/posts")
 */
class PostController extends Controller
{
    /**
     * @Route("/", name="api_post_list")
     * @Method("GET")
     */
    public function listAction(Request $request)
    {
        $page = $request->get('page', 1);
        $perPage = 10;
        $limit = ($page - 1) * $perPage;
        $limit = $limit < 0 ? 0 : $limit;

        $posts = $this->get('repository.post')->findAll($limit, $perPage);
        $posts = $this->get('serializer')->normalize($posts, 'array');

        $count = $this->get('repository.post')->countAll();
        
        return new JsonResponse($posts, 200, [
            'X-Total-Count' => $count,
        ]);
    }

    /**
     * @Route("/", name="api_post_create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $post = new Post($this->getUser());

        $this->get('serializer')->deserialize(
            $request->getContent(), 
            Post::class,
            'json',
            ['object_to_populate' => $post]
        );
        
        $this->get('repository.post')->add($post);

        return new JsonResponse(
            $this->get('serializer')->normalize($post, 'array')
        );
    }

    /**
     * @Route("/{id}", name="api_post_update")
     * @Method("PUT")
     */
    public function updateAction(Request $request, $id)
    {
        $post = $this->get('repository.post')->find($id);

        $this->get('serializer')->deserialize(
        	$request->getContent(), 
        	Post::class,
        	'json',
        	['object_to_populate' => $post]
    	);
        
        $this->get('repository.post')->update($post);

        return new JsonResponse(
            $this->get('serializer')->normalize($post, 'array')
        );
    }
}