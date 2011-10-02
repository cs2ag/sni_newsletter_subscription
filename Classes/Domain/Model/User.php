<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2011 Georg Schönweger <georg.schoenweger@gmail.com>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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
/**
 * Description of User
 *
 * @author snillo
 */
class Tx_SniNewsletterSubscription_Domain_Model_User extends Tx_Extbase_Domain_Model_FrontendUser {

	/**
	 * @var boolean
	 */
	protected $moduleSysDmailNewsletter;

	/**
	 * @var boolean
	 */
	protected $moduleSysDmailHtml;

	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_SniNewsletterSubscription_Domain_Model_DmailCategory>
	 * @lazy
	 */
	protected $moduleSysDmailCategory;

	
	public function __construct() {
		$this->setModuleSysDmailCategory(new Tx_Extbase_Persistence_ObjectStorage);
	}

	/**
	 * @return boolean
	 */
	public function getModuleSysDmailNewsletter() {
		return $this->moduleSysDmailNewsletter;
	}

	/**
	 * @param boolean $moduleSysDmailNewsletter
	 */
	public function setModuleSysDmailNewsletter($moduleSysDmailNewsletter) {
		$this->moduleSysDmailNewsletter = $moduleSysDmailNewsletter;
	}

	/**
	 * @return boolean
	 */
	public function getModuleSysDmailHtml() {
		return $this->moduleSysDmailHtml;
	}

	/**
	 * @param boolean $moduleSysDmailHtml
	 */
	public function setModuleSysDmailHtml($moduleSysDmailHtml) {
		$this->moduleSysDmailHtml = $moduleSysDmailHtml;
	}

	/**
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_SniNewsletterSubscription_Domain_Model_DmailCategory>
	 */
	public function getModuleSysDmailCategory() {
		return clone $this->moduleSysDmailCategory;
	}

	/**
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_SniNewsletterSubscription_Domain_Model_DmailCategory> $moduleSysDmailCategory
	 */
	public function setModuleSysDmailCategory(Tx_Extbase_Persistence_ObjectStorage $moduleSysDmailCategory) {
		$this->moduleSysDmailCategory = $moduleSysDmailCategory;
	}

	/**
	 * Adds a category
	 *
	 * @param Tx_SjrOffers_Domain_Model_Category The category to be added
	 * @return void
	 */
	public function addModuleSysDmailCategory(Tx_SniNewsletterSubscription_Domain_Model_DmailCategory $moduleSysDmailCategory) {
		$this->moduleSysDmailCategory->attach($moduleSysDmailCategory);
	}

	/**
	 * Remove a category from the offer
	 *
	 * @param Tx_SjrOffers_Domain_Model_Category The category to be removed
	 * @return void
	 */
	public function removeModuleSysDmailCategory(Tx_SniNewsletterSubscription_Domain_Model_DmailCategory $moduleSysDmailCategory) {
		$this->moduleSysDmailCategory->detach($moduleSysDmailCategory);
	}

	/**
	 * Removes all Categorys from current record
	 */
	public function removeAllModuleSysDmailCategory() {
		foreach ($this->getModuleSysDmailCategory() as $item) {
			$this->removeModuleSysDmailCategory($item);
		}
	}

	/**
	 * Fügt alle Category-Objekte welche QueryResult beinhaltet hinzu
	 * @param Tx_Extbase_Persistence_QueryResult $categories
	 */
	public function addAllModuleSysDmailCategory(Tx_Extbase_Persistence_QueryResult $categories) {
		foreach ($categories as $category) {
			$this->addModuleSysDmailCategory($category);
		}
	}

}
?>
