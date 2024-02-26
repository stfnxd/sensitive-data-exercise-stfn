import express from 'express';
import { urlencoded } from 'body-parser';

const app = express();
const port = 3000;

// Middleware to parse request body
app.use(urlencoded({ extended: true }));

// Initialize "database" with a mock user
let users = {
    "testUser": {
        password: "password123" // In a real application, use hashed passwords
    }
};

app.post('/create-user', (req, res) => {
    const { username, password } = req.body;
    
    // Basic validation
    if (!username || !password) {
        return res.status(400).send("Username and password are required.");
    }

    // Check if user already exists
    if (users.hasOwnProperty(username)) {
        return res.status(409).send("User already exists.");
    }

    // Store the user
    users[username] = { password: password }; // Store hashed password in a real scenario

    res.send("User created successfully.");
});

app.post('/login', (req, res) => {
    const { username, password } = req.body;
    
    // Check if user exists and password matches
    if (users.hasOwnProperty(username) && users[username].password === password) {
        res.send("Login successful!");
    } else {
        res.send("Login failed: Incorrect username or password.");
    }
});

app.listen(port, () => {
    console.log(`Server running at http://localhost:${port}`);
});
