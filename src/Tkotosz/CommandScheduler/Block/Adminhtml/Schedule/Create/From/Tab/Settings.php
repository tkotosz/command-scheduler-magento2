<?php

namespace Tkotosz\CommandScheduler\Block\Adminhtml\Schedule\Create\From\Tab;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Tkotosz\CommandScheduler\Model\AllowedCommandsContainer;

class Settings extends Generic implements TabInterface
{
    /**
     * @var AllowedCommandsContainer
     */
    private $allowedCommandsContainer;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        AllowedCommandsContainer $allowedCommandsContainer,
        array $data = []
    ) {
        $this->allowedCommandsContainer = $allowedCommandsContainer;

        parent::__construct($context, $registry, $formFactory, $data);
    }
    
    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setActive(true);
    }

    /**
     * Prepare label for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('Settings');
    }

    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('Settings');
    }

    /**
     * Returns status flag about this tab can be showen or not
     *
     * @return true
     */
    public function canShowTab()
    {
        return $this->getFormData()->getData('command') === null;
    }

    /**
     * Returns status flag about this tab hidden or not
     *
     * @return true
     */
    public function isHidden()
    {
        return false;
    }

    public function getFormData()
    {
        return $this->_coreRegistry->registry('tkotosz_command_scheduler_data_container');
    }

    /**
     * Prepare form before rendering HTML
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            ['data' => ['id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post']]
        );

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Settings')]);

        $this->_addElementTypes($fieldset);

        $fieldset->addField(
            'command',
            'select',
            [
                'name' => 'command',
                'label' => __('Command'),
                'title' => __('Command'),
                'required' => true,
                'values' => $this->getTypesOptionsArray()
            ]
        );

        $continueButton = $this->getLayout()->createBlock(
            \Magento\Backend\Block\Widget\Button::class
        )->setData(
            [
                'label' => __('Continue'),
                'onclick' => "setSettings('" . $this->getContinueUrl() . "', 'command')",
                'class' => 'save',
            ]
        );
        $fieldset->addField('continue_button', 'note', ['text' => $continueButton->toHtml()]);

        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Return url for continue button
     *
     * @return string
     */
    public function getContinueUrl()
    {
        return $this->getUrl(
            'tkotosz_commandscheduler/schedule/create',
            [
                '_current' => true,
                'command' => '<%- data.command %>',
                '_escape_params' => false
            ]
        );
    }

    /**
     * @return array
     */
    public function getTypesOptionsArray()
    {
        $options = [['value' => '', 'label' => __('-- Please Select --')]];

        foreach ($this->allowedCommandsContainer->getAllowedCommands() as $label => $commandName) {
            $options[] = ['value' => $commandName, 'label' => $label];
        }

        return $options;
    }
}
