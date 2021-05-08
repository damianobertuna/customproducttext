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

if (!defined('_PS_VERSION_')) {
    exit;
}

class Customproducttext extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'customproducttext';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'DAMIANO BERTUNA';
        $this->need_instance = 0;
        $this->_html = '';
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Custom text for your products');
        $this->description = $this->l('The module lets you to create a custom text on the product page');

        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
    }

    public function install()
    {
        include(dirname(__FILE__).'/sql/install.php');

        return parent::install() &&
            $this->registerHook('displayAdminProductsExtra') &&
            $this->registerHook('actionAdminControllerSetMedia') &&
            $this->registerHook('displayProductAdditionalInfo') &&
            $this->registerHook('actionProductDelete');            
    }

    public function uninstall()
    {
        include(dirname(__FILE__).'/sql/uninstall.php');
        return parent::uninstall();
    }

    /**
     * Save form data.
     */
    protected function postProcess()
    {
        $form_values = $this->getConfigFormValues();

        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
        }
    }

    public function hookDisplayAdminProductsExtra($params)
    {
        if (_PS_VERSION_ >= '1.7') {
            $idProduct = $params['id_product'];
        } else {
            $idProduct = (int)Tools::getValue('id_product');
        }

        $searchQuery    = 'SELECT `custom_text` FROM '._DB_PREFIX_.'customproducttext WHERE `id_product` = '.pSQL(intval($idProduct));
        $product        = Db::getInstance()->executeS($searchQuery);
        $customText     = "";

        if (count($product) > 0) {
            $customText = $product[0]["custom_text"];            
        }
        
        $idEmployee = (int)$this->context->cookie->id_employee;
        $secureToken = Tools::getAdminToken('AdminProducts'.(int)Tab::getIdFromClassName('AdminProducts').$idEmployee);

        $this->context->smarty->assign(array(
            'adminPage'         => 'product',
            'idProduct'         => $idProduct,
            'customText'        => $customText,
            'secureToken'       => $secureToken,
            'idEmployee'        => $idEmployee,
            'idProduct'         => $idProduct,
        ));

        return $this->display(dirname(__FILE__), '/views/templates/admin/customproducttext.tpl');
    }
    
    public function hookDisplayProductAdditionalInfo($params)
    {
        $idProduct = $params["product"]["id_product"];

        $searchQuery    = 'SELECT `custom_text` FROM '._DB_PREFIX_.'customproducttext WHERE `id_product` = '.pSQL(intval($idProduct));
        $product        = Db::getInstance()->executeS($searchQuery);
        $customText     = "";

        if (count($product) > 0) {
            $customText = $product[0]["custom_text"];            
        }

        if ($customText != "") {
            $this->context->smarty->assign(array(
                'customText' => $customText,
            ));

            return $this->display(dirname(__FILE__), '/views/templates/hook/customtext-hook.tpl');
        }
        return;
    }

    public function hookActionAdminControllerSetMedia()
    {        
        if (Tools::getValue('controller') == "AdminProducts") {
            $this->context->controller->addJS($this->_path.'views/js/back.js');
            $this->context->controller->addCSS($this->_path.'views/css/back.css');
        }
    }

    public function hookActionProductDelete($params) {
        $idProduct = $params["id_product"];
        
        $result = Db::getInstance()->delete('customproducttext', 'id_product = '.pSQL(intval($idProduct)));
        
        if ($result) {
            return true;
        }
        return false;
    }
}
