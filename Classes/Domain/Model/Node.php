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
 * Node model for the extension SavNetwork
 *
 */
class Node extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
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
     * The image variable.
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     */
    protected $image;

    /**
     * The link variable.
     *
     * @var string
     */
    protected $link;

    /**
     * The edges variable.
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\YolfTypo3\SavNetwork\Domain\Model\Edge>
     */
    protected $edges;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->image = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->edges = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
     * Getter for image.
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Setter for image.
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $image
     * @return void
     */
    public function setImage($image)
    {
        $this->image = $this->updateFileStorage($this->image, $image);
    }

    /**
     * Getter for link.
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Setter for link.
     *
     * @param string $link
     * @return void
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    /**
     * Getter for edges.
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getEdges()
    {
        return $this->edges;
    }

    /**
     * Setter for edges.
     *
     * @param  \TYPO3\CMS\Extbase\Persistence\ObjectStorage $edges
     * @return void
     */
    public function setEdges($edges)
    {
        $this->edges = $edges;
        $this->edges->_memorizeCleanState();
    }

    /**
     * Adds a edges
     *
     * @param \YolfTypo3\SavNetwork\Domain\Model\Edge $edges
     * @return void
     */
    public function addEdges(\YolfTypo3\SavNetwork\Domain\Model\Edge $edges)
    {
        $this->edges->attach($edges);
    }

    /**
     * Removes a edges
     *
     * @param \YolfTypo3\SavNetwork\Domain\Model\Edge $edges
     * @return void
     */
    public function removeEdges(\YolfTypo3\SavNetwork\Domain\Model\Edge $edges)
    {
        $this->edges->detach($edges);
    }
}
