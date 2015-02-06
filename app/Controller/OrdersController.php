<?php 

class OrdersController extends AppController {
	public $helpers = array('Html', 'Form');

    public $uses = array('Order','OrderElement','Product','Cart');
	
	public function isAuthorized($user) {
		// Tous les users inscrits peuvent ajouter une commande
		if ($this->action === 'add') {
			return true;
		}

		if ($this->action === 'indexcook') {
			if ($user['role']==='cuisinier'){
				return true;
			}
		}
		// Des choses specifiques pour certains... sur les commandes
		/*
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

	protected function orderContains(){
		// On limite la recherche
		$contains = array(
			'OrderElement' => array(
				'fields' => array('etat','id'),
				'Product' => array(
					'fields'=>array('nom'),
					'ProductLine' => array(
						'fields'=>array('nom')
					)
				)
			),
			'User' => array(
				'fields' => array('username')
			)
		);
		return $contains;
		
	}
	
	// le controler standard de liste des commandes
	// ne voit que celles de l'utilisateur
	public function index() {
		// On limite la recherche
		$contains = $this-> orderContains();
		
		$user = $this->Auth->user();
		$conditions = array('Order.user_id'=> $user['id']); 
		$this->set('orders', $this->Order->find('all',array(
			'conditions'=>$conditions,
			'contain'=>$contains)
			)
		);
		
	}

	// la liste des commandes pour le cuisinier
	public function indexcook() {
		
		// On limite la recherche
		$contains = $this-> orderContains();
		
		// recuperons les Order.id des orderElements d'etat 'not ready'
		// TO DO : ELIMINER DOUBLONS DANS LES ORDER
		$orderElts = $this->Order->OrderElement->find("list",array(
			'fields' => array ('order_id'),
			'conditions'=> array('orderElement.etat'=>'cooking')
		));
		
		// on fait un tableau des $order_id utiles 
		$orders_id =[];
		foreach ($orderElts as $oe_id => $oi_id){
			$orders_id[]=$oi_id;
		}
		
		// le find avec contain ET LA CONDITION !
		$orders = $this->Order->find('all',array(
			'contain'=> $contains,
			'conditions'=>array('Order.id' => $orders_id)
			)
		);

		$this->set('orders',$orders);

		/*
		// Tentative de join, ratée...
		$conditions = array();
		$conditions['joins'] = array(
			array(
				'table' => 'order_elements',
				'alias' => 'OrderElement',
				'type' => 'LEFT',
				'conditions' => array(
					'OrderElement.etat' => 'cooking',
					'OrderElement.order_id' => 'Order.id'
				)
			)
		);
		$this->recursive = -1;
		$orders = $this->Order->find('all', array(
			'contain'=> $contains,
			'joins'=>$conditions['joins']
			)
		);
		*/

		
		

		/* 
		// Avec du contains, laisse les OrderElements non cooking vides
		// On limite la recherche
		$this->Order->contain(array(
			'OrderElement' => array(
				'conditions'=>array('OrderElement.etat'=>'cooking'),
				'fields' => array('etat','id'),
				'Product' => array(
					'fields'=>array('nom'),
					'ProductLine' => array(
						'fields'=>array('nom')
					)
				)
			),
			'User' => array(
				'fields' => array('username')
			)
		));
		$orders = $this->Order->find('all');
		$this->set('orders', $orders);
		
		*/
		
		//$this->render('/Orders/index');

	}

	// liste des commandes pour l'admin
	public function indexadmin() {
		
		// On limite la recherche
		$contains = $this-> orderContains();

		// le find avec contain 
		$orders = $this->Order->find('all',array(
			'contain'=> $contains
			)
		);
		
		$this->set('orders', $orders);
		$this->render('/Orders/index');
	}
	
	/* On ajoute les elements du panier dans la commande */
	public function add() {
		// On recupere le panier
		$cart = $this->Cart->readProduct();
		
		// On recupere l'utilisateur courant (et son Id)
		$user = $this->Auth->user();
		$user_id = $user['id'];
		
		$data = array(
			'Order'=>array('user_id'=>$user_id),
			'OrderElement'=>array()
			);
			
		if (null!=$cart) {
			foreach ($cart as $productId => $count) {
				for ($i=0;$i<$count;$i++) {
					$product = $this->Product->read(null,$productId);
					
					$data['OrderElement'][]= array('product_id'=> $product ['Product']['id']);
					/*
					$data['OrderElement']= array(
						'Product'=>array('product_id'=> $product ['Product']['id'])
					);
					*/
				}
			}
			
			if ($this->Order->saveAll($data)) {
				$this->Session->setFlash(__('commande passee'));
				// On vide le panier
				$this->Cart->raz();
				$this->redirect(array('controller'=> 'products','action' => 'index'));
			}
			else
				$this->Session->setFlash(__('Impossible d ajouter votre commande.'));
			
		}
		$this->set('data',$data);
		/*
		$this->set('products', $this->Order->Product->find('list', array(
        'fields' => array('Product.id', 'Product.nom'))));

		$this->set('ingredients', $this->Product->Ingredient->find('list', array(
        'fields' => array('Ingredient.id', 'Ingredient.nom'))));
		
		if ($this->request->is('post')) {
			$this->Product->create();
			if ($this->Product->save($this->request->data)) {
				$this->Session->setFlash(__('produit ajouté'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('Impossible d ajouter votre produit.'));
		}
		*/
	}


	
	public function edit($id = null) {
		/*
		if (!$id) {
			throw new NotFoundException(__('Commande invalide'));
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
		*/
	}

	public function delete($id = null) {
		if ($this->request->is('get')) {
			throw new MethodNotAllowedException();
		}
		
		if ($this->Order->delete($id,$cascade=true)) {
			$this->Session->setFlash(
				__('La Commande a été supprimée.')
			);

			return $this->redirect(array('action' => 'index'));
		}
	}
}

?>