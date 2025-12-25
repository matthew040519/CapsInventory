<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sales Report</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- <div class="container mt-4"> -->
        <h1 class="mb-4">Sales Report</h1>
        <!-- Your content goes here -->
         <table class="table table-sm fs-9 mb-0">
                  <thead>
                    <tr>
                      <!-- <th class="white-space-nowrap fs-9 align-middle ps-0" style="width:26px;">
                        <div class="form-check mb-0 fs-8">
                          <input class="form-check-input" id="checkbox-bulk-order-select" type="checkbox" data-bulk-select='{"body":"order-table-body"}' />
                        </div>
                      </th> -->
                      <!-- <th class="sort white-space-nowrap align-middle pe-3" scope="col" data-sort="order" style="width:5%;">ORDER</th> -->
                      
                      <th class="sort align-middle ps-8" scope="col" data-sort="customer">Project</th>
                      <!-- <th class="sort align-middle pe-0" scope="col" data-sort="date">Credit</th> -->
                      <th class="sort align-middle pe-0" scope="col" data-sort="amount">Debit</th>
                      <th class="sort align-middle" scope="col" data-sort="date">Sales</th>
                    </tr>
                  </thead>
                  <tbody class="list" id="order-table-body">
                    <?php 
                    // Include database and object files 
                    include_once('../../Classes/DB.php');
                    include_once('../../Classes/Projects.php');
                    $db = new DB();
                    $project = new Projects($db->connect());
                    $loans = $project->getAllProjectLoans();
                    foreach ($loans as $loan) {
                    ?>
                    <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                      <td class="date align-middle white-space-nowrap text-body-tertiary"><?php echo $loan['project_name']; ?></td>
                      <td class="amount align-middle white-space-nowrap text-body-tertiary"><?php echo number_format($loan['debit'], 2); ?></td>
                      <td class="date align-middle white-space-nowrap text-body-tertiary"><?php echo $loan['tdate']; ?></td>
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