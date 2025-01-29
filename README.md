# Bookeo MVC Project

## Context
Another developer started this Bookeo site using an MVC structure. This site aims to allow visitors to view files about books, comics, and manga, and to comment and rate these files.
https://vimeo.com/1015300423?share=copy#

## Installation
* Fork this repository, then clone in it in your folder
* Next, you must create a MySQL database and import the `bookeo.sql` file.
* The database already contains a data set including two users (an administrator and a regular user):
    * `user@test.com`, password: `test` (do not use in a production environment :) )
    * `admin@test.com`, password: `test` (do not use in a production environment :) )
* Duplicate the `.env.example` file to `.env` and edit it to include your database information.
* Make sure the site works locally.

## Existing Features
Navigation and login are already completed. For the pages in progress, the HTML code has already been added in the various pages within the `templates` folder. The developer left a lot of @todo in the code.
You will need to finish the @todo and also modify the templates to display data.

## Remaining Tasks
* Finish displaying the list of books
* Finish displaying the last three books on the home page
* Finish displaying a book (detail)
* Finish adding and editing a book
* Finish creating a user account
* Finish adding comments
* Finish the ability to rate a book
* Add a pagination system on the book list
* Manage a CRUD in the front end (accessible only to admins) to handle authors
* Manage a new "genre" table (e.g., adventure, crime, horror, etc.). It should be possible to associate multiple genres with a single book.
* Ability to filter books by category
* Ability to perform a search on a book title (single keyword)
