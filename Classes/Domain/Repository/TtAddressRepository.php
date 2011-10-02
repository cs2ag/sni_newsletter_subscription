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
class Tx_SniNewsletterSubscription_Domain_Repository_TtAddressRepository extends Tx_Extbase_Persistence_Repository {

	/**
	 * Sucht in tt_address nach $email.
	 * Normale Extbase PID Einstellungen greifen für tt_address Datensätze. Es kann somit nicht zu Konflikt mit anderen Extensions kommen kann die auch tt_address verwenden ...
	 * @param boolean $enableFields falls FALSE dann wird nur deleted=0 berücksichtigt (hidden wird ignoriert)
	 */
	public function findEmail($email,$enableFields=TRUE,$getFirst=TRUE) {
		$query = $this->createQuery();		
		$constraints = Array();
		if(!$enableFields) {
			$query->getQuerySettings()->setRespectEnableFields(FALSE);
			$constraints[] = $query->equals('deleted', 0);
		}
		$constraints[] = $query->equals('email',$email);
		$query->matching($query->logicalAnd($constraints));
		if($getFirst) {
			return ($query->execute()->getFirst());
		}
		else {
			return ($query->execute());
		}
	}

	public function findAlsoHiddenByUid($uid) {
		$query = $this->createQuery();
		$query->getQuerySettings()->setRespectEnableFields(FALSE);
		$query->matching($query->logicalAnd(
			$query->equals('deleted',0),
			$query->equals('uid', (int)$uid)
		));
		return ($query->execute()->getFirst());
	}

}
?>
