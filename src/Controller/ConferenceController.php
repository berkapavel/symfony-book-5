<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Conference;
use App\Form\CommentFormType;
use App\Repository\CommentRepository;
use App\Repository\ConferenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConferenceController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="homepage")
     * @param ConferenceRepository $conferenceRepository
     * @return Response
     */
    public function index(ConferenceRepository $conferenceRepository)
    {
        return $this->render(
            'conference/index.html.twig',
            [
                'conferences' => $conferenceRepository->findAll(),
            ]
        );
    }

    /**
     * @Route("/conference/{slug}", name="conference")
     * @param Request $request
     * @param Conference $conference
     * @param CommentRepository $commentRepository
     * @param string $photoDir
     * @return Response
     */
    public function show(
        Request $request,
        Conference $conference,
        CommentRepository $commentRepository,
        string $photoDir
    )
    {
        dump($photoDir);
        exit();
        $comment = new Comment();
        $form = $this->createForm(CommentFormType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setConference($conference);

            /** @var File $photo */
            if ($photo = $form->get('photo')->getData()) {
                $filename = null;

                try {
                    $filename = bin2hex(random_bytes(6)) . '.' . $photo->guessExtension();
                    $photo->move($photoDir, $filename);
                } catch (FileException $e) {
                    // unable to upload
                } catch (Exception $e) {
                    // problem with filename
                }

                if ($filename) {
                    $comment->setPhotoFilename($filename);
                }
            }

            $this->entityManager->persist($comment);
            $this->entityManager->flush();

            return $this->redirectToRoute('conference', ['slug' => $conference->getSlug()]);
        }

        $offset = max(0, $request->query->get('offset', 0));
        $commentPaginator = $commentRepository->getCommentPaginator($conference, $offset);

        return $this->render(
            'conference/show.html.twig',
            [
                'conference' => $conference,
                'comments' => $commentPaginator,
                'previous' => $offset - CommentRepository::PAGINATOR_PER_PAGE,
                'next' => min(count($commentPaginator), $offset + CommentRepository::PAGINATOR_PER_PAGE),
                'comment_form' => $form->createView()
            ]
        );
    }
}
