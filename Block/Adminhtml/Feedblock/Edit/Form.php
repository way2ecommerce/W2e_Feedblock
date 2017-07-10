<?php

namespace W2e\Feedblock\Block\Adminhtml\Feedblock\Edit;


/**
 * Class Form
 * @package W2e\Feedblock\Block\Adminhtml\Feedblock\Edit
 */
class Form extends \Magento\Backend\Block\Widget\Form\Generic
{


    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;


    /**
     * Form constructor.
     *
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        array $data = []
    ) {
        $this->_systemStore = $systemStore;
        parent::__construct($context, $registry, $formFactory, $data);
    }


    /**
     *
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('feed_form');
        $this->setTitle(__('Feed Information'));
    }


    /**
     * @return $this
     */
    protected function _prepareForm()
    {

        $model = $this->_coreRegistry->registry('feedblock_feedblock');


        $form = $this->_formFactory->create(
            ['data' => ['id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post']]
        );

        $form->setHtmlIdPrefix('feed_');

        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('General Information'), 'class' => 'fieldset-wide']
        );

        if ($model->getFeedblockId()) {
            $fieldset->addField('feedblock_id', 'hidden', ['name' => 'feedblock_id']);
        }

        $fieldset->addField(
            'feed_url',
            'text',
            [
                'name'     => 'feed_url',
                'label'    => __('Feed URL'),
                'title'    => __('Feed URL'),
                'required' => true,
                'class'    => 'validate-url'
            ]
        );

        $fieldset->addField(
            'block_title',
            'text',
            [
                'name'     => 'block_title',
                'label'    => __('Block Title'),
                'title'    => __('Block Title'),
                'required' => true
            ]
        );

        $fieldset->addField(
            'descr_limit',
            'text',
            [
                'name'  => 'descr_limit',
                'label' => __('Description limit'),
                'title' => __('Description limit'),
                'note'  => __('Leave it blank or set 0 to include the entire description')
            ]
        );

        $fieldset->addField(
            'use_images',
            'select',
            [
                'label'   => __('Show Image?'),
                'title'   => __('Show Image?'),
                'name'    => 'use_images',
                'options' => ['1' => __('Yes'), '0' => __('No')]
            ]
        );

        $fieldset->addField(
            'show_categories',
            'select',
            [
                'label'   => __('Show Categories?'),
                'title'   => __('Show Categories?'),
                'name'    => 'show_categories',
                'options' => ['1' => __('Yes'), '0' => __('No')]
            ]
        );

        $fieldset->addField(
            'use_slider',
            'select',
            [
                'label'   => __('Use Slider?'),
                'title'   => __('Use Slider?'),
                'name'    => 'use_slider',
                'options' => ['1' => __('Yes'), '0' => __('No')]
            ]
        );

        $fieldset->addField(
            'item_qty',
            'text',
            [
                'name'  => 'item_qty',
                'label' => __('Number of items'),
                'title' => __('Number of items')
            ]
        );

        $fieldset->addField(
            'status',
            'select',
            [
                'label'    => __('Status'),
                'title'    => __('Status'),
                'name'     => 'status',
                'required' => true,
                'options'  => ['1' => __('Enabled'), '0' => __('Disabled')]
            ]
        );

        if ( ! $model->getId()) {
            $model->setData('status', '1');
            $model->setData('use_images', '1');
            $model->setData('show_categories', '1');
            $model->setData('use_slider', '1');
            $model->setData('item_qty', '5');
        }

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}