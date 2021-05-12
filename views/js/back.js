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
*
* Don't forget to prefix your containers with your own identifier
* to avoid any conflicts with others containers.
*/

jQuery(document).ready(function() {
    jQuery("#saveCustomText").on("click", function() {
        var customText = jQuery("#customText").val();

        $.ajax({
            type: 'POST',
            url: '/modules/customproducttext/classes/saveCustomText.php',
            data: {	"idProduct"  : idProduct, "customText" : customText, "idEmployee" : idEmployee, "secureToken"  :  secureToken},
            success: function(data) {
                        if (data) {
                            jQuery("#returnStatus").text(settingUpdated);
                            jQuery("#returnStatus").removeClass("bg-danger");
                            jQuery("#returnStatus").addClass("bg-success");                            
                        } else {                            
                            jQuery("#returnStatus").text(updateFailed);
                            jQuery("#returnStatus").removeClass("bg-success");
                            jQuery("#returnStatus").addClass("bg-danger");                            
                        }
                        jQuery("#returnStatus").show("");
                        setTimeout(function(){ jQuery("#returnStatus").hide(""); }, 3000);
                    },
        });
    });
});