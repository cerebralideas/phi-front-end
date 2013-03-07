<?php
class Model_Products extends Othernet_Model_System_MySQLiAbstract
{
    protected $_name = 'products';
    protected $_schema = AUTH_MYSQL_DATABASE;
    protected $_db;

    public function init()
    {
        //load the authdb adapter
        $this->_db = Zend_Registry::getInstance('authdbAdapter')->authdbAdapter;
    }

    public function fetchPairs($key, $value)
    {
        return $this->_db->fetchPairs('SELECT ' . $key . ', '. $value . ' FROM ' . $this->_name);
    }

    public function getProductsForOrganization($orgId)
    {
        // This method only returns subscription options
        $stmt = $this->_db->prepare(
            'SELECT sku, price, name, short_description, long_description
		    FROM products
		    INNER JOIN organization_products ON products.id = organization_products.product_id
		    WHERE organization_products.organization_id = :organizationId AND product_category_id IN (1, 3)
		    ORDER BY product_category_id DESC, price DESC'
        );

        $stmt->bindParam('organizationId', $orgId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAddOnProductsForOrganization($orgId)
    {
        // This method only returns add-on options
        $stmt = $this->_db->prepare(
            'SELECT sku, price, name, short_description, long_description
		    FROM products
		    INNER JOIN organization_products ON products.id = organization_products.product_id
		    WHERE organization_products.organization_id = :organizationId AND product_category_id IN (2)
		    ORDER BY product_category_id DESC, price DESC'
        );

        $stmt->bindParam('organizationId', $orgId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

}