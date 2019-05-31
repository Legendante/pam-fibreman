<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Welcome to Stock Control 0.1</title>
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"></script> -->

<link rel="stylesheet" href="/css/bootstrap.min.css">
<link rel="stylesheet" href="/css/jquery-ui.min.css">
<script type="text/javascript" src="js/jquery-3.1.0.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script>
function openModal()
{
	$("#addBrandModel").modal("show");
}
</script>
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<nav class="navbar navbar-default">
        <div class="container">
                <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                        </button>
                </div>

                <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                        <li id="navDashboard"><a href="#"><i class="glyphicon glyphicon-list-alt"></i> Dashboard </a></li>
                        <li id="navBrand"><a href="#"><i class="glyphicon glyphicon-btc"></i> Brand </a></li>
                        <li id="navCategories"><a href="#"><i class="glyphicon glyphicon-th-list"></i> Categories </a></li>
                        <li id="navProduct"><a href="#"><i class="glyphicon glyphicon-ruble"></i> Product </a></li>
                        <li class="dropdown"><a href="#" class="drop-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-shopping-cart"></i> Order <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                        <li id="addOrder"><a href="#"><i class="glyphicon glyphicon-plus"></i> Add Order</a></li>
                                        <li id="manageOrder"><a href="#"><i class="glyphicon glyphicon-edit"></i> Manage Order</a></li>
                                </ul>
                        </li>
                        <li class="dropdown"><a href="#"  class="drop-toggle"  data-toggle="dropdown"><i class="glyphicon glyphicon-user"></i><span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                        <li id="settings"><a href="#"><i class="glyphicon glyphicon-wrench"></i> Settings</a></li>
                                        <li id="logOut"><a href="#"><i class="glyphicon glyphicon-log-out"></i> Logout </a></li>
                                </ul>
                        </li>
                </ul>
                </div>

        </div>
</nav>
<div class="container">
  <div class="row">
        <div class="col-md-14">
                <ol class="breadcrumb">
                        <li><a href="dashboard.php">Home</a></li>
                        <li class="active">Brand</li>
                </ol>

                <div class="panel panel-default">
                        <div class="panel-heading">
                                <div class="page-heading"><i class="glyphicon glyphicon-edit"></i>Manage Brand</div>
                        </div>
                        <div class="panel-body">
                                <div class="div-action pull pull-right" style="padding-bottom:20px;">
                                        <button class="btn btn-default" data-toggle="modal" data-target="#addBrandModel"><i class="glyphicon glyphicon-plus-sign"></i>Add Brand</button>
                                </div>

                                <table class="table" id="manageBrandTable">
                                        <thead>
                                                <tr>
                                                        <th>Brand Name</th>
                                                        <th>Status</th>
                                                        <th style="width:15%;">Options</th>
                                                </tr>
                                        </thead>
                                </table>
                        </div>
                </div>
        </div>
   </div>
</div>
<div class="modal fade" id="addBrandModel" role="dialog">
    <div class="modal-dialog">

      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><i class="fa fa-plus"></i>Add Brand </h4>
        </div>

        <div class="modal-body">
               <form action="" class="form-horizontal">
                        <div class="form-group">
                                <label for="brandName" class="col-sm-3 control-label">Brand Name</label>
                                <label class="col-sm-1 control-label">:</label>

                                <div class="col-sm-8">
                                        <input type="text" name="brandName" class="form-control">
                                </div>

                                <div class="form-group">
                                        <label for="status" class="col-sm-3 control-label">Status</label>
                                        <label class="col-sm-1 control-label">:</label>
                                        <div class="col-sm-8">
                                                <select class="form-control">

                                                </select>
                                        </div>
                                </div>
                        </div>
                </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>
  </body>
</html>