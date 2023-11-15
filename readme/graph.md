# How Diagrams and charts were made

This code snippet is creating a Doughnut Chart using the Chart.js library, which is a popular JavaScript library for creating interactive and customizable charts. Let's break down the code step by step:

1. **Canvas Setup:**
   ```javascript
   var doughnutCtx = document.getElementById('doughnutChart').getContext('2d');
   ```
   This line gets the 2D rendering context of the canvas element with the id 'doughnutChart'. It is assumed that there is an HTML canvas element with this id in the document.

2. **Chart Initialization:**
   ```javascript
   var doughnutChart = new Chart(doughnutCtx, {
       type: 'doughnut',
       data: {
           // Data for the chart
       },
       options: {
           // Chart options
       }
   });
   ```
   Here, a new instance of the Chart class is created and configured with the specified type ('doughnut') and options.

3. **Data Configuration:**
   ```javascript
   data: {
       labels: <?php echo json_encode(array_column($salesByBookstoreData, 'bookstore_name')); ?>,
       datasets: [{
           data: <?php echo json_encode(array_column($salesByBookstoreData, 'totalSales')); ?>,
           backgroundColor: [
               'rgba(255, 99, 132, 0.7)',
               'rgba(54, 162, 235, 0.7)',
               'rgba(255, 206, 86, 0.7)',
           ],
           borderColor: [
               'rgba(255, 99, 132, 1)',
               'rgba(54, 162, 235, 1)',
               'rgba(255, 206, 86, 1)',
           ],
           borderWidth: 1
       }]
   }
   ```
   - The `labels` property contains an array of labels for each segment of the doughnut chart. These labels are generated using PHP to encode the 'bookstore_name' column from the [`$salesByBookstoreData`](#How-$salesByBookstoreData-is-generated) array.
   - The `datasets` property is an array containing an object with the chart data and styling information.
     - `data` holds an array of numerical values, representing the size of each segment. This is generated using PHP to encode the 'totalSales' column from the `$salesByBookstoreData` array.
     - `backgroundColor` and `borderColor` arrays specify the colors of the segments. In this case, three colors are defined for three segments.

4. **Chart Options:**
   ```javascript
   options: {
       responsive: true,
       maintainAspectRatio: false,
   }
   ```
   - `responsive: true` makes the chart responsive, meaning it will resize based on the dimensions of its container.
   - `maintainAspectRatio: false` ensures that the chart does not maintain a constant aspect ratio when resizing. It allows the chart to adapt to the dimensions of its container.

### How $salesByBookstoreData is generated

The PHP code is part of a process to convert a result set obtained from a MySQL database query into a format suitable for creating the Doughnut Chart.


1. **Initialization of an Empty Array:**
   ```php
   $salesByBookstoreData = [];
   ```
   This line initializes an empty array named `$salesByBookstoreData`. This array will be used to store the data that will be later used to generate the Doughnut Chart.

2. **Fetching Rows from the Result Set:**
   ```php
   while ($row = mysqli_fetch_assoc($salesByBookstoreResult)) {
   ```
   This line starts a `while` loop that iterates over each row of the result set. The `mysqli_fetch_assoc` function fetches the next row from the result set as an associative array, where the keys are the column names.

3. **Building the Data Array:**
   ```php
       $salesByBookstoreData[] = [
           'bookstore_name' => $row['bookstore_name'],
           'totalSales' => $row['totalSales'],
       ];
   ```
   Inside the loop, for each row, a new associative array is created and appended to the `$salesByBookstoreData` array. This new array has two key-value pairs:
   - `'bookstore_name'` is assigned the value of the 'bookstore_name' column from the current row.
   - `'totalSales'` is assigned the value of the 'totalSales' column from the current row.

   This process effectively transforms each row of the result set into a structure that is more convenient for charting, with named keys for each data attribute.

4. **End of Loop:**
   ```php
   }
   ```
   This marks the end of the `while` loop, meaning that all rows from the result set have been processed and converted into the `$salesByBookstoreData` array.

After this code, the `$salesByBookstoreData` array would contain a structured set of data that can be easily used for creating charts, such as a Doughnut Chart, as shown in the JavaScript code snippet you provided earlier.