<?php

namespace W2e\Feedblock\Model\Feedblock\Source;

/**
 * Class Status
 * @package W2e\Feedblock\Model\Feedblock\Source
 */
class Status implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @var \W2e\Feedblock\Model\Feedblock
     */
    protected $status;

    /**
     * Status constructor.
     *
     * @param \W2e\Feedblock\Model\Feedblock $feedblock
     */
    public function __construct(\W2e\Feedblock\Model\Feedblock $feedblock)
    {
        $this->status = $feedblock;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options[]        = ['label' => '', 'value' => ''];
        $availableOptions = $this->status->getAvailableStatuses();
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }

        return $options;
    }
}
