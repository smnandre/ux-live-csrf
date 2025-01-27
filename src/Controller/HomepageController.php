<?php

namespace App\Controller;

use App\Form\FooBarType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomepageController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(Request $request): Response
    {
        foreach (['live', 'turbo'] as $name) {
            $forms['form_'.$name] = $this->createFooBarForm($name);
        }
        
        return $this->render('homepage.html.twig', [
            ...$forms,
        ]);
    }
    
    #[Route('/form/{name}', name: 'app_form', requirements: ['name' => 'live|turbo'])]
    public function formLive(Request $request, string $name): Response
    {
        $form = $this->createFooBarForm($name);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('app_homepage', [], Response::HTTP_SEE_OTHER);
        }
        
        return $this->render('form.html.twig', [
            'form' => $form,
            'form_name' => $name,
        ]);
    }
    
    private function createFooBarForm(string $name): FormInterface
    {
        return $this->createFormBuilder()->create($name, FooBarType::class, [
            // 'action' => $this->generateUrl('app_form', ['name' => $name]),
            'block_prefix' => $name,
        ])->getForm();
    }
}
