<?php
/**
* 2007-2017 PrestaShop
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
*  @copyright 2007-2017 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

class Southingcustomizer extends Module
{
    protected $config_form = false;
    private $producto;

    public function __construct()
    {
        $this->name = 'southingcustomizer';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Francisco Javier Vargas Estrada';
        $this->need_instance = 0;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Southing Customizer');
        $this->description = $this->l('Personalizador de cinturones para Southing');

        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        // Configuration::updateValue('SOUTHINGCUSTOMIZER_LIVE_MODE', false);

        return parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('backOfficeHeader') &&
            $this->registerHook('displayHome');
    }

    public function uninstall()
    {
        // Configuration::deleteByName('SOUTHINGCUSTOMIZER_LIVE_MODE');

        return parent::uninstall();
    }

    /**
     * Load the configuration form
     */
    public function getContent()
    {
        /**
         * If values have been submitted in the form, process.
         */
        if (((bool)Tools::isSubmit('submitSouthingcustomizerModule')) == true) {
            $this->postProcess();
        }

        $this->context->smarty->assign('module_dir', $this->_path);

        $output = $this->context->smarty->fetch($this->local_path.'views/templates/admin/configure.tpl');

        return $output.$this->renderForm();
    }

    /**
     * Create the form that will be displayed in the configuration of your module.
     */
    protected function renderForm()
    {
        $helper = new HelperForm();

        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitSouthingcustomizerModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($this->getConfigForm()));
    }

    /**
     * Create the structure of your form.
     */
    protected function getConfigForm()
    {
        // ppp(Product::getProducts($this->context->language->id, 0, 0, "name", "asc"));
        // ppp($this->context->language->id);

        return array(
            'form' => array(
                'legend' => array(
                'title' => $this->l('Settings'),
                'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'col' => 3,
                        'type' => 'select',
                        'name' => 'SOUTHINGCUSTOMIZER_PRODUCT_ID',
                        'label' => $this->l('Producto de referencia'),
                        'options' => array(
                            'query' => Product::getProducts($this->context->language->id, 0, 0, "name", "asc"),
                            'id' => 'id_product',
                            'name' => 'name',
                        )
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );
    }

    /**
     * Set values for the inputs.
     */
    protected function getConfigFormValues()
    {
        return array(
            'SOUTHINGCUSTOMIZER_PRODUCT_ID' => Configuration::get('SOUTHINGCUSTOMIZER_PRODUCT_ID', false),
        );
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

    /**
    * Add the CSS & JavaScript files you want to be loaded in the BO.
    */
    public function hookBackOfficeHeader()
    {
        if (Tools::getValue('module_name') == $this->name) {
            $this->context->controller->addJS($this->_path.'views/js/back.js');
            $this->context->controller->addCSS($this->_path.'views/css/back.css');
        }
    }

    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookHeader()
    {
        $this->context->controller->addJS($this->_path.'/views/js/front.js');
        $this->context->controller->addCSS($this->_path.'/views/css/front.css');
        $this->context->controller->addCSS($this->_path.'/views/js/slick-1.6.0/slick/slick.css');
        $this->context->controller->addCSS($this->_path.'/views/js/slick-1.6.0/slick/slick-theme.css');
        $this->context->controller->addJS($this->_path.'/views/js/slick-1.6.0/slick/slick.min.js');
    }

    public function hookDisplayHome()
    {
        $id_producto = Configuration::get('SOUTHINGCUSTOMIZER_PRODUCT_ID', false);
        $error = false;
        
        if(!$id_producto){
            $error = true;
        }
        else{
            $this->producto = new Product($id_producto);
            $combinaciones = $this->getCombinaciones();
            $atributos = $this->getAtributos();
            $productos = $this->getProductos();
        }

        $this->smarty->assign(array(
            "error" => $error,
            "combinaciones" => $combinaciones,
            "atributos" => $atributos,
            "productos" => $productos,
            "nbr_cinturones" => count($atributos["Cinturón"]),
            "nbr_pasadores" => count($atributos["Pasador"]),
            "producto" => $this->producto->id,
        ));

        return $this->display(__FILE__, 'southingcustomizer.tpl');
    }

    private function getCombinaciones(){
        $combinaciones = array();
        
        foreach ($this->producto->getAttributesResume($this->context->language->id) as $pa){
            $combinaciones[$pa["attribute_designation"]] = array(
                "id" => $pa["id_product_attribute"],
                "precio" => $this->producto->getPrice(true, $pa["id_product_attribute"]),
            );
        }

        if(count($combinaciones) > 0)
            return $combinaciones;
        else
            return false;
    }

    private function getAtributos(){
        $atributos = array();
        $keys = array("Cinturón" => 0, "Pasador" => 0);
        foreach(Attribute::getAttributes($this->context->language->id) as $key => $a){
                if ($a["attribute_group"] == "Cinturón" || $a["attribute_group"] == "Pasador"){
                $atributos[$a["attribute_group"]][$keys[$a["attribute_group"]]] = array(
                    "img" => _PS_BASE_URL_ . "/img/co/" . $a["id_attribute"] . ".jpg",
                    "nombre_comb" => $a["attribute_group"] . " - " . $a["name"],
                    "nombre" => $a["name"],
                );
                $keys[$a["attribute_group"]]++;
            }
        }

        if(count($atributos) > 0)
            return $atributos;
        else
            return false;
    }

    private function getProductos(){
        $productos = array();
        $link = new Link();

        $id_cinturones = 4;
        $id_pasadores = 5;

        $categoria = new Category($id_cinturones);
        $cinturones = $categoria->getProducts(3, 0, 1000000);
        foreach ($cinturones as $cinturon){
            $img = Product::getCover($cinturon["id_product"]);
            $enlace_img = $link->getImageLink($cinturon["link_rewrite"], $img["id_image"]);
            $enlace_img = _PS_BASE_URL_ . substr($enlace_img, strpos($enlace_img, "/"));

            $productos["cinturones"][] = array(
                "id" => $cinturon["id_product"],
                "nombre" => $cinturon["name"],
                "imagen" => $enlace_img,
                "precio" => $cinturon["price"],
            );
        }

        $categoria = new Category($id_pasadores);
        $pasadores = $categoria->getProducts(3, 0, 1000000);
        foreach ($pasadores as $pasador){
            $img = Product::getCover($pasador["id_product"]);
            $enlace_img = $link->getImageLink($pasador["link_rewrite"], $img["id_image"]);
            $enlace_img = _PS_BASE_URL_ . substr($enlace_img, strpos($enlace_img, "/"));

            $productos["pasadores"][] = array(
                "id" => $pasador["id_product"],
                "nombre" => $pasador["name"],
                "imagen" => $enlace_img,
                "precio" => $pasador["price"],
            );
        }

        if(count($productos) > 0)
            return $productos;
        else
            return false;

    }
}
