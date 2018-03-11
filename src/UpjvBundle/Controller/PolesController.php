<?php




namespace UpjvBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use UpjvBundle\Entity\PoleDeCompetence;
use UpjvBundle\Form\PoleDeCompetenceType;

class PolesController extends Controller
{

  /**
  * @Route("/admin/pole", name="admin_pole")
  * @return mixed
  */
  public function indexAction()
  {
    $listPole = $this->getDoctrine()->getRepository(PoleDeCompetence::class)->findAll();

    return $this->render('UpjvBundle:Admin/Poles:index.html.twig',[
      'listPole' => $listPole
    ]);
  }

  /**
  * @param $id
  * @param $request
  * @return mixed
  * @Route("/admin/pole/pole/{id}", name="admin_pole_edit")
  */
  public function updateAction($id,Request $request)
  {
    $em = $this->getDoctrine()->getManager();
    /** @var Poledecompetence $user */
    $pole = $em->getRepository(PoleDeCompetence::class)->find($id);
    $listPole = $this->getDoctrine()->getRepository(PoleDeCompetence::class)->findAll();

    if (!$pole instanceof PoleDeCompetence) {
      $pole = new PoleDeCompetence();
    }

    $form = $this->createForm(PoleDeCompetenceType::class,$pole);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $pole = $form->getData();
      $em->persist($pole);
      $em->flush();

      $listParcours = $this->getDoctrine()->getRepository(Parcours::class)->findAll();

      return $this->render('UpjvBundle:Admin/Poles:index.html.twig',[
        'updateResponse' => true,
        'listPole' => $listPole

      ]);
    }

    return $this->render('UpjvBundle:Admin/Poles:update.html.twig',[
      'pole' => $pole,
      'form' => $form->createView()
    ]);

  }

  /**
  * @param $id
  * @Route("/admin/pole/show/{id}", name="admin_pole_show")
  * @return mixed
  */
  public function showAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $pole = $em->getRepository(PoleDeCompetence::class)->find($id);

    if (!$pole instanceof PoleDeCompetence) {
      die('error : ce pole de competence n\'existe pas');
    }

    return $this->render('UpjvBundle:Admin/Poles:show.html.twig',[
      'pole' => $pole
    ]);

  }

  /**
  * @param $id
  * @Route("/admin/pole/delete/{id}", name="admin_pole_delete")
  * @return mixed
  */
  public function deleteAction($id){
    $em = $this->getDoctrine()->getManager();
    $pole = $em->getRepository(PoleDeCompetence::class)->find($id);
    $em->remove($pole);
    $em->flush();

    $listPole = $this->getDoctrine()->getRepository(PoleDeCompetence::class)->findAll();

    return $this->render('UpjvBundle:Admin/Poles:index.html.twig',[
      'listPole' => $listPole,
      'deleteResponse' => true
    ]);
  }



}
