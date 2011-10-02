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
class Tx_SniNewsletterSubscription_Domain_Model_TtAddress extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string
	 * @validate NotEmpty
	 */
	protected $firstName;

	/**
	 * @var string
	 */
	protected $lastName;

	/**
	 * @var boolean
	 */
	protected $moduleSysDmailHtml;

	/**
	 * @var boolean
	 */
	protected $hidden;

	/**
	 * @var string
	 * @validate EmailAddress, Tx_SniNewsletterSubscription_Domain_Validator_NewsletterValidator
	 */
	protected $email;

	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_SniNewsletterSubscription_Domain_Model_DmailCategory>
	 * @lazy
	 */
	protected $moduleSysDmailCategory;

	public function __construct() {
		$this->setModuleSysDmailCategory(new Tx_Extbase_Persistence_ObjectStorage);
	}

	public function getName() {
		return $this->name;
	}

	/**
	 * @param string $name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getFirstName() {
		return $this->firstName;
	}

	/**
	 * @param string $firstName
	 * @return void
	 */
	public function setFirstName($firstName) {
		$this->firstName = $firstName;
	}

	/**
	 * @return string
	 */
	public function getLastName() {
		return $this->lastName;
	}

	/**
	 * @param string $lastName
	 * @return void
	 */
	public function setLastName($lastName) {
		$this->lastName = $lastName;
	}

	/**
	 * @return string
	 */
	public function getModuleSysDmailHtml() {
		return $this->moduleSysDmailHtml;
	}

	/**
	 * @param string $moduleSysDmailHtml
	 * @return void
	 */
	public function setModuleSysDmailHtml($moduleSysDmailHtml) {
		$this->moduleSysDmailHtml = $moduleSysDmailHtml;
	}

	/**
	 * @return string
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * @param string $email
	 * @return void
	 */
	public function setEmail($email) {
		$this->email = $email;
	}

	/**
	 * @return boolean
	 */
	public function getHidden() {
		return $this->hidden;
	}

	/**
	 * @param boolean $hidden
	 */
	public function setHidden($hidden) {
		$this->hidden = $hidden;
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
		// ACHTUNG: Schleife funkt nur da clone $categories --> siehe http://forge.typo3.org/issues/13147
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
