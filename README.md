# Laravel Todo Application

A modern, responsive todo application built with Laravel 10, featuring user authentication, task management, and a clean user interface.

## Features

- **User Authentication**: Registration, login, and logout functionality
- **Task Management**: Create, read, update, delete, and toggle task completion
- **Profile Management**: Update user profile information and change passwords
- **Modern UI**: Responsive design with Bootstrap 5 and FontAwesome icons
- **Interactive Confirmations**: SweetAlert2 dialogs for better user experience
- **AJAX Operations**: Smooth task operations without page reloads

## Screenshots

*Note: Add screenshots of your application here showing:*
- Login/Registration pages
- Task management interface
- Profile management page
- Mobile responsive design

## Setup Instructions

### Prerequisites

- PHP 8.2 or higher
- Composer
- XAMPP (or similar local server environment)
- SQLite support enabled in PHP

### Installation Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/Ivan36/todo-app.git
   cd todo-app
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Environment Configuration**
   - Copy the `.env` file (already configured for SQLite)
   - The application is pre-configured to use SQLite database
   - No additional environment variables need to be changed

4. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

5. **Database Setup**
   - The SQLite database file should already exist at `database/database.sqlite`
   - If not, create it manually or the application will create it automatically
   - Run migrations to create the required tables:
   ```bash
   php artisan migrate
   ```

6. **Start the Development Server**
   ```bash
   php artisan serve
   ```
   The application will be available at `http://localhost:8000`

## Database Configuration

This application uses SQLite as the database system for simplicity and portability.

### Database Settings (`.env` file)
```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

### Database Schema

The application uses the following main tables:

1. **users** - Stores user account information
   - id, name, email, password, timestamps

2. **tasks** - Stores todo tasks
   - id, user_id, title, description, is_completed, timestamps

3. **migrations** - Laravel's migration tracking table

### Key Database Design Decisions

- **SQLite Choice**: Selected for easy setup and portability across different environments
- **User-Task Relationship**: One-to-many relationship ensuring users can only see their own tasks
- **Soft Deletes**: Not implemented to keep the application simple, but could be added for data recovery

## Architecture & Design Decisions

### Backend Architecture

- **MVC Pattern**: Standard Laravel MVC architecture
- **Controllers**: 
  - `TaskController` - Handles all task-related operations
  - `AuthController` - Manages user authentication
  - `ProfileController` - User profile management
- **Models**: Eloquent ORM models with proper relationships
- **Middleware**: Authentication middleware to protect routes

### Frontend Architecture

- **Blade Templating**: Server-side rendering with Blade templates
- **Bootstrap 5**: Responsive CSS framework
- **jQuery**: For AJAX operations and DOM manipulation
- **FontAwesome**: Icon library for better visual experience
- **SweetAlert2**: Enhanced user dialogs and confirmations

### Security Considerations

- **Authentication**: Laravel's built-in authentication system
- **Authorization**: Users can only access their own tasks
- **CSRF Protection**: All forms include CSRF tokens
- **Password Hashing**: Secure password hashing using Laravel's Hash facade
- **Input Validation**: Server-side validation for all user inputs

## Key Features Implementation

### Task Toggle Functionality
- AJAX-powered task completion toggle
- Real-time UI updates without page refresh
- Proper error handling and user feedback

### User Registration & Authentication
- Complete registration system with validation
- Automatic login after successful registration
- Secure logout with confirmation dialog

### Profile Management
- Update user information (name, email)
- Change password with current password verification
- Account deletion with confirmation

### Responsive Design
- Mobile-first approach
- Bootstrap grid system for layout
- Consistent spacing and typography

## Challenges Faced & Solutions

### 1. Database Path Configuration
**Challenge**: Initial hardcoded database paths caused portability issues.
**Solution**: Implemented relative path configuration using Laravel's `base_path()` helper.

### 2. Task Toggle JavaScript Logic
**Challenge**: Toggle functionality only worked in one direction.
**Solution**: Fixed JavaScript boolean logic and data attribute handling.

### 3. Icon Loading Issues
**Challenge**: FontAwesome icons not displaying properly.
**Solution**: Added CDN links and proper CSS classes.

### 4. User Experience Enhancements
**Challenge**: Basic form submissions felt clunky.
**Solution**: Implemented AJAX operations and SweetAlert2 confirmations.

## API Endpoints

### Authentication Routes
- `GET /` - Login page (redirects to tasks if authenticated)
- `POST /login` - Process login
- `POST /register` - Process registration
- `POST /logout` - Logout user

### Task Management Routes
- `GET /tasks` - Display user's tasks
- `POST /tasks` - Create new task
- `PUT /tasks/{task}` - Update existing task
- `DELETE /tasks/{task}` - Delete task
- `PATCH /tasks/{task}/toggle` - Toggle task completion

### Profile Routes
- `GET /profile` - Display profile page
- `PUT /profile` - Update profile information
- `PUT /profile/password` - Change password
- `DELETE /profile` - Delete account

## File Structure

```
todo-app/
├── app/
│   ├── Http/Controllers/
│   │   ├── AuthController.php
│   │   ├── ProfileController.php
│   │   └── TaskController.php
│   └── Models/
│       ├── Task.php
│       └── User.php
├── database/
│   ├── database.sqlite
│   └── migrations/
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│       ├── auth/
│       ├── layouts/
│       ├── profile/
│       └── tasks/
├── routes/
│   └── web.php
└── README.md
```

## Future Enhancements

- **Task Categories**: Add categories or tags for better organization
- **Due Dates**: Add deadline functionality with notifications
- **Task Priority**: Implement priority levels for tasks
- **Search & Filter**: Add search and filtering capabilities
- **Data Export**: Allow users to export their tasks
- **API Version**: Create RESTful API for mobile app integration

## Contributing

1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

## License

This project is open-source and available under the [MIT License](LICENSE).

## Contact

For questions or support, please contact Ivan at amanyaivan36@gmail.com.

---

**Built with ❤️ using Laravel 10**
