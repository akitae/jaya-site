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

class PolesDeCompetenceParcoursController extends Controller
{

   /**
  * @param $id
  * @param $request
  * @return mixed
  * @Route("/admin/poledecompetenceParcours/poledecompetenceParcours/{id}", name="admin_poledecompetenceParcours_edit")
  */
  public function updateAction($id,Request $request)
  {
    $em = $this->getDoctrine()->getManager();
    /** @var Parcours $user */
    $parcours = $em->getRepository(Parcours::class)->find($id);
    $matiereSelectedInParcours = $em->getRepository(MatiereParcours::class)->findBy(['parcours'=> $parcours]);

    /** @var MatiereParcours $matiereSelect */
      foreach ($matiereSelectedInParcours as $matiereSelect){
          /** @var Matiere $matieres */
          $matieres = $matiereSelect->getMatieres();
          if($matieres->getPoleDeCompetence() !== null ){
              $listPoleDeCompetence[] = $matieres->getPoleDeCompetence();
          }
    }
    $listPoleDeCompetence = array_unique($listPoleDeCompetence);

      $listPoles = $em->getRepository(PoleDeCompetenceParcours::class)->findBy(['parcours'=> $parcours]);

        if (!empty($_POST)) {
            try{
                foreach ($_POST as $name => $nbr){
                    $idPole = explode('_',$name);
                    $pole = $em->getRepository(PoleDeCompetence::class)->find($idPole[1]);
                    $poleDeCompetenceParcours = $em->getRepository(PoleDeCompetenceParcours::class)->findOneBy([
                        'parcours' => $parcours,
                        'poleDeCompetence' => $pole
                    ]);

                    if(!$poleDeCompetenceParcours instanceof PoleDeCompetenceParcours){
                        $poleDeCompetenceParcours = new PoleDeCompetenceParcours();
                    }

                    $poleDeCompetenceParcours->setParcours($parcours);
                    $poleDeCompetenceParcours->setNbrMatiereOptionnelle($nbr);
                    $poleDeCompetenceParcours->setPoleDeCompetence($pole);

                    $em->persist($poleDeCompetenceParcours);
                }
                $em->flush();
                $this->get('session')->getFlashBag()->add('success', 'Le parcours a bien été enregistré.');
                }catch (\Exception $e){
                    $this->get('session')->getFlashBag()->add('erreur', 'Une erreur s\'est produite lors de l\'enregistrement.');
                    return $this->redirectToRoute('admin_parcours_edit',['id' => $id]);
                }

            return $this->redirectToRoute('admin_parcours');
        }

        return $this->render('UpjvBundle:Admin/PolesDeCompetenceParcours:update.html.twig',[
            'parcours' => $parcours,
            'poleDeCompetence' => $listPoleDeCompetence,
            'listPoles' => $listPoles
        ]);
  }
}
