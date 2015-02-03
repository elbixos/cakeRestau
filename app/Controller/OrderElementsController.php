<?php 
class OrderElementsController extends AppController {
	//public $helpers = array('Html', 'Form');

	public function avancer($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Passez un element de commande !'));
			throw new NotFoundException(__('Element de commande invalide'));
		}

		$orderElt =  $this->OrderElement->findById($id);
		if (!$orderElt) {
			$this->Session->setFlash(__('Cet element de commande n existe pas'));
			throw new NotFoundException(__('Element de commande invalide'));
		}
		
		if ($orderElt['OrderElement']['etat'] == 'not ready')
			$orderElt['OrderElement']['etat'] = 'cooking';
		else
			if ($orderElt['OrderElement']['etat'] == 'cooking')
				$orderElt['OrderElement']['etat'] = 'ready';
			else {
				$this->Session->setFlash(__('Cet element de commande est deja pret'));
				throw new NotFoundException(__('Element de commande invalide'));
			}
		
		
		$this->set('orderElement',$orderElt);
		
		if ($this->OrderElement->save($orderElt)) {
		
			$this->Session->setFlash(__('Element avancé'));
		}
		else
			$this->Session->setFlash(__('Probleme lors de la requete'));
		
		$this->redirect(array('controller'=>'orders', 'action' => 'index'));
	}
}

?>