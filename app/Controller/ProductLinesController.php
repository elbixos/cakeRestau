<?php 

class ProductLinesController extends AppController {
	public $helpers = array('Html', 'Form');
	public $components = array('Session');
	
	public function index() {
		$this->set('product_lines', $this->ProductLine->find('all'));
	}
	
	public function add() {
		if ($this->request->is('post')) {
			$this->ProductLine->create();
			if ($this->ProductLine->save($this->request->data)) {
				$this->Session->setFlash(__('Gamme de produits ajoutée'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('Impossible d ajouter votre gamme de produits.'));
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
}

?>