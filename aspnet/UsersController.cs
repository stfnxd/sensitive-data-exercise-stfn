using Microsoft.AspNetCore.Mvc;
using System.Linq;

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
        UserData.Users.Add(user.Username, user.Password);
        return Ok("User registered successfully.");
    }

    [HttpPost("login")]
    public IActionResult Login(User user)
    {
        if (UserData.Users.TryGetValue(user.Username, out var storedPassword))
        {
            // In a real application, verify the hashed password
            if (storedPassword == user.Password)
            {
                return Ok("Login successful.");
            }
        }
        return Unauthorized("Login failed.");
    }
}
