<?php

namespace Tkotosz\CommandScheduler\Block\Adminhtml\Schedule\Create\From;

use Magento\Backend\Block\Widget\Form\Container as BaseFormContainer;

class Container extends BaseFormContainer
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry = null;

    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Internal constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = 'schedule_id';
        $this->_blockGroup = 'Tkotosz_CommandScheduler';
        $this->_controller = 'adminhtml_schedule';
        $this->_mode = 'create';
        parent::_construct();
    }

    
    public function getFromData()
    {
        return $this->coreRegistry->registry('tkotosz_command_scheduler_data_container');
    }

    /**
     * Prepare layout.
     * Adding save_and_continue button
     *
     * @return $this
     */
    protected function _preparelayout()
    {
        if (!$this->getFromData()->getData('command')) {
            $this->removeButton('save');
        }

        return parent::_prepareLayout();
    }

    /**
     * Return translated header text depending on creating/editing action
     *
     * @return \Magento\Framework\Phrase
     */
    public function getHeaderText()
    {
        return __('New Schedule');
    }

    /**
     * Return save url for edit form
     *
     * @return string
     */
    public function getSaveUrl()
    {
        return $this->getUrl('tkotosz_commandscheduler/schedule/save', ['_current' => false, 'back' => null]);
    }
}
