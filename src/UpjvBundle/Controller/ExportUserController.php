<?php
/**
 * Created by PhpStorm.
 * User: Akitae
 * Date: 21/02/2018
 * Time: 09:58
 */

namespace UpjvBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use UpjvBundle\Entity\Groupe;
use UpjvBundle\Entity\Matiere;
use UpjvBundle\Entity\MatiereParcours;
use UpjvBundle\Entity\Parcours;
use UpjvBundle\Entity\Utilisateur;

class ExportUserController extends Controller
{
    /**
     * @Route("/admin/listUser", name="admin_export_user")
     * @return mixed
     */
    public function indexAction()
    {
        $listUser = $this->getDoctrine()->getRepository(Utilisateur::class)->findByRole(Utilisateur::ROLE_ETUDIANT);

        $listGroup = $this->getDoctrine()->getRepository(Groupe::class)->findAll();
        $listParcours = $this->getDoctrine()->getRepository(Parcours::class)->findAll();
        $listMatieres = $this->getDoctrine()->getRepository(Matiere::class)->findAllToArray();

        $listAnnee = [];
        foreach ($listParcours as $parcour){
            $listAnnee[] = $parcour->getAnnee();
        }
        $listAnnee = array_unique($listAnnee);

        return $this->render('UpjvBundle:Admin/ExportUser:index.html.twig',[
            'listUser' => $listUser,
            'listGroup' => $listGroup,
            'listParcours' => $listParcours,
            'listMatieres' => $listMatieres,
            'listAnnee' => $listAnnee
        ]);
    }

    /**
     * @Route("/admin/listUser/filterGroupe", name="admin_export_user_filter_groupe")
     * Récupère la liste des groupes en fonction de la matière séléctionné
     * @return Response
     */
    public function getListGroupe(){
        $resultGroupe = [];
        $i =0;
        foreach ($_GET as $matiere){
            $listGroup = $this->getDoctrine()->getRepository(Groupe::class)->findAll();


            foreach ($listGroup as $groupe){
                if((string)$groupe->getMatiere() === $matiere){
                    $resultGroupe[] = $groupe->getNom();
                }
                $i++;
            }
        }
        return new Response(json_encode($resultGroupe));
    }

    /**
     * @Route("/admin/listUser/sendData", name="admin_export_user_sendData")
     */
    public function sendData(){
        if(isset($_POST['registrationSheet']))
            return $this->getRegistrationSheet($_POST);
        else if(isset($_POST['exportCSV']))
            return $this->exportCSV($_POST);
        return $this->indexAction();
    }

    /**
     * @param $array
     * @return Response
     */
    public function getRegistrationSheet($array){

        $listUser = $this->getDoctrine()->getRepository(Utilisateur::class)->filterUserByArray($array);

        $html = $this->renderView('UpjvBundle:Admin/ExportUser:registrationSheet.html.twig',[
            'listUser' => $listUser,
            'commentaire' => isset($_POST['commentaireRegistrationSheet'])?$_POST['commentaireRegistrationSheet']:null,
            'listUE' => isset($_POST['matiere'])?$_POST['matiere']:null,
            'listGroupe' => isset($_POST['groupe'])?$_POST['groupe']:null
        ]);
//        $html_header = $this->renderView('UpjvBundle:Admin/ExportUser:registrationSheet-header.html.twig',[
//            'listUser' => $listUser,
//            'commentaire' => isset($_POST['commentaireRegistrationSheet'])?$_POST['commentaireRegistrationSheet']:null,
//            'listUE' => isset($_POST['matiere'])?$_POST['matiere']:null,
//            'listGroupe' => isset($_POST['groupe'])?$_POST['groupe']:null
//        ]);
//
//        $filename = sprintf('Emargement-%s.pdf', date('Y-m-d'));


        $mpdf = $mpdf = new \Mpdf\Mpdf(['tempDir' => __DIR__ . '/tmp']);
        $mpdf->WriteHTML($html,0);
        $mpdf->Output();

//        return new Response(
//            $this->get('knp_snappy.pdf')
//                ->getOutputFromHtml($html,['header-html'=>$html_header])
//            ,
//            200,
//            [
//                'Content-Type'        => 'application/pdf',
//                'Content-Disposition' => sprintf('attachment; filename="%s"', $filename),
//            ]
//        );
    }

    /**
     * @Route("/admin/listUser/exportCSV", name="admin_export_user_csv")
     */
    public function exportCSV($array){
        $col = 0;
        $row = 1;
        $listUser = $this->getDoctrine()->getRepository(Utilisateur::class)->filterUserByArray($array);

        $objExcel = new \PHPExcel();
        $objExcel->getProperties()
            ->setTitle("test")
            ;


//        Entête
        $objExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, $row,'Numéros Etudiant');
        $objExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, $row,'Nom');
        $objExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, $row,'Prénom');
        $objExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, $row,'Parcours');
        $objExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row,'Options');
        $objExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(15);
//        Fin entête

        foreach ($listUser as $user){
            $nbrLineToCell = 1;

            /** @var Utilisateur $objetUser */
            $objetUser = $this->getDoctrine()->getRepository(Utilisateur::class)->find($user[1]);
            $col = 0;
            $row ++;
            $objExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, $row,$objetUser->getNumeroEtudiant());
            $objExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, $row,$objetUser->getNom());
            $objExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, $row,$objetUser->getPrenom());
            $objExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, $row,$objetUser->getParcours());

            $listeMatiereOptionnel = "";

//            Trie par code des UE
            $tabMatiere = null;
            /** @var Matiere $matiere */
            foreach ($objetUser->getMatieres()->getValues() as $matiere){
                /** @var Parcours $userParcours */
                $userParcours = $objetUser->getParcours();
                /** @var MatiereParcours $matiereOptionnel */
                $matiereOptionnel = $this->getDoctrine()->getRepository(MatiereParcours::class)->findBy(['parcours' => $userParcours, 'optionnel' => true ]);
                $tabMatiereOptionnel = [];
                /** @var MatiereParcours $matiereOpt */
                foreach ($matiereOptionnel as $matiereOpt){
                    $tabMatiereOptionnel[] = $matiereOpt->getMatieres();
                }
                if($matiere != null && in_array($matiere,$tabMatiereOptionnel)) {
                    $tabMatiere[] = $matiere;
                }
            }

            if($tabMatiere != null){
                /** @var Matiere $matiere */
                foreach ($tabMatiere as $matiere){
                    $nbrLineToCell++;
                    $listeMatiereOptionnel .= $matiere. "\r\n";
                }
            }
//            Fin du trie par code UE

            $objExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row,$listeMatiereOptionnel);

            // Style
            $objExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(15*$nbrLineToCell);

            foreach(range('A','E') as $columnID)
            {
                $objExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
                $objExcel->getActiveSheet()->getStyle($columnID.$row)->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
            }
            //End style
        }

        $writer = \PHPExcel_IOFactory::createWriter($objExcel, 'Excel5');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="excel.xls"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        return $this->indexAction();
    }
}
