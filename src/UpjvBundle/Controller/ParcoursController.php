<?php




namespace UpjvBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use UpjvBundle\Entity\Matiere;
use UpjvBundle\Entity\MatiereParcours;
use UpjvBundle\Entity\Parcours;
use UpjvBundle\Entity\PoleDeCompetence;
use UpjvBundle\Entity\PoleDeCompetenceParcours;
use UpjvBundle\Form\ParcoursType;

class ParcoursController extends Controller
{

  /**
  * @Route("/admin/parcours", name="admin_parcours")
  * @return mixed
  */
  public function indexAction()
  {
    $listParcours = $this->getDoctrine()->getRepository(Parcours::class)->findAll();

    return $this->render('UpjvBundle:Admin/Parcours:index.html.twig',[
      'listParcours' => $listParcours
    ]);
  }

  /**
  * @param $id
  * @param $request
  * @return mixed
  * @Route("/admin/parcours/parcours/{id}", name="admin_parcours_edit")
  */
  public function updateAction($id,Request $request)
  {
    $em = $this->getDoctrine()->getManager();
    /** @var Parcours $user */
    $parcours = $em->getRepository(Parcours::class)->find($id);
    $matieresForParcours = $em->getRepository(MatiereParcours::class)->findBy(['parcours'=>$parcours]);
    $polesDeCompetences = $em->getRepository(PoleDeCompetence::class)->findAll();
    $matiereForParcours = null;
    /** @var MatiereParcours $mp */
      foreach ($matieresForParcours as $matiereP){
        $matiereForParcours[$matiereP->getMatieres()->getId()] = $matiereP->isOptionnel();

    }


    if (!$parcours instanceof Parcours) {
      $parcours = new Parcours();
    }

    $form = $this->createForm(ParcoursType::class,$parcours);
    $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try{
                /** @var Parcours $parcours */
                $parcours = $form->getData();
                    $em->persist($parcours);
                    $em->flush();
                    $this->get('session')->getFlashBag()->add('success', 'Le parcours a bien été enregistré.');
                }catch (\Exception $e){
                    $this->get('session')->getFlashBag()->add('erreur', 'Une erreur s\'est produite lors de l\'enregistrement.');
                    return $this->redirectToRoute('admin_parcours_edit',['id' => $id]);
                }

            return $this->redirectToRoute('admin_parcours');
        }

        return $this->render('UpjvBundle:Admin/Parcours:update.html.twig',[
            'parcours' => $parcours,
            'matiereForParcours' => $matiereForParcours,
            'polesDeCompetences' => $polesDeCompetences,
            'form' => $form->createView()
        ]);

  }

  /**
  * @param $id
  * @Route("/admin/parcours/show/{id}", name="admin_parcours_show")
  * @return mixed
  */
  public function showAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $parcours = $em->getRepository(Parcours::class)->find($id);

    if (!$parcours instanceof Parcours) {
        $this->get('session')->getFlashBag()->add('erreur', 'Le parcours selectionné n\'existe pas');
        return $this->redirectToRoute('admin_parcours');
    }

    return $this->render('UpjvBundle:Admin/Parcours:show.html.twig',[
        'parcours' => $parcours
    ]);

  }

  /**
  * @param $id
  * @Route("/admin/parcours/delete/{id}", name="admin_parcours_delete")
  * @return mixed
  */
  public function deleteAction($id){
    $em = $this->getDoctrine()->getManager();
    try{
        $parcours = $em->getRepository(Parcours::class)->find($id);
        $paroursPoleDeCompetence = $em->getRepository(PoleDeCompetenceParcours::class)->findBy(['parcours' => $parcours]);
        foreach ($paroursPoleDeCompetence as $pole){
            $em->remove($pole);
        }
        $em->remove($parcours);
        $em->flush();
        $this->get('session')->getFlashBag()->add('success', 'L\'utilisateur a bien été supprimé');
    }catch (\Exception $e){
        $this->get('session')->getFlashBag()->add('erreur', 'Une erreur s\'est produite lors de la suppression');
    }

      return $this->redirectToRoute('admin_parcours');
  }

    /**
     * @param $id
     * @param $request
     * @return mixed
     * @Route("/admin/parcours/parcours/matiere/{id}", name="admin_parcours_matiere_edit")
     */
    public function addMatiereAction($id,Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $allMatiere = $em->getRepository(Matiere::class)->findAllToArray();
        $parcours = $em->getRepository(Parcours::class)->find($id);

        $matiereParcours = $em->getRepository(MatiereParcours::class)->findBy(['parcours'=>$parcours]);
        $listMatiere = $listOptionnel = [];
        foreach ($matiereParcours as $mp){
            $matiereListe = $mp->getMatieres();
            $listMatiere [] = $matiereListe->getId();
            if($mp->getOptionnel() === true){
                $listOptionnel [] = $matiereListe->getId();
            }
        }

        if (!empty($_POST)) {
            try{
                $matiereParcours = $em->getRepository(MatiereParcours::class)->findBy(['parcours'=>$parcours]);

                foreach ($matiereParcours as $mp) {
                    $em->remove($mp);
                }
                $em->flush();
                /** @var Matiere $matiere */
                foreach ($allMatiere as $matiere){
                    if(in_array($matiere->getId(),$_POST['matieres'])) {
                        $matiereParcoursNew = new MatiereParcours();
                        $matiereParcoursNew->setMatieres($matiere);
                        $matiereParcoursNew->setParcours($parcours);
                        if($_POST['matiereOptionnelle'] && in_array($matiere->getId(),$_POST['matiereOptionnelle'])){
                            $matiereParcoursNew->setOptionnel(true);
                        }
                        $em->persist($matiereParcoursNew);
                        $em->flush();
                    }
                }

                $this->get('session')->getFlashBag()->add('success', 'Le parcours a bien été enregistré.');
            }catch (\Exception $e){
                $this->get('session')->getFlashBag()->add('erreur', 'Une erreur s\'est produite lors de l\'enregistrement.');
                return $this->render('@Upjv/Admin/Parcours/add-matiere.html.twig',[
                    'allMatieres' => $allMatiere,
                    'parcours' => $id
                ]);
            }

            return $this->redirectToRoute('admin_parcours');
        }

        return $this->render('@Upjv/Admin/Parcours/add-matiere.html.twig',[
            'allMatieres' => $allMatiere,
            'parcours' => $id,
            'listMatiere' => $listMatiere,
            'listOptionnel' => $listOptionnel
        ]);
    }



}
