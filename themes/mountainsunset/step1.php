<div class="vrpgrid_9 userbox vrpstepuserbox" style="">
    <h3>TriPower Vacation Rentals Reservation Rental Agreement</h3>

    <?php
        if (isset($_GET['tester'])) {
            echo "<pre>";
            print_r($data);
            echo "</pre>";
        }
        ?>
          <?php //if escapia isn't providing rental agreement then show this text. Not a good fix?>
        <?php if (isset($data->Agreement) && $data->Agreement != "" && $data->Agreement != "." ) { ?>
          <div class="padit" style="height:250px;overflow-y:auto;" id="rabox">
              <?= nl2br ($data->Agreement); ?>
          </div>
        <?php } else { ?> 
          <div class="padit" style="height:250px;overflow-y:auto;" id="rabox">
            <p>Thank you for choosing TriPower Vacation Rentals to reserve your vacation property.  We will process the deposit within the next 24 hours and send you a confirmation email. The rent is due 60 days prior to arrival.  If you must cancel prior to the rent being paid, the deposit is lost.  If you cancel after the rent is paid, the rent is lost unless we are able to rebook the property.  The deposit is refunded 10 days after your departure if there are no damages.</p>
          </div>
        <?php } ?>

</div>
<p style="text-align:right;"><a
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
<div class="clear"></div><br>


<style>
    #printagreement {
        display: none;
    }

</style>
<script>
    jQuery(document).ready(function () {
        jQuery("#printpage").click(function (e) {
            e.preventDefault();

            window.open(jQuery(this).attr('href'), 'printagreement');

        });
    });
</script>
