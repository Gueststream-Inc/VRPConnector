<div class="vrpgrid_11" style="float:right; text-align:right;margin-bottom:15px;">
    <a href="/vrp/book/step3/?obj[Arrival]=<?php echo esc_attr( $data->Arrival ); ?>&obj[Departure]=<?php echo esc_attr( $data->Departure ); ?>&obj[PropID]=<?php echo esc_attr( $_GET['obj']['PropID'] ); ?>&obj[Adults]=<?php echo esc_attr( $_GET['obj']['Adults'] );?>" class="btn btn-success success continuebtn">Continue with Reservation</a><br><br>
	Add-on Package Total: <b class="addontotal">$0.00</b>
</div>
<br><br>
<form id="packagesform">
	<?php foreach ( $data->packages as $v ) : ?>
	<div class="packageitem">
		<a href="#" class="expandlink btn btn-primary">Expand +</a>
		<img src="<?php echo esc_url( $v->image ); ?>" width="70" height="70" style="border:1px solid #000000">
		<h3><?php echo esc_html( $v->name ); ?></h3>
		<small><?php echo esc_html( $v->subtitle ); ?></small>
		<br style="clear:both;">
		
			<div class="packagechildren" style="display:none">
				<?php
				foreach ( $v->children as $cid => $child ) {
					if ( $cid == '0' ) {
						$cid = uniqid();
					}
					?>
						<h3 style="border-bottom:1px solid #ffffff;"><a href="#" onclick="jQuery('.isopened').slideUp().removeClass('isopened');jQuery('.c_<?php echo esc_js( $cid );?>').slideDown().addClass('isopened'); return false;" class="childcatlink"><?php echo esc_html( $child->name ); ?> <small style="font-size:10px;color:#ffffff;">[Expand]</small></a></h3>
	  
						</table>
						<?php

						foreach ( $child->types as $type => $q ) {
							?>
						<div class="c_<?php echo esc_attr( $cid );?>" style="display:none">
						<?php if ( $type != '0' ) { ?> <h3 style="margin-left:10px;font-size:16px;"><?php echo esc_html( $type ); ?></h3><?php } ?>
						<?php
						foreach ( $q as $p ) :
							$checked = '';
							$qty = 1;

							if ( array_key_exists( $p->id, $data->package->items ) ) {
									$checked = 'checked';
									$qty = $data->package->items[ $p->id ]->qty;
							}
							if ( $p->type == '0' ) {
								$p->type = '';
							}
					?>
					<table width="100%" style="background:white;border-top:1px dotted #2268AE">
					<tr><td align="center" width="15%">Add Item<br><input class="addtoit" name="package[]" type="checkbox" value="<?php echo esc_attr( $p->id ); ?>" <?php echo esc_attr( $checked ); ?>></td>
				<td width="45%"><b><?php echo esc_html( $p->name ); ?></b><input type="hidden" name="name[<?php echo esc_attr( $p->id ); ?>]" value="<?php echo esc_attr( $p->name ); ?>"><br><small><?php echo esc_html( $p->description ); ?></small></td>
				<td width="15%" style="text-align:center;"><small><?php echo esc_html( $p->type ); ?></small></td>
				<td align="right"><b>$<?php echo esc_html( $p->amount ); ?></b> <?php echo esc_html( $p->measure );?><input type="hidden" name="cost[<?php echo esc_attr( $p->id ); ?>]" value="<?php echo esc_attr( $p->amount ); ?>"></td>
				<td><select name="qty[<?php echo esc_attr( $p->id ); ?>]" class="doqty">
					<?php
					foreach ( range( 1, 10 ) as $r ) {
						$selected = '';
						if ( $qty == $r ) {
							$selected = 'selected="selected"';
						}

						?><option value="<?php echo esc_attr( $r ); ?>" <?php echo esc_attr( $selected );?>><?php echo esc_attr( $r ); ?></option><?php } ?></select> </td>
						</tr>
					</table>
				<?php endforeach;
					?>
						</div>
						<?php
						}
				}?>
		
	</div>
	</div>

	
	
	
	
	
	
	<br><br>
	
<?php endforeach; ?>
	<input type="hidden" name="TotalCost" value="<?php echo esc_attr( $data->TotalCost ); ?>">
	<div class="vrpgrid_11" style="text-align:right;"><br><input type="submit" value="Update" class="ButtonView rounded" style="float:right;display:none; "><br style="clear:both;"></div></form>

<div class="vrpgrid_11" style="float:right;text-align:right;margin-top:10px;">
	Add-on Package Total: <b class="addontotal">$0.00</b>
	<br><br>
	<a href="/vrp/book/step3/?obj[Arrival]=<?php echo esc_attr( $data->Arrival ); ?>&obj[Departure]=<?php echo esc_attr( $data->Departure ); ?>&obj[PropID]=<?php echo esc_attr( $_GET['obj']['PropID'] ); ?>&obj[Adults]=<?php echo esc_attr( $_GET['obj']['Adults'] );?>" class="btn btn-success success continuebtn" style="float:right;" >Continue with Reservation</a>
</div>
<style>
	.packageitem {
		border: 1px solid #404040;
		-moz-border-radius: 15px;
		-webkit-border-radius: 15px;
		border-radius: 15px;
		clear: both;
		padding: 10px;
		background: #2268AE;
		color: #ffffff;
	}

	.packageitem h3 {
		font-size: 24px;
		margin: 0;
		padding: 0;
		padding-top: 3px;
		padding-bottom: 5px;
		color: #ffffff;
	}

	.packageitem img {
		float: left;
		margin-right: 10px;
	}

	.packagechildren {
		background: #ffffff;
		color: #000000;
		margin-top: 10px;
		-moz-border-radius: 15px;
		-webkit-border-radius: 15px;
		-border-radius: 15px;
		padding: 10px;
	}

	.packagechildren h3 {
		font-size: 20px;
		color: #2268AE;
		text-shadow: none;
	}

	.expandlink, .collapselink {
		float: right;

	}

	.childcatlink {

		text-decoration: none;
		color: #ffffff;
		background: #8EADCC;
		display: block;
		width: 100%;
		padding: 3px;
		padding-left: 10px;
		-moz-border-radius: 10px;
		-webkit-border-radius: 10px;
		border-radius: 10px;
		-moz-box-shadow: 1px 1px 5px #000000;
		-webkit-box-shadow: 1px 1px 5px #000000;
		box-shadow: 1px 1px 5px #000000;
	}

</style>
<script>

	jQuery(document).ready(function () {
		jQuery(".expandlink").click(function () {

			jQuery(this).parent().children(".packagechildren").slideDown();

			return false;
		});

		jQuery(".addtoit,.doqty").change(function () {
			jQuery("#packagesform").submit();
		});
	});

</script>
<br style='clear:both;'>   <br><br><br><br>
