<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "sni_newsletter_subscription".
 *
 * Auto generated 20-04-2013 17:59
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Newsletter Subscription',
	'description' => 'A newsletter subscription module which creates tt_address records AND takes care of fe_user records as well. Tested with "direct_mail" only. Manual: http://forge.typo3.org/projects/extension-sni_newsletter_subscription/wiki',
	'category' => 'plugin',
	'author' => 'Georg Schoenweger',
	'author_email' => 'info@profi-web.it',
	'author_company' => 'Hard & Software Service Schönweger',
	'shy' => '',
	'dependencies' => 'cms,extbase,fluid',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'beta',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'version' => '1.1.0',
	'constraints' => array(
		'depends' => array(
			'cms' => '',
			'extbase' => '',
			'fluid' => '',
			'typo3' => '4.5.0-4.6.99',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'suggests' => array(
	),
	'_md5_values_when_last_written' => 'a:31:{s:21:"ext_conf_template.txt";s:4:"309a";s:12:"ext_icon.gif";s:4:"e922";s:17:"ext_localconf.php";s:4:"2208";s:14:"ext_tables.php";s:4:"bcf5";s:21:"ExtensionBuilder.json";s:4:"91ea";s:39:"Classes/Controller/SubscrController.php";s:4:"b713";s:38:"Classes/Domain/Model/DmailCategory.php";s:4:"8cad";s:34:"Classes/Domain/Model/TtAddress.php";s:4:"2697";s:29:"Classes/Domain/Model/User.php";s:4:"c3fc";s:53:"Classes/Domain/Repository/DmailCategoryRepository.php";s:4:"5990";s:49:"Classes/Domain/Repository/TtAddressRepository.php";s:4:"9100";s:44:"Classes/Domain/Repository/UserRepository.php";s:4:"2ca6";s:48:"Classes/Domain/Validator/NewsletterValidator.php";s:4:"c8da";s:34:"Classes/Hooks/SrFeuserRegister.php";s:4:"ebdd";s:30:"Classes/Hooks/T3libTcemain.php";s:4:"bedc";s:40:"Classes/Validators/CategoryValidator.php";s:4:"131c";s:39:"Classes/ViewHelpers/ArrayViewHelper.php";s:4:"6645";s:38:"Classes/ViewHelpers/LinkViewHelper.php";s:4:"3f45";s:44:"Configuration/ExtensionBuilder/settings.yaml";s:4:"2aef";s:38:"Configuration/TypoScript/constants.txt";s:4:"6fb6";s:34:"Configuration/TypoScript/setup.txt";s:4:"74a0";s:40:"Resources/Private/Language/locallang.xml";s:4:"9083";s:43:"Resources/Private/Language/locallang_db.xml";s:4:"f03a";s:58:"Resources/Private/Templates/Email/ConfirmSubscription.html";s:4:"928e";s:63:"Resources/Private/Templates/Email/ConfirmSubscriptionPlain.html";s:4:"e17f";s:53:"Resources/Private/Templates/Email/Partials/Style.html";s:4:"bcf0";s:47:"Resources/Private/Templates/Subscr/Confirm.html";s:4:"9900";s:46:"Resources/Private/Templates/Subscr/Create.html";s:4:"df74";s:46:"Resources/Private/Templates/Subscr/Delete.html";s:4:"47a2";s:43:"Resources/Private/Templates/Subscr/New.html";s:4:"19e4";s:35:"Resources/Public/Icons/relation.gif";s:4:"e615";}',
);

?>