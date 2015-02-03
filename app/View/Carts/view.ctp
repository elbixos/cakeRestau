
<?php // print_r($products); ?> 
<?php echo $this->Form->create('Cart',array('url'=>array('action'=>'update')));?>
<div class="row">
    <div class="col-lg-12">
        <table class="table">
            <thead>
                <tr>
                    <th>Gamme / Produit</th>
                    <th>Prix</th>
                    <th>Quantité</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $total=0;?>
                <?php foreach ($products as $product):?>
                <tr>
                    <td><?php echo $product['ProductLine']['nom'].'/'.$product['Product']['nom'];?></td>
                    <td>$<?php echo $product['Product']['prix'];?>
                    </td>
                    <td><div class="col-xs-3">
                            <?php echo $this->Form->hidden('product_id.',array('value'=>$product['Product']['id']));?>
                            <?php echo $this->Form->input('count.',array('type'=>'number', 'label'=>false,
                                    'class'=>'form-control input-sm', 'value'=>$product['Product']['count']));?>
                        </div></td>
                    <td>$<?php echo $product['Product']['count']*$product['Product']['prix']; ?>
                    </td>
                </tr>
                <?php $total = $total + ($product['Product']['count']*$product['Product']['prix']);?>
                <?php endforeach;?>
 
                <tr class="success">
                    <td colspan=3></td>
                    <td>$<?php echo $total;?>
                    </td>
                </tr>
            </tbody>
        </table>
 
        <p class="text-right">
            <?php echo $this->Form->submit('Update',array('class'=>'btn btn-warning','div'=>false));?>
            <a class="btn btn-success"
                <?php	
				echo $this->Html->Link(
					'Valider',
					array('controller'=> 'orders', 'action' => 'add'),
					array('confirm' => 'Are you sure?')
				);
				?>
        </p>
 
    </div>
</div>
