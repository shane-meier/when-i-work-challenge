<?php
// huge redflag and not a proper way of allowing connection. Just quick and easy for the challenge purposes
header('Access-Control-Allow-Origin: *');

// basic check incase we are not hitting our file for the correct purpose or the file doesn't match what we require
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    // Upload File incase of failure or later reference
    $targetDirectory = "uploads/";
    $targetFile = $targetDirectory . basename($_FILES['file']['name']);

    $fileData = file_get_contents($_FILES["file"]["tmp_name"]);
    $jsonData = json_decode($fileData, true);
} else {
    return 'invalid request';
}

$employeeTotalRegularHours = [];
$invalidShifts = [];

// Work through each shift for Employees
foreach ($jsonData as $shift) {
    $employeeID = $shift['EmployeeID'];
    // convert the times passed to us for easier calculations
    $startTime = new DateTime($shift['StartTime'], new DateTimeZone('UTC'));
    $endTime = new DateTime($shift['EndTime'], new DateTimeZone('UTC'));

    // Working through the invalidShifts and not correctly working at the moment. Causing the end calculations for the employee to be incorrect.
    // With more time would like to move a lot of these calculations to a service

    // Check for overlapping shifts with the same EmployeeID
    foreach ($employeeTotalRegularHours[$employeeID] ?? [] as $existingShift) {
        // Need to check StartTime and EndTime exist before processing them
        if (isset($existingShift['StartTime'], $existingShift['EndTime']) &&
            doIntervalsOverlap($startTime, $endTime, $existingShift['StartTime'], $existingShift['EndTime'])
        ) {
            $invalidShifts[$employeeID][] = $shift['ShiftID'];
            $invalidShifts[$employeeID][] = $existingShift['ShiftID'];
            continue 2;
        }
    }

    // Calculate the start of the week
    $shiftHours = $startTime->diff($endTime)->h + ($startTime->diff($endTime)->i / 60);
    $weekStart = clone $startTime;
    // change to knowning the users timezone and setting it instead of the hardcoded UTC
    $weekStart->modify('last sunday')->setTimezone(new DateTimeZone('UTC'));

    $employeeTotalRegularHours[$employeeID][] = [
        'ShiftID' => $shift['ShiftID'],
        'StartOfWeek' => $weekStart->format('Y-m-d'),
        'Hours' => min($shiftHours, 40),
    ];
}

// Need to correctly format our data for the frontend 
$timesheetCalculatedData = [];

foreach ($employeeTotalRegularHours as $employeeID => $employeeShifts) {
    $timesheetItem = [
        'EmployeeID' => $employeeID,
    ];

    // Create an array to store the total regular and overtime hours for the current week
    $weekTotals = [
        'RegularHours' => 0, // the 0 is a place holder for both values
        'OvertimeHours' => 0,
    ];

    foreach ($employeeShifts as $employeeShift) {
        // Set the start of the week we want to calculate for
        $timesheetItem['StartOfWeek'] = $employeeShift['StartOfWeek'];

        // Check if the shift is in the same week
        if ($employeeShift['StartOfWeek'] === $timesheetItem['StartOfWeek']) {
            // Calculate the hours
            $shiftRegularHours = $employeeShift['Hours'];

            // Update total regular and overtime hours for the current week
            $weekTotals['RegularHours'] += $shiftRegularHours;
        }
    }

    // Update total regular and overtime hours for the employee and week
    $timesheetItem['RegularHours'] = $weekTotals['RegularHours'];
    $timesheetItem['OvertimeHours'] = $weekTotals['OvertimeHours'];

    // not a huge fan of this if statement. feels it can be messaged a bit
    if ($timesheetItem['RegularHours'] > 40) {
        $timesheetItem['OvertimeHours'] = $timesheetItem['RegularHours'] - 40;
        $timesheetItem['RegularHours'] = 40;
    } else {
        $timesheetItem['OvertimeHours'] = 0; 
    }

    $timesheetItem['InvalidShifts'] = $invalidShifts[$employeeID] ?? [];
    $timesheetCalculatedData[] = $timesheetItem;
}

usort($timesheetCalculatedData, function ($item1, $item2) {
    return $item1['EmployeeID'] <=> $item2['EmployeeID'];
});

// Prepare the response data
$responseData = [
    'success' => true,
    'message' => 'Data processed successfully',
    'data' => $timesheetCalculatedData,
];

// Set the content type to JSON
header('Content-Type: application/json');

// Return the JSON response
echo json_encode($responseData);

// Attempt to validate a shift does not overlap 
function doIntervalsOverlap($start1, $end1, $start2, $end2) {
    return max($start1, $start2) < min($end1, $end2);
}
?>