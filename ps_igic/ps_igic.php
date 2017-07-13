<?php
/**
* 2014 PrestaShop
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
*  @author    Andres Nacimiento <andresnacimiento@gmail.com>
*  @copyright 2016 Andres Nacimiento
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

class Ps_Igic extends Module
{
    /* CONSTRUCT */
    public function __construct()
    {
        $this->name = 'ps_igic';
        $this->displayName = $this->l('IGIC');
        $this->description = $this->l('Tax for Canary');
        $this->tab = 'billing_invoicing';
        $this->version = '1.0.0';
        $this->author = 'Andres Nacimiento';
        $this->bootstrap = true;
        $this->module_key = '';
        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
        parent::__construct();
    }
    /* INSTALL */
    public function install()
    {
        return parent::install()
            /* Install Db */
            && $this->installDb();
    }
    /* UNINSTALL */
    public function uninstall()
    {
        /* Delete configuration */
        return parent::uninstall()
            /* Uninstall Db */
            && $this->uninstallDB();
    }
    public function getContent()
    {
        return $this->display(__FILE__, 'views/templates/admin/template.tpl');
    }
    /* Insert values into DB */
    public function installDb()
    {
        include "classes/db.php";
        $db = new Model();

        $db->installZone("Canarias");

        /* IGIC 7% */
        $db->installTax(7.000);
        $db->installTaxLang("IGIC 7%", 7.000);

        $db->installTaxRules("Santa Cruz de Tenerife", 7.000, "ES Standard rate (21%)");
        $db->installTaxRules("Las Palmas", 7.000, "ES Standard rate (21%)");
        
        /* IGIC 3% */
        $db->installTax(3.000);
        $db->installTaxLang("IGIC 3%", 3.000);

        $db->installTaxRules("Santa Cruz de Tenerife", 3.000, "ES Reduced Rate (10%)");
        $db->installTaxRules("Las Palmas", 3.000, "ES Reduced Rate (10%)");
        

        return true;
    }

    /* Uninstall DB */
    private function uninstallDb()
    {
        include "classes/db.php";
        $db = new Model();

        $db->delZone("Canarias");
        $db->delTaxLang("IGIC 7%");
        $db->delTax(7.000);
        $db->delTaxLang("IGIC 3%");
        $db->delTax(3.000);
        $db->delTaxRule("IGIC. Impuesto para Canarias");

        return true;
    }
}
