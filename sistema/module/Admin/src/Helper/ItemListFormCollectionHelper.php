<?php

namespace Admin\Helper;

use Zend\Form\Element\Collection as CollectionElement;
use Zend\Form\ElementInterface;
use Zend\Form\FieldsetInterface;
use Zend\Form\View\Helper\FormCollection;

class ItemListFormCollectionHelper extends FormCollection
{
    private $elementformat =
        '<div class="form-group">%s</div>';

    public function __invoke(ElementInterface $element = null, $wrap = true)
    {
        if (!$element) {
            return $this;
        }
        $this->setShouldWrap($wrap);
        return $this->render($element);
    }

    public function render(ElementInterface $element)
    {
        $renderer = $this->getView();
        if (!method_exists($renderer, 'plugin')) {
            return '';
        }

        $markup = '';
        $templateMarkup = '';
        $escapeHtmlHelper = $this->getEscapeHtmlHelper();
        $elementHelper = $this->getElementHelper();
        $fieldsetHelper = $this->getFieldsetHelper();

        if ($element instanceof CollectionElement && $element->shouldCreateTemplate()) {
            $templateMarkup = $this->renderTemplate($element);
        }

        $row = '<div class="row phase-container">' .
            '<div class="col-sm-11"><div class="row">%s</div></div>' .
            '<div class="col-sm-1">' .
            '<span class="input-group-btn">' .
            '<button class="btn btn-block btn-danger delete" style="margin-top: 24px;" type="button">Excluir</button>' .
            '</span>' .
            '</div>' .
            '</div>';
        $col = '<div class="col-sm-3">%s</div>';

        foreach ($element->getIterator() as $elementOrFieldset) {
            if ($elementOrFieldset instanceof FieldsetInterface) {
                $markup .= sprintf($this->elementformat, sprintf($row, $fieldsetHelper($elementOrFieldset)));
            } elseif ($elementOrFieldset instanceof ElementInterface) {
                $markup .= sprintf($col, $elementHelper($elementOrFieldset));
            }
        }

        if (!empty($templateMarkup)) {
            $markup .= $templateMarkup;
        }

        return $markup;
    }

    public function renderTemplate(CollectionElement $collection)
    {
        $elementHelper = $this->getElementHelper();
        $escapeHtmlAttribHelper = $this->getEscapeHtmlAttrHelper();
        $templateMarkup = '';

        $elementOrFieldset = $collection->getTemplateElement();

        if ($elementOrFieldset instanceof FieldsetInterface) {
            $templateMarkup .= $this->render($elementOrFieldset);
        } elseif ($elementOrFieldset instanceof ElementInterface) {
            $templateMarkup .= $elementHelper($elementOrFieldset);
        }

        $element = sprintf($this->elementformat, $templateMarkup);

        return sprintf(
            '<span data-template="%s"></span>',
            $escapeHtmlAttribHelper($element)
        );
    }
}