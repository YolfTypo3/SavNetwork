<?php
namespace YolfTypo3\SavNetwork\Controller;

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
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Extbase\Configuration\FrontendConfigurationManager;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Default Controller
 */
class DefaultController extends ActionController
{

    /**
     * Css path
     *
     * @var string
     */
    protected static $cssRootPath = 'Resources/Public/Css';

    /**
     * js root path
     *
     * @var string
     */
    protected static $javaScriptRootPath = 'Resources/Public/JavaScript';

    /**
     * networkRepository
     *
     * @TYPO3\CMS\Extbase\Annotation\Inject
     * @var \YolfTypo3\SavNetwork\Domain\Repository\NetworkRepository
     * @extensionScannerIgnoreLine
     * @inject
     */
    protected $networkRepository;

    /**
     * Network name
     *
     * @var string
     */
    protected $networkName;

    /**
     * Initializes the controller before invoking an action method.
     *
     * @return void
     */
    protected function initializeAction()
    {
        // Gets the extension key
        $extensionKey = $this->request->getControllerExtensionKey();

        // Checks if the static extension template is included
        /** @var FrontendConfigurationManager $frontendConfigurationManager */
        $frontendConfigurationManager = GeneralUtility::makeInstance(FrontendConfigurationManager::class);
        $typoScriptSetup = $frontendConfigurationManager->getTypoScriptSetup();
        $pluginSetupName = 'tx_' . strtolower($this->request->getControllerExtensionName()) . '.';
        if (! @is_array($typoScriptSetup['plugin.'][$pluginSetupName]['view.'])) {
            die('Fatal error: You have to include the static template of the extension ' . $extensionKey . '.');
        }

        // Gets the network from the flexform settings
        $netWorkUid = $this->settings['flexform']['network'];
        $network = $this->networkRepository->findByUid($netWorkUid);

        if ($network === null) {
            if ($this->controllerContext === null) {
                $this->controllerContext = $this->buildControllerContext();
            }
            $this->addFlashMessage(LocalizationUtility::translate('error.unknownNetwork', $extensionKey));
            return;
        }

        // Sets the network name
        $this->networkName = str_replace(' ', '', ucwords($network->getName()));

        $javaScript = [];
        $links = [];
        $javaScript[] = 'var ' . $this->networkName . ';';
        $javaScript[] = 'function getNetworkData' . $this->networkName . '() {';
        $javaScript[] = '  var nodes = [];';
        $javaScript[] = '  var edges = [];';

        // Processes the nodes
        foreach ($network->getNodes() as $node) {
            // Prepares the node and the link options
            $nodeOptions = [];

            $linkOptions = [];

            // Adds the node id
            $nodeOptions[] = $this->formatConfiguration('id', $node->getUid());

            // Adds the label by default. Its can be overrided by using label='' in the option
            $nodeOptions[] = $this->formatConfiguration('label', $node->getName());

            // Adds the image if it exists
            $image = $node->getImage();
            if ($image->count() === 1) {
                $nodeOptions[] = $this->formatConfiguration('image', $image->current()
                    ->getOriginalResource()
                    ->getPublicUrl());
                $nodeOptions[] = $this->formatConfiguration('shape', 'image');
            }

            // Sets the link if it exists
            if (! empty($node->getLink())) {
                $linkOptions[] = $this->formatConfiguration('id', $node->getUid());
                $linkOptions[] = $this->formatConfiguration('link', $this->configurationManager->getContentObject()
                    ->typoLink_URL([
                    'parameter' => $node->getLink()
                ]));
                if (strpos($node->getLink(), '_blank') !== false) {
                    $linkOptions[] = $this->formatConfiguration('target', '_blank');
                }
                $links[] = '  links.push({' . implode(',', $linkOptions) . '});';
            }

            // Adds the node options
            $nodeOptions[] = str_replace([
                '\n',
                '\r'
            ], '', $node->getOptions());

            // Adds the nodes to the javascript
            $javaScript[] = '  nodes.push({' . implode(',', $nodeOptions) . '});';

            // Processes the edges
            foreach ($node->getEdges() as $edge) {
                // Prepares the edge configuration
                if ($edge->getFromNode() !== null && $edge->getToNode() !== null) {
                    $edgeOptions = [];

                    // Adds the from and to nodes id
                    $edgeOptions[] = $this->formatConfiguration('from', $edge->getFromNode()
                        ->getUid());
                    $edgeOptions[] = $this->formatConfiguration('to', $edge->getToNode()
                        ->getUid());

                    // Adds the edge options
                    $edgeOptions[] = str_replace([
                        '\n',
                        '\r'
                    ], '', $edge->getOptions());

                    // Adds the edge to the javascript
                    $javaScript[] = '  edges.push({' . implode(',', $edgeOptions) . '});';
                }
            }
        }
        $javaScript[] = '  return {nodes:nodes,edges:edges};';
        $javaScript[] = '}';

        // Adds the getNetworkOptions function
        $javaScript[] = 'function getNetworkOptions' . $this->networkName . '() {';
        $javaScript[] = '  var options = {';
        $javaScript[] = '    interaction:{hover:true},';
        $javaScript[] = str_replace([
            '\n',
            '\r'
        ], '', $network->getOptions());
        $javaScript[] = '  };';
        $javaScript[] = '  return options;';
        $javaScript[] = '}';

        // Adds the getNetworkLinks function
        $javaScript[] = 'function getNetworkLinks' . $this->networkName . '() {';
        $javaScript[] = '  var links = [];';
        $javaScript[] = implode(chr(10), $links);
        $javaScript[] = '  return links;';
        $javaScript[] = '}';

        // Creates the network
        $javaScript[] = $this->networkName . ' = new vis.Network(document.getElementById(\'' . $this->networkName . '\'), getNetworkData' . $this->networkName . '(), getNetworkOptions' . $this->networkName . '());';

        // Adds the on click function
        $javaScript[] = $this->networkName . '.on(\'click\', function (parameter) {';
        $javaScript[] = '    getNetworkLinks' . $this->networkName . '().map(function (link) {';
        $javaScript[] = '        if (link.id == parameter.nodes ) {';
        $javaScript[] = '            var url = link.link;';
        $javaScript[] = '            if(!/^((http|https|ftp):\/\/)/.test(url)) {';
        $javaScript[] = '                url = location.protocol + \'//\' + location.host + \'/\' + url;';
        $javaScript[] = '            } ';
        $javaScript[] = '            if (link.target == \'_blank\') {';
        $javaScript[] = '                window.open(url, link.target);';
        $javaScript[] = '            } else {';
        $javaScript[] = '                window.location = url;';
        $javaScript[] = '            }';
        $javaScript[] = '        } else {';
        $javaScript[] = '            return false;';
        $javaScript[] = '        }';
        $javaScript[] = '    });';
        $javaScript[] = '});';

        // Adds the on hoverNode function
        $javaScript[] = $this->networkName . '.on(\'hoverNode\', function (parameter) {';
        $javaScript[] = '    getNetworkLinks' . $this->networkName . '().map(function (link) {';
        $javaScript[] = '        if (link.id == parameter.node) {';
        $javaScript[] = '            document.getElementById(\'' . $this->networkName . '\').style.cursor = \'pointer\';';
        $javaScript[] = '        }';
        $javaScript[] = '    });';
        $javaScript[] = '});';

        // Adds the on blurNode function
        $javaScript[] = $this->networkName . '.on(\'blurNode\', function (parameter) {';
        $javaScript[] = '    getNetworkLinks' . $this->networkName . '().map(function (link) {';
        $javaScript[] = '        if (link.id == parameter.node) {';
        $javaScript[] = '            document.getElementById(\'' . $this->networkName . '\').style.cursor = \'default\';';
        $javaScript[] = '        }';
        $javaScript[] = '    });';
        $javaScript[] = '});';

        // Adds a scrolling handler
        $javaScript[] = 'if (!' . $this->networkName . '.interactionHandler.options.zoomView) {';
        $javaScript[] = '    document.getElementById(\'' . $this->networkName . '\').addEventListener(\'wheel\', wheelHandler);';
        $javaScript[] = '}';
        $javaScript[] = 'function wheelHandler(e) {';
        $javaScript[] = '    if (e.deltaY > 0) {';
        $javaScript[] = '        deltaY = 60;';
        $javaScript[] = '    } else {';
        $javaScript[] = '        deltaY = -60;';
        $javaScript[] = '    }';
        $javaScript[] = '    window.scrollBy(0, deltaY);';
        $javaScript[] = '}';

        // Adds the latest javascript file
        $javaScriptRootDirectory = ExtensionManagementUtility::extPath($extensionKey) . self::$javaScriptRootPath;
        $extensionWebPath = self::getExtensionWebPath($extensionKey);
        $javaScriptFooterFile = $extensionWebPath . self::$javaScriptRootPath . '/' . $this->getLatestVersionInDirectory($javaScriptRootDirectory);
        $this->addJavaScriptFooterFile($javaScriptFooterFile);

        // Adds the latest css file
        $cssRootDirectory = ExtensionManagementUtility::extPath($extensionKey) . self::$cssRootPath;
        $extensionWebPath = self::getExtensionWebPath($extensionKey);
        $cssFile = $extensionWebPath . self::$cssRootPath . '/' . $this->getLatestVersionInDirectory($cssRootDirectory);
        $this->addCascadingStyleSheet($cssFile);

        // Adds the inline javaScript
        $this->addJavaScriptFooterInlineCode(uniqid(), implode(chr(10), $javaScript));
    }

    /**
     * show action
     *
     * @return void
     */
    public function showAction()
    {
        $this->view->assign('networkName', $this->networkName);
    }

    /**
     * Formats a configuration
     *
     * @param string $key
     * @param mixed $value
     *
     * @return string
     */
    protected function formatConfiguration(string $key, $value): string
    {
        if (is_string($value)) {
            $value = '\'' . $value . '\'';
        }
        return $key . ':' . $value;
    }

    /**
     * Adds a javaScript file
     *
     * @param string $javaScriptFileName
     *
     * @return void
     */
    protected function addJavaScriptFooterFile(string $javaScriptFileName)
    {
        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $pageRenderer->addJsFooterFile($javaScriptFileName);
    }

    /**
     * Adds a javaScript inline code
     *
     * @param string $javaScriptFileName
     *
     * @return void
     */
    protected function addJavaScriptFooterInlineCode(string $key, string $javaScriptInlineCode)
    {
        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $pageRenderer->addJsFooterInlineCode($key, $javaScriptInlineCode);
    }

    /**
     * Adds a cascading style Sheet
     *
     * @param string $cascadingStyleSheet
     *
     * @return void
     */
    protected function addCascadingStyleSheet(string $cascadingStyleSheet)
    {
        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $pageRenderer->addCssFile($cascadingStyleSheet);
    }

    /**
     * Gets the relative web path of a given extension.
     *
     * @param string $extension
     *            The extension
     *
     * @return string The relative web path
     */
    protected static function getExtensionWebPath(string $extension): string
    {
        $extensionWebPath = PathUtility::getAbsoluteWebPath(ExtensionManagementUtility::extPath($extension));
        if ($extensionWebPath[0] === '/') {
            // Makes the path relative
            $extensionWebPath = substr($extensionWebPath, 1);
        }
        return $extensionWebPath;
    }

    /**
     * Gets latest version in a directroy containing version of a file
     *
     * @param string $directory
     *            The directory
     *
     * @return string The file
     */
    protected function getLatestVersionInDirectory(string $directory): string
    {
        $files = scandir($directory);
        sort($files); // For unknown reason scandir does not sort the array on my computer
        $count = count($files);
        return $files[$count - 1];
    }
}
?>

