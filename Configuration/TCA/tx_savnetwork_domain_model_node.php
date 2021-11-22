<?php

defined('TYPO3_MODE') or die();

$typo3Version = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Information\Typo3Version::class);
if (version_compare($typo3Version->getVersion(), '10.0', '<')) {
    $interface = [
    	'showRecordFieldList' => 'hidden,name,options,image,link,edges'
    ];
} else {
    $interface = [];
}
return [
    'ctrl' => [
        'title' => 'LLL:EXT:sav_network/Resources/Private/Language/locallang_db.xlf:tx_savnetwork_domain_model_node',
        'label' => 'name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'default_sortby' => 'crdate',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'iconfile' => 'EXT:sav_network/Resources/Public/Icons/icon_tx_savnetwork_domain_model_node.gif',
    ],
    'interface' => $interface,
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => version_compare(\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Information\Typo3Version::class)->getVersion(), '11.0', '<') ?
            [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'sys_language',
                'items' => [
                    ['LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.allLanguages', -1],
                    ['LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.default_value', 0]
                ],
                'default' => 0,
                'fieldWizard' => [
                    'selectIcons' => [
                        'disabled' => false,
                    ],
                ],
            ] :
            [
          		'type' => 'language'
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['', 0]
                ],
                'foreign_table' => 'sys_file_collection',
                'foreign_table_where' => 'AND sys_file_collection.pid=###CURRENT_PID### AND sys_file_collection.sys_language_uid IN (-1,0)',
            'default' => 0,
            ]
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
                'default' => ''
            ]
        ],
        't3ver_label' => [
            'displayCond' => 'FIELD:t3ver_label:REQ:true',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type'=>'none',
                'cols' => 27
            ]
        ],
        'hidden' => [
            'exclude' => 1,
            'label'  => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf.xlf:LGL.hidden',
            'config' => [
                'type'  => 'check',
                'default' => 0,
            ]
        ],
        'name' => [
            'exclude' => 1,
            'label'  => 'LLL:EXT:sav_network/Resources/Private/Language/locallang_db.xlf:tx_savnetwork_domain_model_node.name',
            'config' => [
                'type' => 'input',
                'size' => '30',
                'eval' => 'trim,required'
            ],
        ],
        'options' => [
            'exclude' => 1,
            'label'  => 'LLL:EXT:sav_network/Resources/Private/Language/locallang_db.xlf:tx_savnetwork_domain_model_node.options',
            'config' => [
                'type' => 'text',
                'cols' => '30',
                'rows' => '5',
            ],
        ],
        'image' => [
            'exclude' => 1,
            'label'  => 'LLL:EXT:sav_network/Resources/Private/Language/locallang_db.xlf:tx_savnetwork_domain_model_node.image',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'image',
                [
                    'maxitems' => 1
                ],
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
                ''
            ),
        ],
        'link' => [
            'exclude' => 1,
            'label'  => 'LLL:EXT:sav_network/Resources/Private/Language/locallang_db.xlf:tx_savnetwork_domain_model_node.link',
            'config' => [
                'type'  => 'input',
                'renderType' => 'inputLink',
                'size'  => '15',
                'max' => '255',
                'checkbox'  => '',
                'eval'  => 'trim',
            ],
        ],
        'edges' => [
            'exclude' => 1,
            'label'  => 'LLL:EXT:sav_network/Resources/Private/Language/locallang_db.xlf:tx_savnetwork_domain_model_node.edges',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_savnetwork_domain_model_edge',
                'foreign_sortby' => 'sorting',
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 999999,
                'MM' => 'tx_savnetwork_domain_model_node_edges_mm',
                'appearance' => [
                    'newRecordLinkPosition' => 'bottom',
                    'collapseAll' => 1,
                    'expandSingle' => 1,
                ],
            ],
        ],
    ],
    'types' => [
        '0' => [
            'showitem' => 'hidden, name, options, image, link, edges',
        ],
    ],
    'palettes' => [
        '1' => ['showitem' => '']
    ],
];

