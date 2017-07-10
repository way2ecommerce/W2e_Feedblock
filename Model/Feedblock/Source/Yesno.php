<?php

namespace W2e\Feedblock\Model\Feedblock\Source;

/**
 * Class Yesno
 * @package W2e\Feedblock\Model\Feedblock\Source
 */
class Yesno implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @var \W2e\Feedblock\Model\Feedblock
     */
    protected $option;

    /**
     * Yesno constructor.
     *
     * @param \W2e\Feedblock\Model\Feedblock $feedblock
     */
    public function __construct(\W2e\Feedblock\Model\Feedblock $feedblock)
    {
        $this->option = $feedblock;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options[]        = ['label' => '', 'value' => ''];
        $availableOptions = $this->option->getYesNoOption();
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }

        return $options;
    }
}
