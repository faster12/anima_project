<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\AnimeRepository;
use App\Repository\AnimeImportedRepository;
use App\Entity\Anime;
use App\Entity\AnimeImported;
use Jikan\Jikan;

class AnimaController extends AbstractController
{
    /**
     * @Route("/admin/anime", name="anime_list")
     */
    public function index(AnimeRepository $ar,AnimeImportedRepository $air )
    {
        // $entityManager = $this->getDoctrine()->getManager();

        return $this->render('admin/anime_list.html.twig', [
            'animes' => $ar->findAll(),
            'imported' => $air->findAll(),
        ]);
    }

    /**
     * @Route("/admin/anime/import", name="anime_import")
     */
    public function importSeason(Jikan $jikan, Request $request,AnimeRepository $ar, AnimeImportedRepository $air)
    {

        // get data
        $season = $request->request->get('season');
        $year = $request->request->get('year');
        
        // message
        $return = ['success'=>false,'message'=>'ops.. ocorreu um erro'];

        // list all animes form season
        if( $season && $year ){
            
            // get the manager
            $em = $this->getDoctrine()->getManager();

            // save data 

                // season e year
                $a = $jikan->Seasonal($year,$season);
                
                // le e salva dados
                foreach($a->anime as $k => $anime){
                                    
                    // id do mal
                    $id = $anime->getMalId();

                    // create or update
                    $animeEntity = $ar->findOneBy([ 'mal_id' => $id ]);
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
                    $animeEntity->setEpisodes( $anime->getEpisodes() );
                    $animeEntity->setSource( $anime->getSource()  );
                    $animeEntity->setMalMembers( $anime->getMembers() );
                    
                    $animeEntity->setSeason( $season );
                    $animeEntity->setYear( $year );
                    
                    // persist
                    $em->persist($animeEntity);

                }

                // save the entries
                $em->flush();
            

            // register log
                $imported = $air->findOneBy(['season'=>$season,'year'=>$year]);
                if(!$imported){
                    $imported = new AnimeImported();
                }

                // registra dados
                $imported->setSeason($season);
                $imported->setYear($year);

                // save the entries
                if(!$imported->getId()){
                    $em->persist($imported);
                }

                $em->flush();

            // retorno
            $return = ['success'=> true,'data'=>[]];
        }

    	return $this->json($return);
    }
}
