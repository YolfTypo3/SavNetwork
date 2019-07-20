<?php
namespace YolfTypo3\SavNetwork\UserFunctions;

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
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Backend\Utility\BackendUtility;

class LabelUserFunction
{
    /**
     * Builds the edge label from the "from node" name and the "to node" name
     *
	 * @param array $parameters Parameters used to identify the current record
	 * @param object $parentObject Calling object
	 * @return void
     */
    public function edgeLabel(&$parameters, $parentObject)
    {
        // Gets the record
        $record = BackendUtility::getRecord($parameters['table'], $parameters['row']['uid']);

        if ($record['from_node'] && $record['to_node']) {
            // Gets the fromNode record
            $fromNodeRecord = BackendUtility::getRecord('tx_savnetwork_domain_model_node', $record['from_node']);

            // Gets the toNode record
            $toNodeRecord = BackendUtility::getRecord('tx_savnetwork_domain_model_node', $record['to_node']);

            // Sets the title
            $title = $fromNodeRecord['name'] . '->' . $toNodeRecord['name'];
            $parameters['title'] = $title;
        }
    }
}

?>