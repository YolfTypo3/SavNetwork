<?php

defined('TYPO3_MODE') or die();

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addUserTSConfig('options.saveDocNew.node=1');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addUserTSConfig('options.saveDocNew.edge=1');

// Configures the Dispatcher
if (version_compare(\YolfTypo3\SavNetwork\Controller\DefaultController::getTypo3Version(), '10.0', '<')) {
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    	'YolfTypo3.sav_network',
    	'Default',
    	// Cachable controller actions
    	[
        	'Default' => 'show',
    	],
    	// Non-cachable controller actions
    	[]
	);
} else {
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    	'SavNetwork',
    	'Default',
    	// Cachable controller actions
    	[
        	\YolfTypo3\SavNetwork\Controller\DefaultController::class => 'show',
    	],
    	// Non-cachable controller actions
    	[]
	);
}

// Registers the icon
$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
   \TYPO3\CMS\Core\Imaging\IconRegistry::class
);
$iconRegistry->registerIcon(
   'ext-savnetwork-wizard',
   \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
   ['source' => 'EXT:sav_network/Resources/Public/Icons/ExtensionWizard.svg']
);

// Adds the page TSConfig for the Wizard Icon
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
    '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:sav_network/Configuration/TsConfig/Page/Mod/Wizards/NewContentElement.tsconfig">'
);

?>
