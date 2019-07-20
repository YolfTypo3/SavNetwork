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
 * Edge model for the extension SavNetwork
 *
 */
class Edge extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * The fromNode variable.
     *
     * @var \YolfTypo3\SavNetwork\Domain\Model\Node    
     */
    protected $fromNode;

    /**
     * The toNode variable.
     *
     * @var \YolfTypo3\SavNetwork\Domain\Model\Node    
     */
    protected $toNode;

    /**
     * The options variable.
     *
     * @var string
     */
    protected $options;

    /**
     * Constructor.
     */
    public function __construct()
    {
    }

    /**
     * Getter for fromNode.
     *
     * @return \YolfTypo3\SavNetwork\Domain\Model\Node    
     */
    public function getFromNode()
    {
        return $this->fromNode;
    }

    /**
     * Setter for fromNode.
     *
     * @param \YolfTypo3\SavNetwork\Domain\Model\Node     $fromNode
     * @return void
     */
    public function setFromNode($fromNode)
    {
        $this->fromNode = $fromNode;
    }    

    /**
     * Getter for toNode.
     *
     * @return \YolfTypo3\SavNetwork\Domain\Model\Node    
     */
    public function getToNode()
    {
        return $this->toNode;
    }

    /**
     * Setter for toNode.
     *
     * @param \YolfTypo3\SavNetwork\Domain\Model\Node     $toNode
     * @return void
     */
    public function setToNode($toNode)
    {
        $this->toNode = $toNode;
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

}
?>

