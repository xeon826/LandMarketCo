<?php
class Mysql
{
    private $sql;
    private $query;
    public function __construct()
    {
        $this->sql = new mysqli('localhost', 'root', 'Gdadg13531', 'ivm');
        if ($this->sql->connect_error) {
            die("Connection failed: " . $this->sql->connect_error);
        }
    }
    public function get_product()
    {
        $product_id= (isset($_POST['product_id'])) ? $_POST['product_id'] : 3;
        $queryText = "SELECT * from products where id = $product_id";
        $query= $this->sql->query($queryText);
        if ($query->num_rows > 0) {
            // echo view('products', 'open');
            while ($row = $query->fetch_assoc()) {
                echo '

                <div class="container">
                    <h1>Edit Product</h1>
                    <input value="'.$row["ProductName"].'" class="product-name"></input>
                    <input value="'.$row["Label"].'" class="label"></input>
                    <input value="'.$row["StartingInventory"].'" class="starting-inventory"></input>
                    <input value="'.$row["MinimumRequired"].'" class="minimum-required"></input>
                    <button data-action="edit_product" class="edit-product">Confirm</button></br>
                    <p class="parCreate">here</p>
                    <p>here</p>
                </div>
                                 ';
            }
            // echo view('products', 'close');
        } else {
            echo "0 results";
        }
        $this->sql->close();
    }
    public function edit_product()
    {

        $prodName= (isset($_POST['prodName'])) ? $_POST['prodName'] : 3;
    //   UPDATE mytable
    // SET column1 = value1,
    //     column2 = value2
    // WHERE key_value = some_value;
        $product_name =(isset($_POST['product_name'])) ? $_POST['prouct_name']:3;
        $label=(isset($_POST['label'])) ? $_POST['label']:3;
        $starting_inventory=(isset($_POST['starting_inventory'])) ? $_POST['starting_inventory']:3;
        $minimum_required=(isset($_POST['minimum_required'])) ? $_POST['minimum_required']:3;
        $queryText = "UPDATE Products
        set Productname = $product_name,
        Label = $label,
        StartingInventory = $starting_inventory,
        ";
        $query= $this->sql->query($queryText);
        if ($query->num_rows > 0) {
            echo view('products', 'open');
            while ($row = $query->fetch_assoc()) {
                echo '
                <div class="container">
                    <h1>Edit Product</h1>
                    <input placeholder="'.$row["ProductName"].'" class="prodName"></input>
                    <input placeholder="'.$row["Label"].'" class="label"></input>
                    <input placeholder="'.$row["StartingInventory"].'" class="startingInventory"></input>
                    <input placeholder="'.$row["MinimumRequired"].'" class="minimumRequired"></input>
                    <button data-action="confirm" class="confirm-edit">Confirm</button></br>
                    <p class="parCreate">here</p>
                    <p>here</p>
                </div>
                                 ';
            }
            echo view('products', 'close');
        } else {
            echo "0 results";
        }
        $this->sql->close();
    }
    public function view_products()
    {
        $queryText = "SELECT * from products";
        $query= $this->sql->query($queryText);
        if ($query->num_rows > 0) {
            echo view('products', 'open');
            while ($row = $query->fetch_assoc()) {
                echo '
                <tr class="edit_row">
                 <td>'.$row["ProductName"].'
                 <div data-id="'.$row["id"].'" class="edit_product">
                 <i class="fas fa-times delete manage"></i>
                 <i class="fas fa-plus add manage"></i>
                 <i class="fas fa-pencil-alt edit manage"></i>
                 </div>
                 </td>
                 <td>'.$row["Label"].'</td>
                 <td>'.$row["StartingInventory"].'</td>
                 <td>'.$row["MinimumRequired"].'</td>
                 </tr>
                 ';
            }
            echo view('products', 'close');
        } else {
            echo "0 results";
        }
        $this->sql->close();
    }

    public function add_new_product()
    {
        // prodName: $('.product-create prodname').val(),
        // starting: $('.product-create startingInventory').val(),
        // minimum: $('.product-create minimumRequired').val(),
        $prodName= (isset($_POST['prodName'])) ? $_POST['prodName'] : 3;
        $starting= (isset($_POST['starting'])) ? $_POST['starting'] : 3;
        $minimum= (isset($_POST['minimum'])) ? $_POST['minimum'] : 3;
        $queryText = "insert into products (ProductName, StartingInventory, MinimumRequired)
        VALUES ('$prodName', $starting, $minimum)";
        $query= $this->sql->query($queryText);
        $this->sql->close();
    }
    public function add_purchase()
    {
        $queryText = "SELECT * FROM products";
        $query= $this->sql->query($queryText);
        if ($query->num_rows > 0) {
            // echo view('current_inv', 'open');
            echo '<option>Select a product:</option>';
            while ($row = $query->fetch_assoc()) {
                echo '
         <option>'.$row["ProductName"].'</option>
         ';
            }
            // echo view('current_inv', 'close');
        } else {
            echo "0 results";
        }
        $this->sql->close();
    }
    public function prod_dropdown()
    {
        $queryText = "SELECT * FROM products";
        $query= $this->sql->query($queryText);
        if ($query->num_rows > 0) {
            // echo view('current_inv', 'open');
            echo '<option>Select a product:</option>';
            while ($row = $query->fetch_assoc()) {
                echo '
         <option>'.$row["ProductName"].'</option>
         ';
            }
            // echo view('current_inv', 'close');
        } else {
            echo "0 results";
        }
        $this->sql->close();
    }
    public function get_current_inv()
    {
        $queryText = 'SELECT p.id, coalesce(ig.NumReceived,0) as NumReceived,
        coalesce(og.NumShipped,0) as NumShipped, p.Label,
        coalesce((p.StartingInventory-og.NumShipped+ig.NumReceived), p.StartingInventory)
        as OnHand, p.ProductName,
        p.StartingInventory, p.MinimumRequired
        from products p
        left outer join (
            select productid, sum(NumReceived) as NumReceived
            from incoming
            group by productid
        ) as ig on p.id = ig.productid
        left outer join (
            select productid, sum(NumberShipped) as NumShipped
            from outgoing
            group by productid
        ) as og on p.id = og.productid';
        // $queryText = "SELECT * FROM products limit 10 offset 0";
        $query= $this->sql->query($queryText);
        if ($query->num_rows > 0) {
            echo view('current_inv', 'open');
            while ($row = $query->fetch_assoc()) {
                echo '
                <tr>
         <td>'.$row["ProductName"].'</td>
         <td>'.$row["Label"].'</td>
         <td>'.$row["StartingInventory"].'</td>
         <td>'. $row["NumShipped"].'</td>
         <td>'.$row["NumReceived"].'</td>
         <td>'.$row["OnHand"].'</td>
         <td>'.$row["MinimumRequired"].'</td>
         </tr>
         ';
            }
            echo view('current_inv', 'close');
        } else {
            echo "0 results";
        }
        $this->sql->close();
    }
    public function get_incoming()
    {
        // purchase date, product name, number received, supplier name
        // $queryText = "SELECT * FROM incoming limit 10 offset 0";
        $queryText = "SELECT incoming.PurchaseDate, products.ProductName, incoming.NumReceived, vendors.supplier
        FROM incoming, vendors, products
        WHERE vendors.id = incoming.SupplierId and incoming.ProductId = products.id limit 10";
        $query = $this->sql->query($queryText);
        if ($query->num_rows > 0) {
            echo view('incoming', 'open');
            while ($row = $query->fetch_assoc()) {
                echo '
                <tr>
         <td>'.$row["PurchaseDate"].'</td>
         <td>'.$row["ProductName"].'</td>
         <td>'.$row["NumReceived"].'</td>
         <td>'. $row["supplier"].'</td>
         </tr>
         ';
            }
            echo view('incoming', 'close');
        } else {
            echo "0 results";
        }
        $this->sql->close();
    }
    public function get_outgoing()
    {
        $queryText = "SELECT * FROM outgoing limit 10 offset 0";
        $query = $this->sql->query($queryText);
        if ($query->num_rows > 0) {
            echo view('outgoing', 'open');
            while ($row = $query->fetch_assoc()) {
                echo '
                <tr>
         <td>'.$row["First"].'</td>
         <td>'.$row["Middle"].'</td>
         <td>'.$row["Last"].'</td>
         <td>'. $row["ProductId"].'</td>
         <td>'.$row["NumberShipped"].'</td>
         <td>'.$row["OrderDate"].'</td>
         </tr>
         ';
            }
            echo view('outgoing', 'close');
        } else {
            echo "0 results";
        }
        $this->sql->close();
    }


    public function get_archive($table, $name, $page)
    {
        $page--;
        $page *= 9;
        // return "SELECT * FROM $table where Productname like '%$name%' limit 10 offset $page";
        // $this->$mysql = new mysqli($servername, $username, $password, $dbname);
        return "SELECT * FROM $table limit 10 offset $page";
    }
    public function num_shipped($pid)
    {
        return "SELECT SUM(NumberShipped) FROM outgoing WHERE ProductId = $pid";
    }
}
$action= (isset($_POST['action'])) ? $_POST['action'] : 3;
$object = new Mysql();
switch ($action) {
  // case 'get_current_inv': get_current_inv();
  case 'get_current_inv': $object->get_current_inv();
  break;
  case 'get_outgoing': $object->get_outgoing();
  break;
  case 'get_incoming': $object->get_incoming();
  break;
  case 'prod_dropdown': $object->prod_dropdown();
  break;
  case 'add_new_product': $object->add_new_product();
  break;
  case 'view_products': $object->view_products();
  break;
  case 'get_product': $object->get_product();
  break;
}

function view($view, $operate)
{
    // if ($view=='products' && $operate == 'close') {
    //     return '<tr>
    //     <td>
    // <i class="fas fa-times edit"></i>
    // <i class="fas fa-plus edit"></i>
    // <i class="fas fa-pencil-alt edit"></i>
    //     </td>
    //     </tr>
    //     </tbody>
    //     </table>
    //     </div>
    //     ';
    // }
    if ($operate=='close') {
        return '</tbody>
        </table>
        </div>
        ';
    }
    switch ($view) {
    case 'products':
    return '
    <div class="table-wrapper">
    <table class="fl-table">
      <thead>
        <tr>
            <th>Name</th>
            <th>Label</th>
            <th>Starting Inventory</th>
            <th>Minimum Required</th>
        </tr>
        </thead>
        <tbody>
        ';
    case 'current_inv':
      return '
      <div class="table-wrapper">
      <table class="fl-table">
        <thead>
          <tr>
              <th>Name</th>
              <th>Label</th>
              <th>Current Inventory</th>
              <th>Shipped</th>
              <th>Incoming</th>
              <th>On Hand</th>
              <th>Minimum Required</th>
          </tr>
          </thead>
          <tbody>
          ';
      case 'incoming':
        return '
      <div class="table-wrapper">
      <table class="fl-table">
        <thead>
        <tr>
            <th>Purchase Date</th>
            <th>Product Name</th>
            <th>Number Received</th>
            <th>Supplier</th>
        </tr>
        </thead>
        <tbody>
          ';
      case 'outgoing':
        return '
        <div class="table-wrapper">
        <table class="fl-table">
          <thead>
            <tr>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Last Name</th>
            <th>Product ID</th>
            <th>Number Shipped</th>
            <th>Order Date</th>
        </tr>
        </thead>
        <tbody>
              ';
    }
}
