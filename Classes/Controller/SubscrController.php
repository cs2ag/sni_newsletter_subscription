<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011 Georg Schönweger <info@profi-web.it>, Hard & Software Service Schönweger
*  
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 3 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

class Tx_SniNewsletterSubscription_Controller_SubscrController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * @var Tx_SniNewsletterSubscription_Domain_Repository_TtAddressRepository
	 */
	protected $addressRepository;

	/**
	 * @param Tx_SniNewsletterSubscription_Domain_Repository_TtAddressRepository $addressRepository
 	 * @return void
	 */
	public function injectAddressRepository(Tx_SniNewsletterSubscription_Domain_Repository_TtAddressRepository $addressRepository) {
		$this->addressRepository = $addressRepository;
	}

	/**
	 * Wird aufgerufen um Subscription zu bestätigen
	 */
	public function confirmAction() {
		$table = t3lib_div::_GP('t');
		$uid = (int)t3lib_div::_GP('u');
		if($uid && t3lib_div::stdAuthCode($uid) == t3lib_div::_GP('a')) {
			switch ($table) {
				case 'fe_users':
					$userRepository = t3lib_div::makeInstance('Tx_SniNewsletterSubscription_Domain_Repository_UserRepository');
					$subscriber = $userRepository->findByUid($uid);
					if($subscriber) {
						if(count($subscriber->getModuleSysDmailCategory()) <= 0) { // ansonsten hat sich der User zwischenzeitlich schon über My Account am Newsletter angemeldet bzw. händisch.
							$dmailCategoryRepository = t3lib_div::makeInstance('Tx_SniNewsletterSubscription_Domain_Repository_DmailCategoryRepository');
							$categories = $dmailCategoryRepository->findByUids(explode(',',t3lib_div::_GP('c')));
							if(count($categories) > 0) {
								$subscriber->addAllModuleSysDmailCategory($categories);
							}
							else {
								$this->view->assign('error',TRUE);
							}
						}
					}
					else {
						$this->view->assign('error',TRUE);
					}
				break;
				case 'tt_address':
					$subscriber = $this->addressRepository->findAlsoHiddenByUid($uid);
					if($subscriber) {
						$dmailCategoryRepository = t3lib_div::makeInstance('Tx_SniNewsletterSubscription_Domain_Repository_DmailCategoryRepository');
						$categories = $dmailCategoryRepository->findByUids(explode(',',t3lib_div::_GP('c')));
						if(count($categories) > 0) {
							$subscriber->addAllModuleSysDmailCategory($categories);
							$subscriber->setHidden(FALSE);
						}
						else {
							$this->view->assign('error',TRUE);
						}
					}
					else {
						$this->view->assign('error',TRUE);
					}
				break;
				default:
					$this->view->assign('error',TRUE);
				break;
			}
			$this->view->assign('subscriber',$subscriber);
		}
		else {
			$this->view->assign('error',TRUE);
		}
	}

	/**
	 * Wird aufgerufen um Subscription zu löschen
	 */
	public function deleteAction() {
		$table = t3lib_div::_GP('t');
		$uid = (int)t3lib_div::_GP('u');
		if($uid && t3lib_div::stdAuthCode($uid) == t3lib_div::_GP('a')) {
			switch ($table) {
				// Direct Mail gibt bei Plaintext Messages als ###SYS_TABLE_NAME### nur den ersten Buchstaben der Tabelle an, bei HTML Mail den kompletten Tabellennamen
				case 'fe_users':
				case 'f':
					$userRepository = t3lib_div::makeInstance('Tx_SniNewsletterSubscription_Domain_Repository_UserRepository');
					$subscriber = $userRepository->findByUid($uid);
					if($subscriber) {
						if(count($subscriber->getModuleSysDmailCategory()) > 0) {
							$subscriber->removeAllModuleSysDmailCategory();
						}
					}
					else {
						$this->view->assign('error',TRUE);
					}
				break;
				case 'tt_address':
				case 't':
					$subscriber = $this->addressRepository->findAlsoHiddenByUid($uid);
					if($subscriber) {
						$this->addressRepository->remove($subscriber);
					}
					else {
						$this->view->assign('error',TRUE);
					}
				break;
				default:
					$this->view->assign('error',TRUE);
				break;
			}
			$this->view->assign('subscriber',$subscriber);
		}
		else {
			$this->view->assign('error',TRUE);
		}
	}

	/**
	 * @param Tx_SniNewsletterSubscription_Domain_Model_TtAddress $newAddress
	 * @param array $moduleSysDmailCategory Category Array; Ist hier als eigener Parameter angegeben da Bugs mit <f:form.checkbox /> --> siehe http://forge.typo3.org/issues/9214
	 * @param boolean $moduleSysDmailHtml Ist hier als eigener Parameter angegeben da Bugs mit <f:form.checkbox /> --> siehe http://forge.typo3.org/issues/9214
	 * @dontvalidate $newAddress
	 */
	public function newAction($newAddress = NULL, $moduleSysDmailCategory = Array(), $moduleSysDmailHtml = FALSE) {
		if(t3lib_div::_GP('w') && t3lib_div::_GP('a') && t3lib_div::_GP('u') && t3lib_div::_GP('t')) {
			// Wir sind eine Confirmation / Delete Subscription Anfrage .. leite an jeweiligen Controller weiter (action ist mit &w=d oder &w=c abgekürzt damit nicht so lange url. newAction ist default action..)
			switch (t3lib_div::_GP('w')) {
				case 'c':
					$this->forward('confirm');
				break;
				case 'd':
					$this->forward('delete');
				break;
			}
		}
		if(count(t3lib_div::_GP('tx_sninewslettersubscription_subscr')) <= 0) {
			$this->view->assign('firstCall', TRUE);
		}
		else {
			$this->view->assign('firstCall', FALSE);
		}
		$dmailCategoryRepository = t3lib_div::makeInstance('Tx_SniNewsletterSubscription_Domain_Repository_DmailCategoryRepository');
		$categories = $dmailCategoryRepository->findByPid(explode(',',$this->settings['module_sys_dmail_category_PIDLIST']));
		$this->view->assign('categories', $categories);
		$this->view->assign('gp', $this->request->getArguments());
		$this->view->assign('newAddress', $newAddress);
	}

	/**
	 * Hierher wird nur gesprungen wenn wir mit $newAddress->email noch nicht gesubscribed sind (@see Tx_SniNewsletterSubscription_Domain_Validator_NewsletterValidator)
	 * @param Tx_SniNewsletterSubscription_Domain_Model_TtAddress $newAddress
	 * @param array $moduleSysDmailCategory Category Array; Ist hier als eigener Parameter angegeben da Bugs mit <f:form.checkbox /> --> siehe http://forge.typo3.org/issues/9214
	 * @param boolean $moduleSysDmailHtml Ist hier als eigener Parameter angegeben da Bugs mit <f:form.checkbox /> --> siehe http://forge.typo3.org/issues/9214
	 * @validate $moduleSysDmailCategory Tx_SniNewsletterSubscription_Validators_CategoryValidator
	 */
	public function createAction(Tx_SniNewsletterSubscription_Domain_Model_TtAddress $newAddress, $moduleSysDmailCategory = Array(), $moduleSysDmailHtml=FALSE) {
		$userRepository = t3lib_div::makeInstance('Tx_SniNewsletterSubscription_Domain_Repository_UserRepository');
		$user = $userRepository->findByEmail($newAddress->getEmail());
		if($user) {
			// User existiert bereits, fe_users Feld moduleSysDmailHtml über Link in Confirmation upzudaten!
			$updateTable = 'fe_users';
			$subscriber = $user;
		}
		else {
			$updateTable = 'tt_address';
			$hiddenAddress = $this->addressRepository->findEmail($newAddress->getEmail(), FALSE);
			if($hiddenAddress) {
				// Versteckter tt_address Datensatz existiert bereits, tt_address Feld hidden über Link in Confirmation upzudaten!
				// Ein versteckter Datensatz existiert z.B. wenn wir das Formular 2 mal mit selber E-Mail Adresse abschicken ohne eine Confirmation Mail zu bestätigen
				$subscriber = $hiddenAddress;
			}
			else {
				// Trage tt_address Datensatz ein, tt_address Feld hidden über Link in Confirmation updzudaten!
				$newAddress->setModuleSysDmailHtml((boolean)$moduleSysDmailHtml);
				$newAddress->setHidden(TRUE);
				$newAddress->setName($newAddress->getFirstName().($newAddress->getLastName() ? ' '.$newAddress->getLastName() : ''));
				$this->addressRepository->add($newAddress);
				// Persistiere schon hier wir brauchen nemlich die UID vom neu angelgten tt_address Eintrag
				$persistenceManager = t3lib_div::makeInstance('Tx_Extbase_Persistence_Manager');
				$persistenceManager->persistAll();
				$subscriber = $newAddress;
			}
		}
		// Versende Confirmation Mail an user
		$mailTitle = $this->translate('subscribeMailTitle',Array($this->settings['siteName']));
		$mailFrom = Array($this->settings['fromMail'] => $this->settings['fromName']);
		$mailTo = Array($subscriber->getEmail() => $subscriber->getFirstName());
		$authCode = t3lib_div::stdAuthCode($subscriber->getUid());	
		$fluidData = Array(
			'subscriber' => $subscriber,
			'deleteParams' => Array('w' => 'd', 't' => $updateTable, 'u' => $subscriber->getUid(), 'a' => $authCode),
			'confirmParams' => Array('w' => 'c', 't' => $updateTable, 'u' => $subscriber->getUid(), 'a' => $authCode, 'c' => implode(',',$moduleSysDmailCategory)),
		);
		$contentType = ($moduleSysDmailHtml ? 'text/html' : 'text/plain');
		$this->sendTemplateEmail($mailTo, $mailFrom, $mailTitle, 'ConfirmSubscription', $fluidData, $contentType);
		$this->view->assign('feUserUpdatet',$feUserUpdatet);
		$this->view->assign('address',$newAddress);
	}

	/**
	 * @param string $recipient array('john@doe.ch' => 'John Doe');
	 * @param string $sender array('contact@example.com' => 'Example Sender');
     * @param string $subject
     * @param string $templateName
     * @param array $variables
     * @return boolean TRUE on success, otherwise false
     */
	protected function sendTemplateEmail($recipient, $sender, $subject, $templateName, array $variables = array(), $contentType = 'text/html') {
	    $emailView = $this->objectManager->create('Tx_Fluid_View_StandaloneView');
		$emailView->setFormat('html');
		$extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(Tx_Extbase_Configuration_ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
		$templateRootPath = t3lib_div::getFileAbsFileName($extbaseFrameworkConfiguration['view']['templateRootPath']);
		$templatePathAndFilename = $templateRootPath . 'Email/' . $templateName . '.html';
		$emailView->setTemplatePathAndFilename($templatePathAndFilename);
		$extensionName = $this->request->getControllerExtensionName();
		$emailView->getRequest()->setControllerExtensionName($extensionName);
		$emailView->assignMultiple($variables);
		$emailView->assign('settings', $this->settings);
		$emailBody = $emailView->render();

		if(is_file($templateRootPath . 'Email/' . $templateName . 'Plain.html')) {
			$plainView = $this->objectManager->create('Tx_Fluid_View_StandaloneView');
			$plainView->setFormat('html');
			$plainView->setTemplatePathAndFilename($templateRootPath . 'Email/' . $templateName . 'Plain.html');
			$plainView->getRequest()->setControllerExtensionName($extensionName);
			$plainView->assignMultiple($variables);
			$plainView->assign('settings', $this->settings);
			$plainBody = strip_tags(str_replace(Array("<br>","<br />","<br/>"),"\n",$plainView->render()));
		}

		$message = t3lib_div::makeInstance('t3lib_mail_Message');
		$message->setTo($recipient)
			->setFrom($sender)
			->setSubject($subject);

		if($contentType == 'text/plain' && $plainBody) {
			// PLAIN Email
			$message->setBody($plainBody, $contentType);
		}
		else {
			// HTML Email
			$message->setBody($emailBody, $contentType);
			if($plainBody) {
				$message->addPart($plainBody, 'text/plain');
			}
		}

		$message->send();
		return ($message->isSent());
	}

	protected function translate($key,array $arguments = NULL) {
		$extensionName = $this->request->getControllerExtensionName();
		$value = Tx_Extbase_Utility_Localization::translate($key, $extensionName, $arguments);
		return $value;
	}
}
?>