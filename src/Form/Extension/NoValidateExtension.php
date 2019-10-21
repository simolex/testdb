<?php declare(strict_types=1);

namespace App\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class NoValidateExtension extends AbstractTypeExtension
{
    private /*bool*/ $html5Validation; // Ready for PHP 7.4! 😊

    public function __construct(bool $html5Validation)
    {
        $this->html5Validation = $html5Validation;
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $attr = !$this->html5Validation ? ['novalidate' => 'novalidate'] : [];
        $view->vars['attr'] = array_merge($view->vars['attr'], $attr);
    }

    public function getExtendedTypes()
    {
        return [FormType::class];
    }
}