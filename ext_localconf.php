<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::configurePlugin($_EXTKEY, "Subscr", Array("Subscr" => "new,create,confirm,delete"), Array("Subscr" => "new,create,confirm,delete"));
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['sr_feuser_register']['tx_srfeuserregister_pi1']['registrationProcess'][] = 'EXT:'.$_EXTKEY.'/Classes/Hooks/SrFeuserRegister.php:&Tx_SniNewsletterSubscription_Hooks_SrFeuserRegister';
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['sr_feuser_register']['tx_srfeuserregister_pi1']['confirmRegistrationClass'][] = 'EXT:'.$_EXTKEY.'/Classes/Hooks/SrFeuserRegister.php:&Tx_SniNewsletterSubscription_Hooks_SrFeuserRegister';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] = 'EXT:'.$_EXTKEY.'/Classes/Hooks/T3libTcemain.php:&Tx_SniNewsletterSubscription_Hooks_T3libTcemain';

?>