<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Re Order Point Report</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- <div class="container mt-4"> -->
        <h1 class="mb-4">Re Order Point Report</h1>
        <!-- Your content goes here -->
          <table class="table table-striped table-sm fs-9 mb-0">    
                            <thead>
                              <tr>
                                <th class="sort border-top" data-sort="product">Product</th>
                                <th class="sort border-top" data-sort="quantity_out">Quantity Remain</th>
                                <th class="sort text-end align-middle pe-0 border-top" scope="col"></th>
                              </tr>
                            </thead>
                            <tbody class="list">
                                <?php 
                                include('../../Classes/DB.php');
                                $db = new DB();
                                include('../../Classes/ProductTransaction.php');

                                $product = new ProductTransaction($db->connect());
                                $products = $product->getReOrderPointProducts();
                                foreach ($products as $product) { ?>
                              <tr>
                                <td class="align-middle product_name"><?php echo $product['product_name']; ?></td>
                                <td class="align-middle quantity_out"><?php echo $product['inventory']; ?></td>
                              </tr>
                            <?php } ?>
                            </tbody>
                          </table>
    <!-- </div> -->
    <!-- Bootstrap JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>