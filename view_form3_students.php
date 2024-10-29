<?php
session_start();
include 'connect.php';

// Check if the necessary session variables are set
$id = $_SESSION['id'] ?? null;
$lname = $_SESSION['lname'] ?? '';
$fname = $_SESSION['fname'] ?? '';
$mname = $_SESSION['mname'] ?? '';

// Fetch adviser's name for the user
$sqlAdviser = "SELECT u_lname, u_fname, u_mname FROM users_tbl WHERE u_level = 2 LIMIT 1";
$resultAdviser = $conn->query($sqlAdviser);

$adviserName = '';
if ($resultAdviser->num_rows > 0) {
    $rowAdviser = $resultAdviser->fetch_assoc();
    $adviserName = $rowAdviser['u_lname'] . ' ' . $rowAdviser['u_fname'] . ' ' . $rowAdviser['u_mname'];
}

// Fetch student's name
$studentName = htmlspecialchars($lname . ", " . $fname . " " . $mname);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SCALE Individual Activity Plan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        form {
            background-color: white;
            border: 1px solid black;
            border-radius: 5px;
            padding: 20px;
            max-width: 800px;
            margin: 50px auto;
            height: 600px;
            overflow: auto;
        }
        header { text-align: center; }
        th { font-size: 15px; }
        .add-button { margin-top: 10px; display: block; }
    </style>
    <script>
        // Function to add rows dynamically in specified tables
        function addRow(tableId) {
            let table = document.getElementById(tableId);
            let row = table.insertRow();
            for (let i = 0; i < table.rows[0].cells.length; i++) {
                let cell = row.insertCell(i);
                cell.innerHTML = '<input type="text" name="' + tableId + '[]" />';
            }
        }
    </script>
</head>
<body>
    <form action="submit_activity.php" method="post">
        <header>
            PHILIPPINE SCIENCE HIGH SCHOOL SYSTEM<br>
            SCALE INDIVIDUAL ACTIVITY PLAN
        </header>

        <!-- Student and Adviser Info -->
        <table>
            <tr>
                <th>Name of Student:</th>
                <td><?php echo $studentName; ?></td>
            </tr>
            <tr>
                <th>Name of Adviser:</th>
                <td><?php echo htmlspecialchars($adviserName); ?></td>
            </tr>
            <tr>
                <th>Batch:</th>
                <td><input type="text" name="batch" /></td>
            </tr>
        </table>

        <!-- Activity Details -->
        <div class="section-title">Activity Details</div>
        <table>
            <tr>
                <th>Title of Activity:</th>
                <td><input type="text" name="activity_title" /></td>
            </tr>
            <tr>
                <th>Type of Activity:</th>
                <td>
                    <input type="radio" name="activity_type" value="Individual"> Individual
                    <input type="radio" name="activity_type" value="Group"> Group
                </td>
            </tr>
            <tr>
                <th>Strand:</th>
                <td>
                    <input type="checkbox" name="strand[]" value="Service"> Service
                    <input type="checkbox" name="strand[]" value="Action"> Action
                    <input type="checkbox" name="strand[]" value="Creativity"> Creativity
                    <input type="checkbox" name="strand[]" value="Leadership"> Leadership
                </td>
            </tr>
        </table>

        <!-- Objectives -->
        <div class="section-title">Objectives</div>
        <table>
            <tr>
                <th><input type="checkbox" name="objective[]" value="Increased awareness"> Increased awareness of strengths</th>
            </tr>
            <tr>
                <th><input type="checkbox" name="objective[]" value="Undertaken challenges"> Undertaken new challenges</th>
            </tr>
            <!-- Add more objectives as needed -->
        </table>

        <!-- Planning and Implementation Dates -->
        <div class="section-title">Planning and Implementation Dates</div>
        <table>
            <tr>
                <th>Planning Dates (Start-End):</th>
                <td><input type="date" name="planning_start" /> to <input type="date" name="planning_end" /></td>
            </tr>
            <tr>
                <th>Implementation Dates (Start-End):</th>
                <td><input type="date" name="implementation_start" /> to <input type="date" name="implementation_end" /></td>
            </tr>
            <tr>
                <th>Venue:</th>
                <td><input type="text" name="venue" /></td>
            </tr>
        </table>

        <!-- Persons Involved -->
        <div class="section-title">Persons Involved</div>
        <table id="personsInvolved">
            <tr>
                <th>Adult Supervisor/Collaborator</th>
                <th>Designation/Position</th>
                <th>Company/Affiliation</th>
                <th>Contact Info</th>
            </tr>
            <tr>
                <td><input type="text" name="supervisor[]" /></td>
                <td><input type="text" name="designation[]" /></td>
                <td><input type="text" name="company[]" /></td>
                <td><input type="text" name="contact[]" /></td>
            </tr>
        </table>
        <button type="button" onclick="addRow('personsInvolved')" class="add-button">Add More Persons</button>

        <!-- Materials Needed -->
        <div class="section-title">Materials and Resources Needed</div>
        <table id="materialsNeeded">
            <tr>
                <th>Qty</th>
                <th>Items</th>
                <th>Unit Cost</th>
                <th>Amount</th>
            </tr>
            <tr>
                <td><input type="text" name="qty[]" /></td>
                <td><input type="text" name="items[]" /></td>
                <td><input type="text" name="unit_cost[]" /></td>
                <td><input type="text" name="amount[]" /></td>
            </tr>
        </table>
        <button type="button" onclick="addRow('materialsNeeded')" class="add-button">Add More Materials</button>

        <!-- Activity Risk Assessment -->
        <div class="section-title">Activity Risk Assessment</div>
        <table id="riskAssessment">
            <tr>
                <th>Potential Hazards</th>
                <th>Safety Precautions</th>
            </tr>
            <tr>
                <td><input type="text" name="hazards[]" /></td>
                <td><input type="text" name="precautions[]" /></td>
            </tr>
        </table>
        <button type="button" onclick="addRow('riskAssessment')" class="add-button">Add More Risks</button>

        <!-- Certification -->
        <div class="section-title">Certification</div>
        <p>
            I certify that I have understood the potential hazards and risks...<br><br>
            Signature of Student: ________________________ Date: ____________<br><br>
            Name and Signature of Parent/Guardian: ________________________ Date: ____________<br><br>
            Name and Signature of SCALE Adviser: ________________________ Date: ____________
        </p>

        <div class="action-buttons">
            <button type="submit">Submit</button>
        </div>
    </form>
</body>
</html>

