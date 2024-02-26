using System.Collections.Generic;

public static class UserData
{
    public static Dictionary<string, string> Users = new Dictionary<string, string>
    {
        // Adding a mock user for demonstration
        { "testUser", "password123" } // In a real application, use hashed passwords
    };
}
