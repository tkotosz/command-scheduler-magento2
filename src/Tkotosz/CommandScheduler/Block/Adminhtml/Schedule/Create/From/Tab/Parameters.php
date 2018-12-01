<?php

namespace Tkotosz\CommandScheduler\Block\Adminhtml\Schedule\Create\From\Tab;

use Tkotosz\CommandScheduler\Model\CommandProvider;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;

class Parameters extends Generic implements TabInterface
{
    /**
     * @var CommandProvider
     */
    private $commandProvider;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry             $registry
     * @param \Magento\Framework\Data\FormFactory     $formFactory
     * @param CommandProvider                         $commandProvider
     * @param array                                   $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        CommandProvider $commandProvider,
        array $data = []
    ) {
        $this->commandProvider = $commandProvider;

        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare label for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('Parameters');
    }

    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('Parameters');
    }

    /**
     * Returns status flag about this tab can be showen or not
     *
     * @return true
     */
    public function canShowTab()
    {
        $commandName = $this->getFormData()->getData('command');

        return $commandName !== null && $this->commandProvider->getByName($commandName) !== null;
    }

    /**
     * Returns status flag about this tab hidden or not
     *
     * @return bool
     */
    public function isHidden()
    {
        return false;
    }

    protected function _prepareForm()
    {
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            ['data' => ['id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post']]
        );
        $command = $this->commandProvider->getByName($this->getFormData()->getData('command'));

        $baseFieldset = $form->addFieldset('base_fieldset', ['legend' => __('Command')]);

        $baseFieldset->addField(
            'command_name',
            'hidden',
            [
                'name' => 'command_name',
                'label' => __('Command Name'),
                'title' => __('Command Name'),
                'value' => $command->getName()
            ]
        );

        $baseFieldset->addField(
            'info_command_name',
            'text',
            [
                'name' => 'info_command_name',
                'label' => __('Command Name'),
                'title' => __('Command Name'),
                'value' => $command->getName(),
                'disabled' => true
            ]
        );

        $baseFieldset->addField(
            'info_command_description',
            'text',
            [
                'name' => 'info_command_description',
                'label' => __('Command Description'),
                'title' => __('Command Description'),
                'value' => $command->getDescription(),
                'disabled' => true
            ]
        );

        if ($command->getDefinition()->getOptions()) {
            $optionsFieldset = $form->addFieldset('options_fieldset', ['legend' => __('Options')]);
            $dependencyMap = $this->getLayout()->createBlock('Magento\Backend\Block\Widget\Form\Element\Dependence');
            $this->setChild('form_after', $dependencyMap);

            foreach ($command->getDefinition()->getOptions() as $option) {
                if ($option->acceptValue()) {
                    $includeFieldName = sprintf('include_%s', $option->getName());
                    $valueFieldName = sprintf('command_params[--%s]', $option->getName());
                    $optionsFieldset->addField(
                        $includeFieldName,
                        'select',
                        [
                            'name' => $includeFieldName,
                            'label' => $option->getName(),
                            'title' => $option->getName(),
                            'required' => false,
                            'options' => ['0' => __('Exclude'), '1' => __('Include')],
                            'note' => $option->getDescription()
                        ]
                    );

                    $optionsFieldset->addField(
                        $valueFieldName,
                        'text',
                        [
                            'name' => $valueFieldName,
                            'label' => sprintf('"%s" option value', $option->getName()),
                            'title' => sprintf('"%s" option value', $option->getName()),
                            'required' => $option->isValueRequired(),
                            'value' => $option->acceptValue() ? ($option->getDefault() ?: '') : ''
                        ]
                    );

                    $dependencyMap->addFieldMap($includeFieldName, $includeFieldName);
                    $dependencyMap->addFieldMap($valueFieldName, $valueFieldName);
                    $dependencyMap->addFieldDependence($valueFieldName, $includeFieldName, '1');
                } else {
                    $valueFieldName = sprintf('command_params[--%s]', $option->getName());
                    $optionsFieldset->addField(
                        $valueFieldName,
                        'select',
                        [
                            'name' => $valueFieldName,
                            'label' => $option->getName(),
                            'title' => $option->getName(),
                            'required' => false,
                            'options' => ['0' => __('Exclude'), '1' => __('Include')],
                            'note' => $option->getDescription()
                        ]
                    );
                }
            }
        }

        if ($command->getDefinition()->getArguments()) {
            $argumentsFieldset = $form->addFieldset('arguments_fieldset', ['legend' => __('Arguments')]);

            foreach ($command->getDefinition()->getArguments() as $argument) {
                $argumentsFieldset->addField(
                    sprintf('command_params[%s]', $argument->getName()),
                    'text',
                    [
                        'name' => sprintf('command_params[%s]', $argument->getName()),
                        'label' => $argument->getName(),
                        'title' => $argument->getName(),
                        'required' => $argument->isRequired(),
                        'value' => $argument->getDefault() ?: '',
                        'note' => $argument->getDescription()
                    ]
                );            
            }
        }

        $this->setForm($form);

        return parent::_prepareForm();
    }

    public function getFormData()
    {
        return $this->_coreRegistry->registry('tkotosz_command_scheduler_data_container');
    }
}
