<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\AnimeRepository;
use App\Entity\Anime;
use Jikan\Jikan;

class AnimaController extends AbstractController
{
    /**
     * @Route("/admin/anime", name="anime_list")
     */
    public function index(AnimeRepository $animeRepository)
    {

        // $entityManager = $this->getDoctrine()->getManager();

        return $this->render('admin/anime_list.html.twig', [
            'animes' => $animeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/anime/import", name="anime_import")
     */
    public function importSeason(Jikan $jikan, Request $request,AnimeRepository $animeRepository)
    {

        // get data
        $season = $request->request->get('season');
        $year = $request->request->get('year');
        
        // message
        $return = ['success'=>false,'message'=>'ops.. ocorreu um erro'];

        // list all animes form season
        if( $season && $year ){
            
            // season e year
            $a = $jikan->Seasonal($year,$season);

            // get the manager
            $em = $this->getDoctrine()->getManager();
        
            // set array
            $save = [];

            // get the entity

            foreach($a->anime as $k => $anime){
                                
                // id do mal
                $id = $anime->getMalId();

                // create or update
                $animeEntity = $animeRepository->findOneBy([ 'mal_id' => $id ]);
                if(!$animeEntity){
                    $animeEntity = new Anime();
                }

                // set data
                $animeEntity->setMalId( $id );
                $animeEntity->setScore( $anime->getScore() ); 
                $animeEntity->setTitle( $anime->getTitle() );
                $animeEntity->setImage( $anime->getImageURL() );
                $animeEntity->setType( $anime->getType() );
                $animeEntity->setDescription( $anime->getSynopsis() );
                $animeEntity->setSeason( $season );
                $animeEntity->setYear( $year );
                
                // persist
                $em->persist($animeEntity);

            }

            // save the entries
            $em->flush();

            $return = ['success'=> true,'data'=>['imported'=>$save]];
        }

    	return $this->json($return);
    }
}
