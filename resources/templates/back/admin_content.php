<!-- FIRST ROW WITH PANELS -->
<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Dashboard <small>Statistics Overview</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> Dashboard
            </li>
            <h3 class="text-danger"><?php display_message(); ?></h3>
        </ol>
    </div>
</div>
<!-- /.row -->
    <div class="col-lg-6">
       <div class="panel panel-default">
           <div class="panel-heading">
               <h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Reports</h3>
           </div>
           <div class="panel-body">
               <div class="table-responsive">
                   <table class="table table-bordered table-hover table-striped">
                       <thead>
                           <tr>
                               <th>Id</th>
                               <th>Product Id</th>
                               <th>Order Id</th>
                               <th>Price</th>
                               <th>Product Title</th>
                               <th>Product Quantity</th>
                               <th>Delete</th>
                           </tr>
                       </thead>
                       <tbody>
                         <?php get_reports(); ?>
                       </tbody>
                   </table>
               </div>
           </div>
       </div>
   </div>
</div>
<!-- /.row -->
