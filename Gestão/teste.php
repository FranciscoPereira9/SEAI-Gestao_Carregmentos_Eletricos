<?php
include "db_conn.php";
include "functions.php";
 ?>

<div class="selector">
  <Select id="colorselector">
    <option value="none"></option>
    <?php
    $a=1;
    while ($a <= 10) {
      ?> <option value="<?php echo $a; ?>"><?php echo $a; ?></option>
      <?php
  $a++;  } ?>
  </Select>
</div>
  <span class="title"> <b>Fast VS Normal charging</b></span>

<?php $b=1; while ($b <= 10) {
  ?><div class="wrapper1">
    <div id="<?php echo $b; ?>" class="count_charger_type"></div>
  </div>

<?php $fast = count_fast($b); $normal = count_normal($b);

 ?>
<script>
Morris.Donut({
  element : '<?php echo $b; ?>',
  data: [
    { label: "Nr. Fast Charging", value: <?php echo $b; ?>},
    { label: "Nr. Normal Charging", value: <?php echo $b; ?>}
  ]
});

</script>



  <?php
$b++;

} ?>



<script>
$(function() {
    $('#colorselector').change(function(){
        $('.count_charger_type').hide();
        $('#' + $(this).val()).show();
    });
});


</script>
