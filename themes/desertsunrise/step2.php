
<div class="vrpgrid_6 userbox alpha " id="newuserbox">
    <h3>New Guests</h3>
    <div class="padit">
        If you are a new guest, you can continue your reservation...
        <br><br><br>
        <a href="/vrp/book/step3/?obj[Arrival]=<?php echo esc_attr( $data->Arrival ); ?>&obj[Departure]=<?php echo esc_attr( $data->Departure ); ?>&obj[PropID]=<?php echo esc_attr( $_GET['obj']['PropID'] ); ?>" class="bookingbutton rounded">Continue with Reservation</a>
		</br>        </div>
</div><div class="vrpgrid_6 userbox omega" id="returnbox">
	<h3>Returning Guests</h3>
	<div class="padit">
		If you are a returning guest, please enter your login information below:
		<br>
		<br>        
		<form action="" id="bookLogin" method="post">
			<table align="center">
				<tr>
					<td>Email:</td>
					<td>
						<input type="text" name="email">
					</td>
				</tr>
				<tr>
					<td>
						Password:
					</td>
					<td>
						<input type="password" name="password">
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<input type="submit" value="Login" class="bookingbutton rounded">
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
