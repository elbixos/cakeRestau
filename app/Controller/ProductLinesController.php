<?php 

class ProductLinesController extends AppController {
	public $helpers = array('Html', 'Form');
	public $components = array('Session');
	
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('index', 'view','mytest');
    }	
	
	public function index() {
		$sort = array( 'ProductLine.nom'=> 'ASC');
		$this->set('product_lines', $this->ProductLine->find('all',array('order'=>$sort)));
	}
	
	public function add() {
		if ($this->request->is('post')) {
			$this->ProductLine->create();
			//Check if image has been uploaded
			if(!empty($this->request->data['ProductLine']['upload']['name']))
			{
					$file = $this->request->data['ProductLine']['upload']; //put the data into a var for easy use

					$ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
					$arr_ext = array('jpg'); //set allowed extensions

					//only process if the extension is valid
					if(in_array($ext, $arr_ext))
					{
							//do the actual uploading of the file. First arg is the tmp name, second arg is 
							//where we are putting it
							// ATTENTION, le nom de l'image sauvée est celui de la ProductLine
							$filename = $this->request->data['ProductLine']['nom'].'.jpg';
							move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/uploads/product_lines/' .$filename);

							//prepare the filename for database entry
							$this->request->data['ProductLine']['image'] = $filename;
					}
			}
			
			if ($this->ProductLine->save($this->request->data)) {
				$this->Session->setFlash(__('Gamme de produits ajoutée'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('Impossible d ajouter votre gamme de produits.'));
		}
	}

	public function edit($id = null) {
		
		if (!$id) {
			throw new NotFoundException(__('Gamme de produits invalide'));
		}

		$product = $this->ProductLine->findById($id);

		if (!$product) {
			throw new NotFoundException(__('Gamme de produits invalide'));
		}
				
		if ($this->request->is(array('post', 'put'))) {
			$this->ProductLine->id = $id;
			//$this->set ('dbg',$this->request->data);

			if(!empty($this->request->data['ProductLine']['upload']['name']))
			{
					$file = $this->request->data['ProductLine']['upload']; //put the data into a var for easy use

					$ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
					$arr_ext = array('jpg'); //set allowed extensions

					//only process if the extension is valid
					if(in_array($ext, $arr_ext))
					{
							//do the actual uploading of the file. First arg is the tmp name, second arg is 
							//where we are putting it
							// ATTENTION, le nom de l'image sauvée est celui de la ProductLine
							$filename = $this->request->data['ProductLine']['nom'].'.jpg';
							move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/uploads/product_lines/' .$filename);

							//prepare the filename for database entry
							$this->request->data['ProductLine']['image'] = $filename;
							//$this->set ('dbg',$this->request->data);
					}
			}
			if ($this->ProductLine->save($this->request->data)) {
				$this->Session->setFlash(__('Gamme de produits modifiée'));
				//$this->set ('dbg',$this->request->data);
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('Impossible de modifier votre Gamme de produits.'));
		}
		
		if (!$this->request->data) {
				$this->request->data = $product;
		}
		
	}

	
	public function delete($id = null) {
		if ($this->request->is('get')) {
			throw new MethodNotAllowedException();
		}
		
		if ($this->ProductLine->delete($id,$cascade=true)) {
			$this->Session->setFlash(
				__('La Gamme a été supprimée.')
			);

			return $this->redirect(array('action' => 'index'));
		}
	}
	
	/**
	 * AJAX action to test
	 */
	public function mytest() {
		$this->autoRender = false; // We don't render a view in this example
		$this->request->onlyAllow('ajax'); // No direct access via browser URL
	 
		$data = array(
			'content' => 'trop bidon',
			'error' => 'raté',
		);
		return json_encode($data);
	}
}

?>