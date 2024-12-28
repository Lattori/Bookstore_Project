# Bookstore Project

# Project Title: Booksareus

## Overview

This project is a web-based bookstore management system that includes features for managing customers, books, comments, and user awards. It allows managers to log in and access a dashboard with various functionalities. Small-scale project with procedural PHP with CRUD functionality.

## Features

- User Authentication for customers and managers (Login and Logout)
- Customer Management
- Book Statistics
- User Awards
- Book Management
- Commenting System
- Purchase Books

## Prerequisites

Before you begin, ensure you have met the following requirements:

- **PHP**: Version 7.4 or higher
- **MySQL**: Version 5.7 or higher
- **Apache**: (or any other web server like xaampp)
- **Composer**: (for managing PHP dependencies)
- **Node.JS**

## Installation

1. **Clone the Repository**:
    ```sh
    git clone https://github.com/your-username/booksareus.git
    cd booksareus
    ```

2. **Set Up Environment**:
    - Ensure you have a local server set up using Apache (XAMPP, WAMP, or any other stack).
    - Create a new database in MySQL.

3. **Database Configuration**:
    - Import the database schema:
      ```sh
      mysql -u your_username -p your_password booksareus < bookstore.sql
      ```
    - Update `database.php` with your database credentials:
      ```php
      <?php
      $conn = new mysqli('localhost', 'your_username', 'your_password', 'bookstore');

      if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
      }
      ?>
      //Example use
      
      
      ```



## Running the Project

1. **Start the Local Server**:
    - Make sure your local server is running (e.g., Apache on XAMPP).

2. **Access the Project**:
    - Open your web browser and navigate to:
      ```sh
      http://localhost/index1.php
      ```



## Project Structure
booksareus/
├── comments.ink.php
├── database.php
├── managerlog.php
├── managerdash.html
├── addmanager.php
├── Customertable.php
├── booktable.php
├── user_awards.php
├── purchase.php
├── styles.css
├── README.md
├── index1.php
└── ...
# Explanation of Key Files and Directories - **comments.ink.php**: Contains functions and logic related to handling comments
- **database.php**: Contains the database connection settings and functions required to connect to the MySQL database. - 
**managerlog.php**: Handles the login functionality for managers. 
**managerdash.html**: The main dashboard for managers.  -
**addmanager.php**: Provides functionality to create new manager accounts.
 - **Customertable.php**: Contains code to manage customer information, such as viewing, editing, and deleting customer records.
 - **booktable.php**: Contains code to display book statistics and manage book records. This includes viewing, adding, editing, and deleting book entries. - **user_awards.php**: Displays user awards based on criteria like the most trusted and most useful users. It fetches and displays data related to user trust and usefulness scores. - **purchase.php**: Handles the purchase functionality, including updating stock levels and recording purchase orders.
 - **styles.css**: The main CSS file that contains styles for the entire project, ensuring a consistent look and feel across all pages. 
- **README.md**: Provides an overview of the project, installation instructions, and other essential information. This file helps new developers understand how to set up and work with the project. 
- **index1.php**: The home page of the project where users can navigate to different sections of the bookstore, such as browsing books or accessing their profiles. 
### Additional Files and Directories Other files and directories not listed might include additional functionalities such as user profiles, book details, and administrative tools. 

