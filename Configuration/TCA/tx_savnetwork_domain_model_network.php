<?php

defined('TYPO3_MODE') or die();

if (version_compare(\YolfTypo3\SavNetwork\Controller\DefaultController::getTypo3Version(), '10.0', '<')) {
    $interface = [
    	'showRecordFieldList' => 'hidden,name,options,nodes'
    ];
} else {
    $interface = [];
}
return [
    'ctrl' => [
        'title' => 'LLL:EXT:sav_network/Resources/Private/Language/locallang_db.xlf:tx_savnetwork_domain_model_network',
        'label' => 'name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l18n_parent',
        'transOrigDiffSourceField' => 'l18n_diffsource',
        'default_sortby' => 'crdate',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'iconfile' => 'EXT:sav_network/Resources/Public/Icons/icon_tx_savnetwork_domain_model_network.gif',
    ],
    'interface' => $interface,
    'columns' => [
        'sys_language_uid' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingleBox',
                'foreign_table' => 'sys_language',
                'foreign_table_where' => 'ORDER BY sys_language.title',
                'items' => [
                    ['LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1],
                    ['LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0]
                ]
            ]
        ],
        'l18n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => (version_compare(\YolfTypo3\SavNetwork\Controller\DefaultController::getTypo3Version(), '10.0', '<') ? 1 : null),
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingleBox',
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_savnetwork_domain_model_network',
                'foreign_table_where' => 'AND tx_savnetwork_domain_model_network.uid=###CURRENT_PID### AND tx_savnetwork_domain_model_network.sys_language_uid IN (-1,0)',
            ]
        ],
        'l18n_diffsource' => [
           'config'=> [
                'type'=>'passthrough'
                ]
        ],
        't3ver_label' => [
            'displayCond' => 'FIELD:t3ver_label:REQ:true',
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type'=>'none',
                'cols' => 27
            ]
        ],
        'hidden' => [
            'exclude' => 1,
            'label'  => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type'  => 'check',
                'default' => 0,
            ]
        ],
        'name' => [
            'exclude' => 1,
            'label'  => 'LLL:EXT:sav_network/Resources/Private/Language/locallang_db.xlf:tx_savnetwork_domain_model_network.name',
            'config' => [
                'type' => 'input',
                'size' => '30',
                'eval' => 'trim,required'
            ],
        ],
        'options' => [
            'exclude' => 1,
            'label'  => 'LLL:EXT:sav_network/Resources/Private/Language/locallang_db.xlf:tx_savnetwork_domain_model_network.options',
            'config' => [
                'type' => 'text',
                'cols' => '30',
                'rows' => '5',
            ],
        ],
        'nodes' => [
            'exclude' => 1,
            'label'  => 'LLL:EXT:sav_network/Resources/Private/Language/locallang_db.xlf:tx_savnetwork_domain_model_network.nodes',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_savnetwork_domain_model_node',
                'foreign_sortby' => 'sorting',
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 999999,
                'MM' => 'tx_savnetwork_domain_model_network_nodes_mm',
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
            'showitem' => 'hidden, name, options, nodes',
        ],
    ],
    'palettes' => [
        '1' => ['showitem' => '']
    ],
];

?>