
        <div class="col-md-12">
<div class="row">
<h1 class="page-header">
   All Orders

</h1>
<h4 class="text-success"><?php display_message(); ?></h4>
</div>

<div class="row">
<table class="table table-hover">
    <thead>
      <tr>
           <th>id</th>
           <th>Price</th>
           <th>Transaction</th>
           <th>Currency</th>
           <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php display_orders(); ?>
    </tbody>
</table>
</div>
