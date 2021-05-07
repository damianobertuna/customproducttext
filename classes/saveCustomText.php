<?php
/**
* 2007-2021 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2021 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

define('_EXTERNAL_SCRIPT_', 'true');
include_once(dirname(__FILE__).'/../../../config/config.inc.php');
include_once(dirname(__FILE__).'/../../../init.php');
include_once(dirname(__FILE__).'/../../../classes/Configuration.php');

$idProduct      = (int)Tools::getValue("idProduct");
$customText     = Tools::getValue("customText");
$idEmployee     = (int)(Tools::getValue("idEmployee"));
$res            = false;

$token = Tools::getAdminToken('AdminProducts'.(int)Tab::getIdFromClassName('AdminProducts').$idEmployee);

if (Tools::getValue("secureToken") != $token) {
    echo false;
    die();
}

$searchQuery = 'SELECT `id_product` FROM '._DB_PREFIX_.'customproducttext WHERE `id_product` = '.pSQL(intval($idProduct));
$product = Db::getInstance()->executeS($searchQuery);

if (count($product) == 0) {
    $res = Db::getInstance()->insert('customproducttext', array(
        'id_product'      => pSQL(intval($idProduct)),
        'custom_text'     => pSQL($customText),
    ));
} else {
    $updateQuery = 'UPDATE '._DB_PREFIX_.'customproducttext SET custom_text = "'.pSQL($customText).'" WHERE `id_product` = '.pSQL(intval($idProduct));
    $res = Db::getInstance()->execute($updateQuery);
}

echo $res;
