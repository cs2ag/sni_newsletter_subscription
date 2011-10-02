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
 * Description of SrFeuserRegister
 *
 * @author snillo
 */
class Tx_SniNewsletterSubscription_Hooks_SrFeuserRegister {

	/**
 	 * HOOK Wird aufgerufen kurz nachdem FE-User in DB erstellt wurde (CREATE,INVITE)
	 * Lösche alle tt_address Einträge mit selber E-Mail Addresse
	 */
	public function registrationProcess_afterSaveCreate($newRow, &$parent) {
		if(!$newRow['disable'] && strlen($parent->conf['sniAddressPid']) > 0) {
			// CREATE  --> wenn wir disabled sind dann müssen wir erster Confirmen bevor Adressen gelöscht werden sollen. siehe Hook unten
			t3lib_div::devLog('A user has created an account (fe_user). Delete all tt_address records with same email address ('.($parent->conf['sniAddressPid'] ? 'where tt_address pid='.$parent->conf['sniAddressPid'] : 'NO PID CHECK').')','sni_newsletter_subscription',1,$newRow);
			self::deleteAddresses($newRow['email'],$parent->conf['sniAddressPid']);			
		}
	}

	/**
	 * Hook wird aufgerufen nachdem Registration confirmed wurde (bei kickboxing nur bei INVITE ..)
	 */
	public function confirmRegistrationClass_postProcess($row, &$parent) {
		if(strlen($parent->conf['sniAddressPid']) > 0) {
			t3lib_div::devLog('A user has confirmed his account (fe_user). Delete all tt_address records with same email address ('.($parent->conf['sniAddressPid'] ? 'where tt_address pid='.$parent->conf['sniAddressPid'] : 'NO PID CHECK').')','sni_newsletter_subscription',1,$row);
			self::deleteAddresses($row['email'],$parent->conf['sniAddressPid']);
		}
	}

	/**
	 * Löscht alle tt_address Eintrage welche $email im E-Mail Feld haben
	 * ACHTUNG: wird auch in T3libTcemain Hook Klasse ausgeführt -- deshalb statische Funktion
	 * 
	 * @param string $email
	 * @param mixed $pid entweder PID oder 'ALL' (pid wird dann nicht überprüft)
	 */
	public static function deleteAddresses($email,$pid) {
		$table = 'tt_address';
		$where = 'email="'.(string)$email.'"';
		if(intval($pid) && $pid != 'ALL') {
			$where .= ' AND pid='.intval($pid);
		}
		$GLOBALS['TYPO3_DB']->exec_DELETEquery($table,$where);		
	}

}
?>
