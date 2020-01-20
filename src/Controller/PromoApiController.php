<?php 
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PromoApiController extends AbstractController 
{
    /**
     * @Route("/api/promos", name="api_promo_list")
     */
    public function list()
    {

        return new Response(
            '{"test":2}'
        );
    }

    /**
     * @Route("/api/promos/{id}", name="api_promo_edit")
     */
    public function edit(Request $request)
    {

        // gets
        $a = $request->query->get('teste2');
        
        // posts
        $b = $request->request->get('teste');

        return new Response(
           '{"get":"'.$a.'","post":"'.$b.'"}'
        );
    }

}