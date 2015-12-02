<?php

namespace Utilities\Form;

use Zend\Form\View\Helper\Form;
use Zend\Form\FieldsetInterface;
use Zend\Form\FormInterface;
use Zend\Form\Element\Submit;

class FormViewHelper extends Form {
    /**
     * Render a form from the provided $form,
     *
     * @param  FormInterface $form
     * @return string
     */
    public function render(FormInterface $form) {
        if (method_exists($form, 'prepare')) {
            $form->prepare();
        }

        $formContent = '';

        foreach ($form as $element) {

            if ($element instanceof FieldsetInterface) {
                $formContent.= $this->getView()->formCollection($element);
            } else {

                if (empty($element->getAttribute('id'))) {
                    $element->setAttribute('id', $form->getAttribute('name') . "_" . $element->getAttribute('name'));
                }
                $labelAbsent = false;
                $formElementAppendString = '';
                if (empty($element->getLabel()) && $element->getAttribute('type') !== "hidden") {
                    $labelAbsent = true;
                }
                if ($labelAbsent === true) {
                    $formContent.= "<dt>&nbsp;</dt>";
                } else {
                    $formContent.='<dd>';
                    $formElementAppendString = '</dd>';
                }

                if($element instanceof Submit && $form->isEditForm === true){
                    $element->setValue("Edit");
                }
                
                $formContent.= $this->getView()->formRow($element);
                $formContent.=$formElementAppendString;
            }
        }

        return $this->openTag($form) . $formContent . $this->closeTag();
    }
}
