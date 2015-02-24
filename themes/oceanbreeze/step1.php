<div class="vrpgrid_12 userbox">
    <h3>Reservation Rental Agreement</h3>

    <div class="padit" style="height:250px;overflow-y:auto;" id="rabox">
        <?= nl2br ($data->booksettings->Contract); ?>
    </div>

</div>
<div class="clear"></div>  <p style="text-align:right;"><a
        href="/vrp/book/step1/?obj[Arrival]=<?= $data->Arrival; ?>&obj[Departure]=<?= $data->Departure; ?>&obj[PropID]=<?= $_GET[ 'obj' ][ 'PropID' ]; ?>&obj[Adults]=<?= $_GET[ 'obj' ][ 'Adults' ]; ?>&obj[Children]=<?= $_GET[ 'obj' ][ 'Children' ]; ?>&printme=1"
        id="printpage">Print Agreement</a></p><br><br>
<?php
$step = "step3";
if (isset($data->booksettings->HasPackages)) {
    $step = "step1a";
}
?>
<div style="text-align: center">
    <a href="/vrp/book/<?= $step; ?>/?obj[Arrival]=<?= $data->Arrival; ?>&obj[Departure]=<?= $data->Departure; ?>&obj[PropID]=<?= $_GET[ 'obj' ][ 'PropID' ]; ?>&obj[Adults]=<?= $_GET[ 'obj' ][ 'Adults' ]; ?>&obj[Children]=<?= $_GET[ 'obj' ][ 'Children' ]; ?>"
       class="btn btn-success success">I Agree, Continue with Reservation</a>
</div>
<div class="clear"></div><br><?php /*
  <div class="vrpgrid_6 userbox" id="newuserbox">
  <h3>New Guests</h3>
  <div class="padit">
  If you are a new guest, you can continue your reservation...
  <br><br>
  <a href="/vrp/book/step2/?obj[Arrival]=<?= $data->Arrival; ?>&obj[Departure]=<?= $data->Departure; ?>&obj[PropID]=<?= $_GET['obj']['PropID']; ?>" class="bookingbutton rounded">I Agree, Continue with Reservation</a>
  </br>        </div>
  </div>
  <div class="vrpgrid_6 userbox omega" id="returnbox">
  <h3>Returning Guests</h3>
  <div class="padit">
  If you are a returning guest, please enter your login information below:
  <br>
  <br>
  <form action="" id="bookLogin" method="post">
  <table align="center">
  <tr><td>Email:</td><td><input type="text" name="email"></td></tr>
  <tr><td>Password:</td><td><input type="password" name="password"></td></tr>
  <tr><td colspan="2" align="center"><input type="submit" value="I Agree, Login" class="bookingbutton rounded"></td></tr>
  </table>
  </form>

  </div>
  </div> */
?>


<style>
    #printagreement {
        display: none;
    }

</style>
<script>
    jQuery(document).ready(function () {
        jQuery("#printpage").click(function (e) {
            e.preventDefault();

            window.open(jQuery(this).attr('href'), 'printagreement', 'height=200,width=200');

        });
    });
</script>
