<?php 

class OrdersController extends AppController {
	public $helpers = array('Html', 'Form');

    public $uses = array('Order','OrderElement','Product','Cart');
	
	public function isAuthorized($user) {
		// Tous les users inscrits peuvent ajouter une commande
		if ($this->action === 'add' ) {
			return true;
		}

		if ($this->action === 'index' ) {
			return true;
		}

		
		if ($this->action === 'indexcook') {
			if ($user['role']==='cuisinier'){
				return true;
			}
		}
		
		if ($this->action === 'avancer') {
			if (in_array($user['role'] ,array('cuisinier','livreur'), true) ) {
				return true;
			}
		}
		
		if ($this->action === 'indexdelivery') {
			if ($user['role']==='livreur'){
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
				'order' => 'OrderElement.etat DESC',
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
		
		// conditions
		$user = $this->Auth->user();
		$conditions = array('Order.user_id'=> $user['id']); 
		
		// le find
		$orders = $this->Order->find('all',array(
			'conditions'=>$conditions,
			'contain'=>$contains
			)
		);
		
		$this->set('orders', $orders);
		
	}

	// la liste des commandes pour le cuisinier
	public function indexcook() {
				
		// recuperons les Order.id des orderElements d'etat 
		// 'not ready' ou 'cooking'
		// TO DO : ELIMINER DOUBLONS DANS LES ORDER
		$orderElts = $this->Order->OrderElement->find("list",array(
			'fields' => array ('order_id'),
			'conditions'=> array(
				'orderElement.etat'=> array('cooking','not ready')
				)
			)
		);
		
		// on fait un tableau des $order_id utiles 
		$orders_id =[];
		foreach ($orderElts as $oe_id => $oi_id){
			$orders_id[]=$oi_id;
		}
		
		// On limite la recherche
		$contains = $this-> orderContains();
		
		$sort = array('Order.id'=>'ASC');
		
		// le find avec contain ET LA CONDITION !
		$orders = $this->Order->find('all',array(
			'contain'=> $contains,
			'conditions'=>array('Order.id' => $orders_id),
			'order'=>$sort
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
		
		$this->render('/Orders/index');

	}

	// le controler livreur de liste des commandes
	public function indexdelivery() {
		// On limite la recherche
		$contains = $this-> orderContains();
		
		// conditions
		$conditions = array(
				'Order.etat'=> array('prete a livrer','en livraison')
			); 
		
		// le find
		$orders = $this->Order->find('all',array(
			'conditions'=>$conditions,
			'contain'=>$contains
			)
		);
		
		//debug($orders);
		
		$this->set('orders', $orders);

		$this->render('/Orders/index');

	}
	
	// liste des commandes pour l'admin
	public function indexadmin() {
		
		// On limite la recherche
		$contains = $this-> orderContains();
		
		$sort = array('Order.id'=>'DESC');
		
		// le find avec contain 
		$orders = $this->Order->find('all',array(
			'contain'=> $contains,
			'order' => $sort
			)
		);
		
		$this->set('orders', $orders);
		$this->render('/Orders/index');
	}

	public function indextest() {
		//$contains = $this-> orderContains();

		$yes = $this->Order->find('all', array(
			'recursive'=>-1,
			'joins' => array(
				array(
					'table' => 'order_elements',
					'alias' => 'OrderElement',
					'type' => 'left',
					'conditions' => array(
						'OrderElement.order_id' => 'Order.id',
						'OrderElement.etat' => 'cooking'
					),
				)		
				
            )
        ));
		
		$this->set('orders',$yes);
		//$this->render('/Orders/index');

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
	
	// Avancer une commande (en preparation => prete a livrer => en livraison => livrée
	public function avancer($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Passez une commande valide !'));
			throw new NotFoundException(__('commande invalide'));
		}

		$order =  $this->Order->findById($id);
		if (!$order) {
			$this->Session->setFlash(__('Cette commande n existe pas'));
			throw new NotFoundException(__('Commande invalide'));
		}
		
		if ($order['Order']['etat'] === 'en preparation')
			$order['Order']['etat'] = 'prete a livrer';
		elseif ($order['Order']['etat'] == 'prete a livrer')
			$order['Order']['etat'] = 'en livraison';
		elseif ($order['Order']['etat'] == 'en livraison')
			$order['Order']['etat'] = 'livree';
		else {
				$this->Session->setFlash(__('Cette commande est deja livrée'));
				throw new NotFoundException(__('Commande invalide'));
			}
		
		
		$this->set('order',$order);
		
		if ($this->Order->save($order)) {
		
			$this->Session->setFlash(__('Commande avancée'));
		}
		else
			$this->Session->setFlash(__('Probleme lors de la requete'));
		
		$this->redirect($this->referer());
	}
	
}

?>