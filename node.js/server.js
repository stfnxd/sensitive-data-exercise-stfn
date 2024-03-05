import express from 'express';
import { urlencoded } from 'body-parser';
import bcrypt from 'bcryptjs';

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
    
    // Hash password
    bcrypt.hash(password, 10, (err, hashedPassword) => {
        if (err) {
            return res.status(500).send("Error hashing password.");
        }

        // Basic validation
        if (!username || !hashedPassword) {
            return res.status(400).send("Username and hashed password are required.");
        }

        // Check if user already exists
        if (users.hasOwnProperty(username)) {
            return res.status(409).send("User already exists.");
        }

    // Store the user
    users[username] = { password: hashedPassword }; // Store hashed password in a real scenario

    res.send("User created successfully.");
});

app.post('/login', (req, res) => {
    const { username, password } = req.body;
    
    // Check if user exists and password matches
    if (users.hasOwnProperty(username)){
        bcrypt.compare(password, users[username].password, (err, result) => {
            if (err || !result) {
                return res.status(401).send("Login failed: Incorrect username or password.");
            }
            res.send("Login successful!");
        });
    } else {
        res.status(401).send("Login failed: User does not exist.");
    }
});

app.listen(port, () => {
    console.log(`Server running at http://localhost:${port}`);
})});
