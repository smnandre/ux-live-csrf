<?php

namespace App\Controller;

use App\Form\BaseForm;
use App\Form\LiveForm;
use App\Form\TurboForm;
use App\Form\TurboFrameForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomepageController extends AbstractController
{
    private const FORMS = [
        'base' => BaseForm::class,
        'live' => LiveForm::class,
        'turbo' => TurboForm::class,
        'turbo_frame' => TurboFrameForm::class,
        // 'live_no' => LiveForm::class,
        // 'turbo_no' => TurboForm::class,
    ];
    
    #[Route('/', name: 'app_homepage')]
    public function index(Request $request): Response
    {
        foreach (self::FORMS as $name => $formType) {
            $forms['form_'.$name] = $form = $this->createForm($formType, [
                'action' => $this->generateUrl('app_homepage'),
            ]);
            
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                
                if ('turbo' === $name) {
                    // TODO
                }
                
                return $this->redirectToRoute('app_homepage', [], Response::HTTP_SEE_OTHER);
            }
        }
        
        return $this->render('homepage.html.twig', [
            ...$forms,
        ]);
    }
    
    #[Route('/about', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('about.html.twig');
    }
}
