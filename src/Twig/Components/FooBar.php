<?php

namespace App\Twig\Components;

use App\Form\FooBarType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class FooBar extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;
    
    #[LiveProp]
    public array $initialFormData;
    
    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(FooBarType::class, $this->initialFormData ??= []);
    }
    
    #[LiveAction]
    public function save(): void
    {
    }
}
