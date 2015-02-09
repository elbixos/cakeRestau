<?php 

class ProductsController extends AppController {
	public $helpers = array('Html', 'Form');
	//public $actsAs = array('Containable');
	 

	public function index() {
		//$this->layout = 'monLayout';
		$sort = array( 'ProductLine.nom'=> 'ASC');
		$this->set('produits', $this->Product->find('all',
				array('order'=>$sort)
			)
		);
	}
	
	public function add() {
		$this->set('productLines', $this->Product->ProductLine->find('list', array(
        'fields' => array('ProductLine.id', 'ProductLine.nom'))));

		$this->set('ingredients', $this->Product->Ingredient->find('list', array(
        'fields' => array('Ingredient.id', 'Ingredient.nom'))));
		
		if ($this->request->is('post')) {
			$this->Product->create();
			
			//Check if image has been uploaded
			if(!empty($this->request->data['Product']['upload']['name']))
			{
					$file = $this->request->data['Product']['upload']; //put the data into a var for easy use

					$ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
					$arr_ext = array('jpg', 'jpeg', 'gif'); //set allowed extensions

					//only process if the extension is valid
					if(in_array($ext, $arr_ext))
					{
							//do the actual uploading of the file. First arg is the tmp name, second arg is 
							//where we are putting it
							// ATTENTION, le nom du fichier est ProductLine_Product.jpg
							$filename = $this->request->data['Product']['ProductLine']['nom'].'_'.$this->request->data['Product']['nom'].'.jpg';

							move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/uploads/products/' . $file['name']);

							//prepare the filename for database entry
							$this->request->data['Product']['image'] = $file['name'];
					}
			}
			if ($this->Product->save($this->request->data)) {
				$this->Session->setFlash(__('produit ajouté'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('Impossible d ajouter votre produit.'));
		}
		
	}

	// recupere les produits d'une gamme donnee
	public function viewProductsFromProductLine($product_line_id = null) {
		
		if (!$product_line_id) {
			throw new NotFoundException(__('Gamme de Produits invalide'));
		}

		$products = $this->Product->find('all', array(
			'conditions' => 'ProductLine.id = '.$product_line_id
		));
		
		if (!$products) {
			$this->Session->setFlash(__('Cette gamme n a pas de produits pour le moment.'));
			//throw new NotFoundException(__('Produit invalide'));
		}
		
		$this->set('products', $products);


		}

	
	public function edit($id = null) {
		
		if (!$id) {
			throw new NotFoundException(__('Produit invalide'));
		}

		$product = $this->Product->findById($id);

		if (!$product) {
			throw new NotFoundException(__('Produit invalide'));
		}
		
		$this->set('productLines', $this->Product->ProductLine->find('list', array(
        'fields' => array('ProductLine.id', 'ProductLine.nom'))));

		$this->set('ingredients', $this->Product->Ingredient->find('list', array(
        'fields' => array('Ingredient.id', 'Ingredient.nom'))));
		
		if ($this->request->is(array('post', 'put'))) {
			$this->Product->id = $id;
			if ($this->Product->save($this->request->data)) {
				$this->Session->setFlash(__('produit modifié'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('Impossible de modifier votre produit.'));
		}
		
		if (!$this->request->data) {
				$this->request->data = $product;
		}
		
	}

	public function delete($id = null) {
		if ($this->request->is('get')) {
			throw new MethodNotAllowedException();
		}
		
		if ($this->Product->delete($id)) {
			$this->Session->setFlash(
				__('Le produit a été supprimé.')
			);

			return $this->redirect(array('action' => 'index'));
		}
	}

	
}

?>