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
 * Description of T3libTcemain
 *
 * @author snillo
 */
require_once(t3lib_extMgm::extPath('sni_newsletter_subscription').'Classes/Hooks/SrFeuserRegister.php');
class Tx_SniNewsletterSubscription_Hooks_T3libTcemain {

    /**
    * processDatamap_postProcessFieldArray()
    * this function is called by the Hook in tce from class.t3lib_tcemain.php after processing insert & update database operation
	*
	* LÖSCHE TT_ADDRESS EINTRAGE WELCHE SELBE EMAIL HABEN
    *
    * @param string $status: update or new
    * @param string $table: database table
    * @param string $id: database table
    * @param array $fieldArray: reference to the incoming fields
    * @param object $pObj: page Object reference
    */
    function processDatamap_postProcessFieldArray($status, $table, $id, &$fieldArray, &$pObj){
        global $BE_USER;
        if($table=='fe_users' ) {
			if(t3lib_div::validEmail($fieldArray['email']) && (string)$fieldArray['email'] && strlen($BE_USER->userTS["sni_newsletter_subscription."]["deleteDuplicateAddresesPid"]) > 0) {
				t3lib_div::devLog('A BE-User created manually a fe_user or changed an email address of a fe_user. Delete all tt_address records with same email address ('.($BE_USER->userTS["sni_newsletter_subscription."]["deleteDuplicateAddresesPid"] ? 'where tt_address pid='.$BE_USER->userTS["sni_newsletter_subscription."]["deleteDuplicateAddresesPid"] : 'NO PID CHECK').')','sni_newsletter_subscription',1,$fieldArray);
				Tx_SniNewsletterSubscription_Hooks_SrFeuserRegister::deleteAddresses((string)$fieldArray['email'],$BE_USER->userTS["sni_newsletter_subscription."]["deleteDuplicateAddresesPid"]);
			}
        }
    }

}
?>
