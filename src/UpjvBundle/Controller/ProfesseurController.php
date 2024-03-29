<?php
/**
 * Created by PhpStorm.
 * Professeur: Akitae
 * Date: 21/02/2018
 * Time: 09:58
 */

namespace UpjvBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use UpjvBundle\Entity\Utilisateur;
use UpjvBundle\Form\ProfesseurType;

class ProfesseurController extends Controller
{
    /**
     * @Route("/admin/professeur", name="admin_professeur")
     * @return mixed
     */
    public function indexAction()
    {
        $listProfesseur = $this->getDoctrine()->getRepository(Utilisateur::class)->findByRole([Utilisateur::ROLE_PROFESSEUR,Utilisateur::ROLE_ADMIN,Utilisateur::ROLE_SUPER_ADMIN]);

        return $this->render('UpjvBundle:Admin/Professeur:index.html.twig',[
            'listProfesseur' => $listProfesseur
        ]);
    }

    /**
     * @param $id
     * @param $request
     * @return mixed
     * @Route("/admin/professeur/edit/{id}", name="admin_professeur_edit")
     */
    public function updateAction($id,Request $request)
    {
        $isNew = false;
        $userManager = $this->get('fos_user.user_manager');
        $em = $this->getDoctrine()->getManager();
        /** @var Utilisateur $professeur */
        $professeur = $em->getRepository(Utilisateur::class)->find($id);

        if (!$professeur instanceof Utilisateur) {
            $professeur = new Utilisateur();
            $isNew = true;
        }

        $form = $this->createForm(ProfesseurType::class,$professeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try{
                $professeur = $form->getData();

                if ($isNew && $professeur->getPlainPassword() === null) {
                    $professeur->setPassword("jayaProfesseur");
                    $professeur->setPlainPassword("jayaProfesseur");
                    $professeur->addRole(Utilisateur::ROLE_PROFESSEUR);
                }

                $userManager->updateUser($professeur);
                $this->get('session')->getFlashBag()->add('success', 'Le professeur a bien été enregistré.');
            }catch (\Exception $e){
                $this->get('session')->getFlashBag()->add('erreur', 'Une erreur s\'est produite lors de l\'enregistrement.'.$e->getMessage());
                return $this->redirectToRoute('admin_professeur_edit',['id' => $id]);
            }

            return $this->redirectToRoute('admin_professeur');
        }

        return $this->render('UpjvBundle:Admin/Professeur:update.html.twig',[
            'professeur' => $professeur,
            'form' => $form->createView(),
            'isNew' => $isNew
        ]);
    }

    /**
     * @param $id
     * @Route("/admin/professeur/show/{id}", name="admin_professeur_show")
     * @return mixed
     */
    public function showAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $professeur = $em->getRepository(Utilisateur::class)->find($id);

        if (!$professeur instanceof Utilisateur) {
            $this->get('session')->getFlashBag()->add('erreur', 'Le professeur selectionné n\'a pas été trouvé');
            return $this->redirectToRoute('admin_professeur');
        }

        return $this->render('UpjvBundle:Admin/Professeur:show.html.twig',[
            'professeur' => $professeur
        ]);
    }

    /**
     * @param $id
     * @Route("/admin/professeur/delete/{id}", name="admin_professeur_delete")
     * @return mixed
     */
    public function deleteAction($id){
        $em = $this->getDoctrine()->getManager();
        try {
            $professeur = $em->getRepository(Utilisateur::class)->find($id);
            $em->remove($professeur);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'L\'utilisateur a bien été supprimé');
        }catch (\Exception $e){
            $this->get('session')->getFlashBag()->add('erreur', 'Une erreur s\'est produite lors de la suppression');
        }

        return $this->redirectToRoute('admin_professeur');
    }
}
