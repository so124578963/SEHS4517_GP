const express = require('express');
const bodyParser = require('body-parser');
const path = require('path');

const app = express();
const PORT = 8080;

var cors = require('cors');
app.use(cors());

// Middleware to parse JSON bodies
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));

// Set EJS as the templating engine
app.set('view engine', 'ejs');
app.set('views', path.join(__dirname, 'views'));

// Route to handle reservation data
app.post('/success', (req, res) => {
    const { customer_email_address, order_number, start_time, total_amount, reservation_item } = req.body;

    // Here you can add logic to save the reservation to a database if needed

    // Render the thank you page with the reservation details
    res.render('success', { customer_email_address, order_number, start_time, total_amount, reservation_item });
});

// Start the server
app.listen(PORT, () => {
    console.log(`Server is running on http://localhost:${PORT}`);
});