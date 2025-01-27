<?php

namespace App\Controller;

use App\Form\FooBarType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomepageController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(Request $request): Response
    {
        foreach (['live', 'turbo'] as $name) {
            $form = $this->createForm(FooBarType::class, null, [
                'action' => $this->generateUrl('app_form', ['name' => $name]),
                 'block_name' => $name,
            ]);
            $forms['form_'.$name] = $form;
        }
        
        return $this->render('homepage.html.twig', [
            ...$forms,
        ]);
    }
    
    #[Route('/form/{name}', name: 'app_form', requirements: ['name' => 'live|turbo'])]
    public function formLive(Request $request, string $name): Response
    {
        $form = $this->createForm(FooBarType::class, null, [
            'action' => $this->generateUrl('app_form', ['name' => $name]),
            'block_name' => $name,
        ]);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            if ($form->get('success')->getData()) {
                $this->addFlash('success', 'Form submitted successfully');
            } else {
                $this->addFlash('error', 'Form submission failed');
            }
            
            return $this->redirectToRoute('app_homepage', [], Response::HTTP_SEE_OTHER);
        }
        
        return $this->render('form.html.twig', [
            'form' => $form->createView(),
            'form_name' => $name,
        ]);
    }
}
