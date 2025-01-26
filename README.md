# Voice of Change


## Technical Details

### Database Configuration
```php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "voice_of_change";
```

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- Modern web browser with JavaScript enabled

### Dependencies
- Summernote.js for rich text editing
- Bootstrap for responsive design
- jQuery for JavaScript functionality

## Installation

1. Clone the repository
```bash
git clone https://github.com/umendra-pardhi/voiceofchange.git
```

2. Import the database
- Create a new MySQL database named `voice_of_change`
- Import the provided SQL file from the `database` folder

3. Configure database connection
- Navigate to the `config` folder
- Update database credentials in `db.php` if different from default

4. Set up web server
- Point your web server to the project directory
- Ensure proper permissions are set for upload directories

## Usage

### Accessing Admin Panel
1. Navigate to `https://localhost/voiceofchange/admin`
2. Log in with your admin credentials
3. Default credentials:
   - Username: admin@voiceofchange.com
   - Password: Admin@voiceofchange
   

## Support
For issues and feature requests, please create an issue in the repository or contact me.

## Contributing
1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a new Pull Request


## Author
- Umendra Pardhi