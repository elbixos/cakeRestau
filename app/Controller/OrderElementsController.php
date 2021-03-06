<?php 
class OrderElementsController extends AppController {
	//public $helpers = array('Html', 'Form');
	
	public function isAuthorized($user) {

		// Le cuisinier peut avancer un ElementOrder
		if ($this->action === 'avancer') {
			if ($user['role']==='cuisinier'){
				return true;
			}
		}
		
		/*
		// autre autorisation specifique
		if (in_array($this->action, array('edit', 'delete'))) {
			$postId = (int) $this->request->params['pass'][0];
			if ($this->Post->isOwnedBy($postId, $user['id'])) {
				return true;
			}
		}
		*/

		// le retour par défaut.
		return parent::isAuthorized($user);
	}
	
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
			if ($orderElt['OrderElement']['etat'] == 'cooking') {
				$orderElt['OrderElement']['etat'] = 'ready';
								
			}
			else {
				$this->Session->setFlash(__('Cet element de commande est deja pret'));
				throw new NotFoundException(__('Element de commande invalide'));
			}
		
		
		
		if ($this->OrderElement->save($orderElt)) {
			
			// auto avance des commandes dont tous les OrderElements sont ready...
			//	on recupere les OE de la commande en cours
			$allOE = $this->OrderElement->findAllByOrderId($orderElt['Order']['id']);
			//debug ($allOE);
			// on parcourt les OE
			$flag = true;
			foreach ($allOE as $oe) {
				if ($oe['OrderElement']['etat'] != 'ready')
					$flag = false;
			}
			
			//debug ($flag);
			// si tous les elements sont ready -> on modifie l'order...
			if ($flag) {
				$myorder = $this->OrderElement->Order->findById($orderElt['Order']['id']);
				// NE RESTE QUE CA  A FAIRE !
				$myorder['Order']['etat']='prete a livrer';
				if (!$this->OrderElement->Order->save($myorder))
					debug('foiré');
			}
				

			$this->Session->setFlash(__('Element avancé'));
			
			$this->set('orderElement',$orderElt);
		}
		else
			$this->Session->setFlash(__('Probleme lors de la requete'));
		
		$this->redirect($this->referer());
		
		//$this->redirect(array('controller'=>'orders', 'action' => 'index'));
	}
}

?>