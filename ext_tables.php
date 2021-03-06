<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

// TODO make cm items configurable via userTS.
// @see: t3lib_contextmenu_pagetree_DataProvider
// @see: get BE user settings from userTS: http://doxygen.frozenkiwi.com/typo3/html/de/d51/class_8clearcachemenu_8php_source.html
if (TYPO3_MODE == 'BE')	{

		// register Ext.Direct provider
	$extPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('sm_clearcachecm');
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerExtDirectComponent(
		'TYPO3.SmClearcachecm.ClickmenuAction',
		$extPath . 'Classes/Hooks/ClickmenuAction.php:T3node\\SmClearcachecm\\Hooks\\ClickmenuAction'
	);

		// Include JS in backend 
	$GLOBALS['TYPO3_CONF_VARS']['typo3/backend.php']['additionalBackendItems'][] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('sm_clearcachecm', 'Classes/Scripts/RegisterJavaScriptForPagetreeAction.php');

		// Add items of the context menu to the default userTS configuration
	$GLOBALS['TYPO3_CONF_VARS']['BE']['defaultUserTSconfig'] .= '
		options.contextMenu.table.pages.items {
			900 {
				1010 = DIVIDER

				1020 = ITEM
				1020 {
					name = clearPageCache
					label = LLL:EXT:sm_clearcachecm/Resources/Private/Language/locallang_cm.xlf:clearPageCache
					# spriteIcon is required for <= 6.2 compatibility
					spriteIcon = actions-system-cache-clear-impact-low
					# iconName is required from >= 7.6
					iconName = actions-system-cache-clear
					callbackAction = clearPageCache
				}
			}
			1000 {
				410 = DIVIDER

				420 = ITEM
				420 {
					name = clearBranchCache
					label = LLL:EXT:sm_clearcachecm/Resources/Private/Language/locallang_cm.xlf:clearBranchCache
					# spriteIcon is required for <= 6.2 compatibility
					spriteIcon = actions-system-cache-clear-impact-low
					# iconName is required from >= 7.6
					iconName = actions-system-cache-clear
					callbackAction = clearBranchCache
				}
			}
		}
	';
}
