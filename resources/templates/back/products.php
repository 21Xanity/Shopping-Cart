

             <div class="row">

<h1 class="page-header">
   All Products

</h1>
<h3 class="text-success"><?php display_message(); ?> </h3>
<table class="table table-hover">


    <thead>

      <tr>
           <th>Id</th>
           <th>Title</th>
           <th>Category</th>
           <th>Price</th>
           <th>Quantity</th>
      </tr>
    </thead>
    <tbody>
      <?php get_product_in_admin(); ?>
  </tbody>
</table>

              </div>
