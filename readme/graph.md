# How Diagrams and charts were made

This code snippet is creating a Doughnut Chart using the Chart.js library, which is a popular JavaScript library for creating interactive and customizable charts. Let's break down the code step by step:

## What is Chart.Js
Chart.js is a popular JavaScript library for creating interactive and visually appealing charts and graphs on the web. It provides a simple yet powerful way to visualize data in various formats, such as line charts, bar charts, pie charts, doughnut charts, radar charts, and more.  
Key features and concepts in Chart.js:

1. **Chart Types:**
   - Chart.js supports a variety of chart types, including:
     - **Line Chart:** Shows data points connected by straight lines.
     - **Bar Chart:** Represents data using rectangular bars.
     - **Radar Chart:** Displays data points on spokes emanating from the center.
     - **Doughnut and Pie Charts:** Circular charts representing data in segments.
     - **Polar Area Chart:** Similar to a pie chart but displayed in a polar coordinate system.
     - **Bubble Chart:** Visualizes data using bubbles of varying sizes.
     - **Scatter Plot:** Displays individual data points without connecting lines.

2. **Easy Integration:**
   - Chart.js is easy to integrate into web projects. It requires a canvas element to render the chart, making it compatible with HTML5.

3. **Responsive Design:**
   - Charts created with Chart.js can be made responsive, adapting to different screen sizes and devices.

4. **Customization:**
   - Users can customize various aspects of the charts, including colors, fonts, tooltips, and animation effects. Chart.js provides a high level of flexibility to meet specific design requirements.

5. **Tooltips and Interactivity:**
   - Charts can display tooltips that provide additional information when users hover over data points. Interactive features, such as click events and hover effects, enhance the user experience.

6. **Animations:**
   - Chart.js includes built-in animations that provide a smooth transition when rendering or updating data. Animations can be configured and customized based on the application's needs.

7. **Data Binding:**
   - Charts are data-driven, and Chart.js supports dynamic data binding. You can update the chart by modifying the underlying data, making it suitable for real-time data visualization.

8. **Plugins:**
   - Chart.js has a plugin system that allows developers to extend its functionality. This enables the integration of additional features and custom chart types.

9. **Documentation and Community:**
   - Chart.js is well-documented, making it easy for developers to get started. The library has an active community, and there are many resources, tutorials, and examples available online.

10. **Compatibility:**
    - Chart.js works across modern web browsers and is compatible with major frameworks like Angular, React, and Vue.js.

## How it is used to create graphs in the website

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
   - The `labels` property contains an array of labels for each segment of the doughnut chart. These labels are generated using PHP to encode the 'bookstore_name' column from the `$salesByBookstoreData` array.
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