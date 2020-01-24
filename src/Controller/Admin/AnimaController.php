<?php

namespace App\Controller\Admin;

// system
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

// entity / repository
use App\Repository\AnimeRepository;
use App\Repository\AnimeImportedRepository;
use App\Entity\Anime;
use App\Entity\AnimeImported;

// services
use Jikan\Jikan;
use App\Service\Paginator;

// utils
use App\Utils\Formatter;


class AnimaController extends AbstractController
{
    /**
     * @Route("/admin/anime", name="anime_list")
     */
    public function index(AnimeRepository $ar,AnimeImportedRepository $air,Request $request)
    {
        
        // $_GET page
        $page = $request->query->get('page','1');
        
        // query # $entityManager = $this->getDoctrine()->getManager();
        $animeList = $ar->baseList($page);

        // paginator
        $paginator = new Paginator( $animeList['total'], $request->query->all() );
        $paginator->setPath('anime_list');

        // retorna valores
        return $this->render('admin/anime_list.html.twig', [
            'animes' => $animeList,
            'imported' => $air->findAll(),
            'animePaginator' => $paginator->generate(),
        ]);

    }

    /**
     * @Route("/admin/anime/import", name="anime_import")
     */
    public function importSeason(Jikan $jikan,Request $request,AnimeRepository $ar,AnimeImportedRepository $air# Formatter $formatter
    )
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

                    // format date
                    $aired = Formatter::ImmutableToTimestamp( $anime->getAiringStart() );

                    // create or update
                    $animeEntity = $ar->findOneBy([ 'mal_id' => $id ]);
                    $animeEntity = $animeEntity ?: new Anime();

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
                    $animeEntity->setAired( $aired );
                    $animeEntity->setSeason( $season );
                    $animeEntity->setYear( $year );

                    // persist
                    $em->persist($animeEntity);

                }

                // salva
                $em->flush();
            
            // register log
                
                // registra dados
                $imported = $air->findOneBy(['season'=>$season,'year'=>$year]);
                $imported = $imported ?: new AnimeImported();
                $imported->setSeason($season);
                $imported->setYear($year);

                // caso nao existe persiste dados
                if(!$imported->getId()){ $em->persist($imported); }

                // salva
                echo $em->getUnitOfWork()->getEntityState($imported);
                echo "\n";
                echo $em->getUnitOfWork()->getEntityState($animeEntity);
                $em->flush();

            // retorno
            $return = ['success'=> true,'data'=>[]];
        }

    	return $this->json($return);
    }



}
