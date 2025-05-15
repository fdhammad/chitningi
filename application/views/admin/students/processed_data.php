<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Processed Student Data</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Processed Student Data</h2>
    <?php if (empty($processed_data)): ?>
        <div class="alert alert-warning">No records were processed.</div>
    <?php else: ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                <th>S/N</th>
                    <th>Registration No</th>
                    <th>Application No</th>
                    <th>Full Name</th>
                    <th>Course Code</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                $count=1;
                 foreach ($processed_data as $record): ?>
                    <tr>
                        <td><?= $count++ ?></td>
                        <td><?php echo $record['new_reg_no']; ?></td>
                        <td><?php echo $record['original_reg_no']; ?></td>
                        <td><?php echo $record['name']; ?></td>
                        <td><?php echo $record['course_code']; ?></td>
                       
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

</body>
</html>
