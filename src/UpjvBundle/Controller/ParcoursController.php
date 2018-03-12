<?php




namespace UpjvBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use UpjvBundle\Entity\Parcours;
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


    if (!$parcours instanceof Parcours) {
      $parcours = new Parcours();
    }

    $form = $this->createForm(ParcoursType::class,$parcours);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        try{
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
        $em->remove($parcours);
        $em->flush();
        $this->get('session')->getFlashBag()->add('success', 'L\'utilisateur a bien été supprimé');
    }catch (\Exception $e){
        $this->get('session')->getFlashBag()->add('erreur', 'Une erreur s\'est produite lors de la suppression');
    }

      return $this->redirectToRoute('admin_parcours');
  }



}
