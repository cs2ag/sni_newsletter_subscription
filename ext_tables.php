<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::registerPlugin($_EXTKEY, "Subscr", "Subscription module for Newsletter");

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'sni_newsletter_subscription');


?>