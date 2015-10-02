<?php
class ControllerFeedPrisjakt extends Controller {
	public function index() {
		

			$this->load->model('catalog/product');
			$this->load->model('tool/image');
			$this->load->model('catalog/category');
			$this->load->model('catalog/manufacturer');
			$this->load->model('catalog/information');
			
			
			$products = $this->model_catalog_product->getProducts();
			$output = "";

			foreach ($products as $product) {

					$output .= $product['name'].";"; // Produktnamn				
					$output .= $product['product_id'].";";// Art.nr
					$output .= $this->getCategories($product['product_id']).";"; // Kategori
					$output .= round($product['price']).";"; //Pris inkl.moms
					$output .= $this->url->link('product/product', 'product_id=' . $product['product_id']) . ';'; // Produkt-URL
					$output .= $product['manufacturer'].";"; // Tillverkare
					$output .= $product['sku'].";"; //Tillverkare SKU
					$output .= '0;'; // frakt
					$output .= $this->model_tool_image->resize($product['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height')) . ";"; // Bild URL
					$output .= $product['quantity'].";"; // Lagerstatus
					$output .= "\n";
			}
			
			$this->response->setOutput($output);
	}





	protected function getCategories($product_id) { // hämta kategori via produktens ID
		$product_cat = $this->model_catalog_product->getCategories($product_id);      
		$product_cat_parent = $this->model_catalog_category->getCategory($product_cat[0]['category_id']);
		return $product_cat_parent['name'];
	}
	
}
