const express = require('express');
const mysql = require('mysql');
const app = express();
const port = 3000;

const connection = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'mechanik'
});

connection.connect(err => {
    if (err) {
        console.error('Error connecting to database:', err);
        return;
    }
    console.log('Connected to database');
});

app.get('/data', (req, res) => {
    const currentMonth = new Date().getMonth() + 1; // miesiące w JS są zero-indeksowane
    const currentYear = new Date().getFullYear();
    const query = `
        SELECT DATE(date) as date, MIN(fundA) as fundA
        FROM transactions
        WHERE MONTH(date) = ? AND YEAR(date) = ?
        GROUP BY DATE(date)
    `;
    
    connection.query(query, [currentMonth, currentYear], (err, results) => {
        if (err) {
            console.error('Error fetching data:', err);
            res.status(500).send('Error fetching data');
            return;
        }
        res.json(results);
    });
});

app.listen(port, () => {
    console.log(`Server running at http://localhost:${port}`);
});
