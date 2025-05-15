<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Last Registration Numbers</title>
</head>
<body>
    <h2>Last Registration Numbers by Course</h2>
    <table border="1" cellpadding="10">
        <tr>
            <th>Course ID</th>
            <th>Last Registration Number</th>
        </tr>
        <?php foreach ($last_reg_nos as $course_id => $last_reg_no): ?>
            <tr>
                <td><?php echo $course_id; ?></td>
                <td><?php echo $last_reg_no ?: 'No registration number found'; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
