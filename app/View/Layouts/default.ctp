<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $this->fetch('title'); ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css(array('cake.generic','vpage'));

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div id="container">
		<div id="header">
			<h1><?php echo $this->Html->link($cakeDescription, 'http://cakephp.org'); ?></h1>
		</div>
		
		<div id="header2">
			<div id="login">
				<?php
				if (!empty($myuser)) { 
					echo 'Utilisateur : '. $myuser['username'];
					echo '<p>';
					echo $this->Html->link('Log out', array('plugin'=>null,
						'admin'=>false, 'controller'=>'users', 'action'=>'logout'));
					echo '</p>';
				} else {
					echo 'Utilisateur non connecté. ';
					echo '<p>';
					echo $this->Html->link('Log in', array('plugin'=>null,
						'admin'=>false, 'controller'=>'users', 'action'=>'login'));
					echo '</p>';
					echo '<p>';
					echo $this->Html->link('Inscription', array('plugin'=>null,
						'admin'=>false, 'controller'=>'users', 'action'=>'add'));
					echo '</p>';
				}
				?>
			</div>
			<div id = "panier">
				<ul class="nav navbar-nav navbar-right">
					<li>
						<?php echo $this->Html->link('<span class="glyphicon glyphicon-shopping-cart"></span> Panier <span class="badge" id="cart-counter">'.$count.'</span>',
                                        array('controller'=>'carts','action'=>'view'),array('escape'=>false));?>
					</li>
				</ul>
			</div><!-- /panier -->			
		</div> <!--header2> -->
		<div  id="menu">
				<ul class="nav">
					<li>
						<?php echo $this->Html->link('<span class="glyphicon glyphicon-shopping-cart"></span> Panier <span class="badge" id="cart-counter">'.$count.'</span>',
                                        array('controller'=>'carts','action'=>'view'),array('escape'=>false));?>
					</li>
				</ul>
				<ul class="nav">
					<li>
						<?php 
							echo $this->Html->link('gammes de produits',
                                        array('controller'=>'product_lines','action'=>'index')
							);?>
					</li>
		
					<li>
						<?php 
							echo $this->Html->link('produits',
                                        array('controller'=>'products','action'=>'index')
							);?>
					</li>
					<?php 
					if (!empty($myuser)) :
					?>
					<li>
						<?php 
							echo $this->Html->link('Vos Commandes',
                                        array('controller'=>'orders','action'=>'index')
							);?>
					</li>
					<?php endif ?>
							
				</ul>

				<?php 
				if ($myuser['role'] =='cuisinier') :
				?>
				<ul class="nav">
					<li>
						<?php 
							echo $this->Html->link('Commandes en cours',
                                        array('controller'=>'orders','action'=>'indexcook')
							);?>
					</li>
				</ul>
				<?php endif ?>
		
				
				<?php 
				if ($myuser['role'] =='admin') :
				?>
				
				<ul class="nav">
					<li>
						<?php 
							echo $this->Html->link('Gestion Commandes',
                                        array('controller'=>'orders','action'=>'indexadmin')
							);?>
					</li>
					<li>
						<?php 
							echo $this->Html->link('Ingredients',
                                        array('controller'=>'ingredients','action'=>'index')
							);?>
					</li>
					<li>
						<?php 
							echo $this->Html->link('Utilisateurs',
                                        array('controller'=>'users','action'=>'index')
							);?>
					</li>
					<li>
						<?php 
							echo $this->Html->link('Commandes cuisto',
                                        array('controller'=>'orders','action'=>'indexcook')
							);?>
					</li>
				</ul>
				<?php endif ?>
		</div><!-- /#menu -->
    	
	
		<div id="content">

			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
			<?php echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
					'http://www.cakephp.org/',
					array('target' => '_blank', 'escape' => false, 'id' => 'cake-powered')
				);
			?>
			<p>
				<?php echo $cakeVersion; ?>
			</p>
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
