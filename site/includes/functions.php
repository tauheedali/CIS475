<?php
$title = "Tauheed's Website";
$page = "Tauheed's CIS475 Website";
$today = date("Y-m-d H:i:s a");
$editor = 'PHPStorm';
$author = 'Tauheed Ali';
$server = 'Docker containers';
$meta = [
    'keywords' => "HTML, $server, , $editor",
    'description' => 'CIS 475 Website',
    'author' => $author,
    'viewport' => 'width=device-width, initial-scale=1.0'
];
$baseUrl = $_SERVER['SERVER_NAME'] == 'localhost' ? '/' : '/~alit01/';
function getAssignmentStatus($date)
{
    $due = new DateTime($date);
    $today = new DateTime();
    if ($due < $today) {
        return $today->diff($due)->format('%a days late');
    } else if ($due > $today) {
        return $today->diff($due)->format('%a days until due');
    } else {
        return "due today";
    }
}

function displayAssignments()
{
    global $assignments;
    ?>
    <div class="row" id="assignments">
        <?php foreach ($assignments as $i => $assignment): ?>
            <div class="col-3 my-3">
                <div class="assignment-card">
                    <b>Assignment <?= $i + 1; ?></b>
                    <hr/>
                    <div class="assignment-card-body">
                        <p><?= $assignment['title']; ?></p>
                        <p>Due: <?= $assignment['due_date']; ?></p>
                        <?php if ($assignment['completed']): ?>
                            <p>Completed!</p>
                        <?php else: ?>
                            <p>Time Remaining: <?= getAssignmentStatus($assignment['due_date']); ?></p>
                        <?php endif; ?>
                    </div>
                    <a href="<?= $assignment['url']; ?>" target="_blank"><small>Assignment Details</small></a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php
}

function getAssignmentByName($title)
{
    global $assignments;
    $assignment = array_filter($assignments, function ($assignment) use ($title) {
        return $assignment['title'] == $title;
    });
    if (isset($assignment)) {
        return current($assignment);
    }
    
    return NULL;
}

// This function makes a connection to the server
function dbConnect()
{
    global $debug, $dbServer, $dbUsername, $dbPassword, $dbDatabase;
    // connect to the server
    $dbConn = new mysqli($dbServer, $dbUsername, $dbPassword, $dbDatabase);
    // check is connection was successful
    if ($dbConn->connect_errno) {
        echo "Failed to connect to MySQL: " . $dbConn->connect_error;
        exit();
    }
    
    // return the connection object
    return $dbConn;
}

// This function creates a table in the database
function dbCreate($dbConn)
{
    global $debug;
    // create DROP query
    // execute the query to MySQL
    $success = $dbConn->query("DROP TABLE IF EXISTS monthsTable;");
    $createResult = FALSE;
    if ($success) {
        // setup CREATE query
        // execute the query to MySQL
        $createResult = $dbConn->query("CREATE TABLE monthsTable (monthsID INT,monthName VARCHAR(10),monthDays INT(2));");
    }
    
    // return result status
    return $createResult;
}

// This function inserts records into the table
function dbInsert($dbConn)
{
    global $debug, $monthsArray; // add your arrays here
    // use a for loop to walk through array
    for ($i = 0; $i < count($monthsArray); $i++) { // put the name of your array in place of 'xyz'
        // setup INSERT query
        $q = $dbConn->prepare("INSERT INTO monthsTable (monthsID,monthName,monthDays) VALUES (?,?,?)");
        $q->bind_param("isi", $monthsArray[$i]['monthsID'], $monthsArray[$i]['monthName'], $monthsArray[$i]['monthDays']);
        // execute the query to MySQL
        $q->execute();
    }
}

// This function reads the file into arrays
function fileRead()
{
    global $debug, $monthsArray;
    if ($debug) {
        echo("In fileRead()<br />");
    }
    $inFile = file("cis475_io.txt");
    $cnt = 0;
    foreach ($inFile as $inLine) {
        list($id, $name, $days) = explode(",", $inLine);
        // Remove newline
        $days = trim($days);
        if ($debug) {
            echo("$id, $name, $days<br/>\n");
        }
        $monthsArray[] = [
            'monthsID' => $id,
            'monthName' => $name,
            'monthDays' => $days,
        ];
    }
    if ($debug) {
        echo "<pre>";
        print_r($monthsArray);
        echo "</pre>";
    }
}

function reverseFile($months)
{
    $outFile = fopen("cis475_ior.txt", "w");
    while ($month = array_pop($months)) {
        fwrite($outFile, implode(',', $month) . PHP_EOL);
    }
    fclose($outFile);
}

function readTextFile()
{
    $inFile = file("cis475_io.txt");
    $monthsArray = [];
    foreach ($inFile as $inLine) {
        list($id, $name, $days) = explode(",", $inLine);
        // Remove newline
        $days = trim($days);
        $monthsArray[] = [
            'monthNumber' => $id,
            'monthName' => $name,
            'monthDays' => $days,
        ];
    }
    reverseFile($monthsArray);
    
    return $monthsArray;
}

// This function gets months from the database and
// generates an HTML table
function getMonthsTable()
{
    //Get months from DB
    $conn = dbConnect();
    $result = $conn->query('SELECT * FROM monthsTable') or die('Error fetching MYSQL result');
    $months = $result->fetch_all(MYSQLI_ASSOC);
    //Generate months table, styling odd and even rows
    ?>
    <table class="table table-striped">
        <thead>
        <tr class="bg-info text-white">
            <th>ID</th>
            <th>Name</th>
            <th>Days</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($months as $index => $month): ?>
            <tr class="<?= $index % 2 == 0 ? 'bg-light text-dark' : 'bg-secondary text-white'; ?>">
                <td><?= $month['monthsID']; ?></td>
                <td><?= $month['monthName']; ?></td>
                <td><?= $month['monthDays']; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php
}

//Redirect to a new page using JavaScript
function redirect($url)
{
    $output = '<script type="text/javascript">';
    $output .= 'window.location = "' . $url . '"';
    $output .= '</script>';
    echo $output;
}