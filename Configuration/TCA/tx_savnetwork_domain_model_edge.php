<?php

defined('TYPO3_MODE') or die();

if (version_compare(\YolfTypo3\SavNetwork\Controller\DefaultController::getTypo3Version(), '10.0', '<')) {
    $interface = [
    	'showRecordFieldList' => 'hidden,from_node,to_node,options'
    ];
} else {
    $interface = [];
}
return [
    'ctrl' => [
        'title' => 'LLL:EXT:sav_network/Resources/Private/Language/locallang_db.xlf:tx_savnetwork_domain_model_edge',
        'label' => 'uid',
        'label_userFunc' => 'YolfTypo3\\SavNetwork\\UserFunctions\\LabelUserFunction->edgeLabel',
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
        'iconfile' => 'EXT:sav_network/Resources/Public/Icons/icon_tx_savnetwork_domain_model_edge.gif',
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
                'foreign_table' => 'tx_savnetwork_domain_model_edge',
                'foreign_table_where' => 'AND tx_savnetwork_domain_model_edge.uid=###CURRENT_PID### AND tx_savnetwork_domain_model_edge.sys_language_uid IN (-1,0)',
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
        'from_node' => [
            'exclude' => 1,
            'label'  => 'LLL:EXT:sav_network/Resources/Private/Language/locallang_db.xlf:tx_savnetwork_domain_model_edge.from_node',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['LLL:EXT:sav_network/Resources/Private/Language/locallang_db.xlf:tx_savnetwork_domain_model_edge.from_node.I.0', 0],
                ],
                'foreign_table' => 'tx_savnetwork_domain_model_node',
                'foreign_table_where' => 'AND tx_savnetwork_domain_model_node.pid=###CURRENT_PID### AND tx_savnetwork_domain_model_node.sys_language_uid IN (-1,0) ',
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],
        'to_node' => [
            'exclude' => 1,
            'label'  => 'LLL:EXT:sav_network/Resources/Private/Language/locallang_db.xlf:tx_savnetwork_domain_model_edge.to_node',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['LLL:EXT:sav_network/Resources/Private/Language/locallang_db.xlf:tx_savnetwork_domain_model_edge.to_node.I.0', 0],
                ],
                'foreign_table' => 'tx_savnetwork_domain_model_node',
                'foreign_table_where' => 'AND tx_savnetwork_domain_model_node.pid=###CURRENT_PID### AND tx_savnetwork_domain_model_node.sys_language_uid IN (-1,0) ',
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],
        'options' => [
            'exclude' => 1,
            'label'  => 'LLL:EXT:sav_network/Resources/Private/Language/locallang_db.xlf:tx_savnetwork_domain_model_edge.options',
            'config' => [
                'type' => 'text',
                'cols' => '30',
                'rows' => '5',
            ],
        ],
    ],
    'types' => [
        '0' => [
            'showitem' => 'hidden, from_node, to_node, options',
        ],
    ],
    'palettes' => [
        '1' => ['showitem' => '']
    ],
];

?>