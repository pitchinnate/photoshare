## PhotoShare

A simple application written in laravel 5.1 to allow you to share photos with family and friends but have some security also. You can limit who can see each photo album and the photos in it.

### Features

- Upload multiple photos at a time with progress bar
- Automatic thumbail creation
- Rotate photos
- Delete photos
- Download photos
- Multiple Administrators
- Email Invites
- Email Notifications

## Setup

####Site Administrator

The first person registered will automatically be made an administrator. You can make other users administrators from the user list when logged in as an administrator.

####Admin Email

The administrator email where emails will be sent for notifications of new user signups can be set in your environment variable `ADMIN_ADDRESS`.

####Album Page Size

By default the system will display 15 photos per page when you view an album. You can adjust this by simply updating the environment variable `PAGE_SIZE`.

### License

Open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
