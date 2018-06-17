<?php
namespace Annotate\Form;

use Omeka\View\Helper\Api;
use Zend\Form\Element;

class ResourceForm extends \Omeka\Form\ResourceForm
{
    /**
     * @var Api
     */
    protected $api;

    public function init()
    {
        parent::init();

        $api = $this->api;

        // The default resource template of an annotation is Annotation.
        $resourceTemplateId = $api->searchOne('resource_templates', ['label' => 'Annotation'])->getContent()->id();
        $this->get('o:resource_template[o:id]')
            ->setValue($resourceTemplateId);

        // The resource class of an annotation is always oa:Annotation.
        $resourceClass = $api->searchOne('resource_classes', ['term' => 'oa:Annotation'])->getContent();
        $this->add([
            'name' => 'o:resource_class[o:id]',
            'type' => Element\Select::class,
            'options' => [
                'label' => 'Class', // @translate
                'value_options' => [
                    'oa' => [
                        'label' => $resourceClass->vocabulary()->label(),
                        'options' => [
                            [
                                'label' => $resourceClass->label(),
                                'value' => $resourceClass->id(),
                                'attributes' => [
                                    'data-term' => 'oa:Annotation',
                                    'data-resource-class-id' => $resourceClass->id(),
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'attributes' => [
                'value' => $resourceClass->id(),
                'class' => 'chosen-select',
            ],
        ]);
    }

    /**
     * @param Api $api
     */
    public function setApi(Api $api)
    {
        $this->api = $api;
    }
}