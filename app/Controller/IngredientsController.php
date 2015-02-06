<?php 

class IngredientsController extends AppController {
	public $helpers = array('Html', 'Form');
	public $components = array('Session');
	
	public function index() {
		$this->set('ingredients', $this->Ingredient->find('all',array(
			'order'=>array('Ingredient.nom'=>'ASC')
			)
		));
	}
	
	public function add() {
		if ($this->request->is('post')) {
			$this->Ingredient->create();
			if ($this->Ingredient->save($this->request->data)) {
				$this->Session->setFlash(__('Ingrédient ajouté'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('Impossible d ajouter votre ingrédient.'));
		}
	}
	
	
    public function edit($id = null) {
        $this->Ingredient->id = $id;
        if (!$this->Ingredient->exists()) {
            throw new NotFoundException(__('Ingredient Invalide'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Ingredient->save($this->request->data)) {
                $this->Session->setFlash(__('L\'ingrédient a été sauvegardé'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('L\'ingrédient n\'a pas été sauvegardé. Merci de réessayer.'));
            }
        } else {
            $this->request->data = $this->Ingredient->read(null, $id);
		}
    }

    public function delete($id = null) {
        // Avant 2.5, utilisez
        // $this->request->onlyAllow('post');

        $this->request->allowMethod('post');

        $this->Ingredient->id = $id;
        if (!$this->Ingredient->exists()) {
            throw new NotFoundException(__('Ingrédient invalide'));
        }
        if ($this->Ingredient->delete()) {
            $this->Session->setFlash(__('Ingrédient supprimé'));
            return $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('L\'ingrédient n\'a pas été supprimé'));
        return $this->redirect(array('action' => 'index'));
    }
}

?>