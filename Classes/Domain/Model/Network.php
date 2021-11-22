<?php

namespace YolfTypo3\SavNetwork\Domain\Model;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with TYPO3 source code.
 *
 * The TYPO3 project - inspiring people to share
 */

/**
 * Network model for the extension SavNetwork
 *
 */
class Network extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * The name variable.
     *
     * @var string
     */
    protected $name;

    /**
     * The options variable.
     *
     * @var string
     */
    protected $options;

    /**
     * The nodes variable.
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\YolfTypo3\SavNetwork\Domain\Model\Node>
     */
    protected $nodes;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->nodes = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Getter for name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Setter for name.
     *
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Getter for options.
     *
     * @return string
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Setter for options.
     *
     * @param string $options
     * @return void
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }

    /**
     * Getter for nodes.
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getNodes()
    {
        return $this->nodes;
    }

    /**
     * Setter for nodes.
     *
     * @param  \TYPO3\CMS\Extbase\Persistence\ObjectStorage $nodes
     * @return void
     */
    public function setNodes($nodes)
    {
        $this->nodes = $nodes;
        $this->nodes->_memorizeCleanState();
    }

    /**
     * Adds a nodes
     *
     * @param \YolfTypo3\SavNetwork\Domain\Model\Node $nodes
     * @return void
     */
    public function addNodes(\YolfTypo3\SavNetwork\Domain\Model\Node $nodes)
    {
        $this->nodes->attach($nodes);
    }

    /**
     * Removes a nodes
     *
     * @param \YolfTypo3\SavNetwork\Domain\Model\Node $nodes
     * @return void
     */
    public function removeNodes(\YolfTypo3\SavNetwork\Domain\Model\Node $nodes)
    {
        $this->nodes->detach($nodes);
    }
}
