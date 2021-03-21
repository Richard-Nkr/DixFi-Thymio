<?php

namespace App\Controller;

use App\Entity\StudentGroup;
use App\Form\StudentGroupType;
use App\Repository\ChildRepository;
use App\Repository\StatusRepository;
use App\Repository\StudentGroupRepository;
use App\Repository\TeacherRepository;
use App\Service\CreateStudentGroup;
use App\Service\GestionPassword;
use App\Service\SortChallenges;
use Dompdf\Dompdf;
use Dompdf\Options;
use Knp\Snappy\Pdf;
use Spatie\Browsershot\Browsershot;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/student/group")
 */
class StudentGroupController extends AbstractController
{
    /**
     * @Route("/", name="student_group_index", methods={"GET"})
     * @param StudentGroupRepository $studentgroupRepository
     * @return Response
     */
    public function index(StudentGroupRepository $studentgroupRepository): Response
    {
        return $this->render('student_group/index.html.twig', [
            'student_groups' => $studentgroupRepository->findAll(),
            'teacher'=>$this->getUser()
        ]);
    }


    /**
     * @Route("/block/levels", name="student_group_block_levels", methods={"GET"})
     * @param StudentGroupRepository $studentGroupRepository
     * @param SortChallenges $sortChallenges
     * @param StatusRepository $statusRepository
     * @return Response
     */
    public function blockLevels(StudentGroupRepository $studentGroupRepository, SortChallenges $sortChallenges, StatusRepository $statusRepository): Response
    {
        $studentGroup = $studentGroupRepository->findOneById($this->getUser()->getId());
        $teacher = $studentGroup->getTeacher();
        $count = 0;
        if($teacher->getProgression()==true){
            $statusList = $statusRepository->findBy(['studentGroup'=>$studentGroup,'statusInt'=>3]);
            $count = $sortChallenges->sort($statusList);
        }
        return $this->render('student_group/menu_thymio_challenges.html.twig', [
            'teacher'=>$teacher,
            'count' => $count,
        ]);
    }


    /**
     * @Route("/show", name="student_group_show", methods={"GET"})
     * @param ChildRepository $childRepository
     * @return Response
     */
    public function show(ChildRepository $childRepository): Response
    {
        $studentGroup = $this->getUser();
        $children = $childRepository->findBy(['studentGroup'=>$studentGroup]);
        return $this->render('student_group/show.html.twig', [
            'student_group' => $studentGroup,
            'children'=>$children,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="student_group_edit", methods={"GET","POST"})
     * @param Request $request
     * @param StudentGroup $studentGroup
     * @return Response
     */
    public function edit(Request $request, StudentGroup $studentGroup): Response
    {
        $form = $this->createForm(StudentGroupType::class, $studentGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('student_group_index');
        }

        return $this->render('student_group/edit.html.twig', [
            'student_group' => $studentGroup,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/create/pdf/thymio", name="create_pdf_thymio", methods={"GET","POST"})
     * @param KernelInterface $kernel
     * @return Response
     */
    public function createPdfThymio(KernelInterface $kernel): Response
    {
        $studentGroup = $this->getUser();
        $vars= 'html to pdf';
        $html = $this->renderView('student_group/certificate_pdf.html.twig', array(
            'some'  => $vars,
            'studentGroup' =>$studentGroup
        ));
        $options = new Options();
        $options->set('isRemoteEnabled', TRUE);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4');
        // Render the HTML as PDF
        $dompdf->render();
        // Output the generated PDF to Browser
        //$dompdf->stream();
        $dompdf->stream();;
    }


    /**
     * @Route("/{id}", name="student_group_delete", methods={"DELETE"})
     * @param Request $request
     * @param StudentGroup $studentGroup
     * @return Response
     */
    public function delete(Request $request, StudentGroup $studentGroup): Response
    {
        if ($this->isCsrfTokenValid('delete'.$studentGroup->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($studentGroup);
            $entityManager->flush();
        }

        return $this->redirectToRoute('student_group_index');
    }
}
