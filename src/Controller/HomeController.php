<?php

namespace App\Controller;

use App\Form\CustomDataClass\SearchFormRequest;
use App\Form\LoginFormType;
use App\Form\SearchFormType;
use App\Model\StatisticsModel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\NotBlank;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $member = $this->getUser();
        if ($member) {
            return $this->forward(LandingController::class.'::indexAction');
        }

        $loginForm = $this->createForm(LoginFormType::class, null, [
            'action' => $this->generateUrl('security_check'),
            'method' => 'POST',
        ]);

        // Find all members around 100km of the given location
        $searchFormRequest = new SearchFormRequest($this->getDoctrine()->getManager());
        $searchFormRequest->showmap = true;
        $searchFormRequest->accommodation_neverask = true;
        $searchFormRequest->inactive = true;
        $searchFormRequest->distance = 100;

        $searchForm = $this->createForm(SearchFormType::class, $searchFormRequest, [
            'action' => '/search/map',
        ]);

        $usernameForm = $this->createFormBuilder()
            ->add('username', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->setAction('/signup/1')
            ->setMethod('POST')
            ->getForm();

        $statisticsModel = new StatisticsModel($this->getDoctrine());
        $statistics = $statisticsModel->getStatistics();
        $roxPostHandler = new \RoxPostHandler();
        $roxPostHandler->setClasses([
            'SignupController',
        ]);

        return $this->render('home/home.html.twig', [
            'postHandler' => $roxPostHandler,
            'form' => $loginForm->createView(),
            'search' => $searchForm->createView(),
            'username' => $usernameForm->createView(),
            'locale' => $this->getParameter('locale'),
            'title' => 'BeWelcome',
            'stats' => $statistics,
        ]);
    }
}
