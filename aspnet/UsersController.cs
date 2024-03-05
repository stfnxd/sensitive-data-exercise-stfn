using Microsoft.AspNetCore.Mvc;
using System.Linq;
using BCrypt.Net;

[ApiController]
[Route("[controller]")]
public class UsersController : ControllerBase
{
    [HttpPost("register")]
    public IActionResult Register(User user)
    {
        if (UserData.Users.ContainsKey(user.Username))
        {
            return Conflict("User already exists.");
        }

            // In a real application, hash the password
            string hashedPassword = BCrypt.Net.BCrypt.HashPassword(user.Password);

            // Store hashed password
            UserData.Users.Add(user.Username, hashedPassword);
            return Ok("User registered successfully.");
     }

    [HttpPost("login")]
    public IActionResult Login(User user)
    {
        if (UserData.Users.TryGetValue(user.Username, out var storedPassword))
        {
            // In a real application, verify the hashed password
            if (BCrypt.Net.BCrypt.Verify(user.Password, storedPassword))
            {
                return Ok("Login successful.");
            }
        }
        return Unauthorized("Login failed.");
    }
}
