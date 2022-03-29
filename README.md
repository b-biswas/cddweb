# Create a local server

## Relevant languages

Your browser allows you to read HTML and CSS files. The first contains the content of the website, the second contains its style.

To create a dynamic website, we need to use PHP (which creates HTML code), but your browser can't compile it: we need to put the code on a server.

## How to run PHP scripts

To compile a PHP script locally (to develop the website without people to see it online), we have to make your computer act like a server. To do so:
- on Windows: install WAMP
- on Linux: install XAMPP
- on Mac: install MAMP

It contains softwares like APACHE (to create the local server), PHP (to use PHP files), MySQL (to manage databases).

[Click here](https://openclassrooms.com/fr/courses/918836-concevez-votre-site-web-avec-php-et-mysql/4237816-preparez-votre-environnement-de-travail) for a quickstart documentation in french.

Once it's done, you have to create a directory on your local server (named `[directory_name]` in the following) and to copy and paste the website files that are in the GitLab repository into `[directory_name]`. Then, start the server and type `localhost/[directory_name]/` in the URL field of your browser, it should display the website.

# Database

For the registering system to work on your computer, you have to create 1 databases with 3 tables:
- one named `registered_users` with 6 attributes:
-- id: int(8), not null, primary key, auto-increment,
-- first_name: varchar(255), not null
-- last_name: varchar(255), not null,
-- email: varchar(55), not null, unique,
-- password: varchar(55), not null,
-- status: varchar(55), not null
- one named `allowed_users`, with 3 attributes:
-- id: int(8), not null, primary key, auto-increment,
-- email: varchar(55), not null, unique,
-- status: varchar(55), not null
- one named `uploaded_abstracts`, with 5 attributes
-- id: int(8), not null, primary_key,
-- title: varchar(255), not null,
-- email: varchar(55), not null, unique,
-- first_name: varchar(255), not null,
-- last_name: varchar(255), not null,
-- date: timestamp, null

If you don't want to create the tables by hand, you can create only the database. Then, log in with your admin account, go to the "admin" section of the website, and use the link "Create tables".

For this database to work on the real server, we'll have to change the host, the database name, the username and the password in `DataSource.php` and `DBConnect.php`. **Don't forget to change these values if you use your own databse on your computer before adding these two files to the website**, or users couldn't register or log in anymore.

# Abstract submission

The abstract section appears only when the user is logged in.

The abstract submission form move the PDF in `abstracts/`. This directory must have the right permissions. From the root of the website directory, use the command:

```sh
$ sudo chmod 777 abstracts/
```
before the first submission.

The pdf file will be named `abstract[user_id].pdf`, with `[user_id]` the ID corresponding to the user in the table `registered_user`. When using this form, the abstract will be added to the table `uploaded_abstracts` with the same ID as the user and the abstract title. This way, we can know exactly who submitted an abstract, and if this person wants to modify it, they just have to submit the abstract again with the modifications.

# Registrations

## Status system

There are 2 databases related to the registration process:
- `allowed_users`: which contains all the email adresses with which we can create an account (attributes: id, email, status)
- `registered_users`: which includes all the users that created an account (attributes: id, first name, last name, email address, password, status)

The ID in the table `allowed_users` is temporary (we need a primary key), and won't impact the ID in the table `registered_users` and `uploaded_abstracts`.

The possible status are:
- guest (for the speakers)
- management (for the administration of STEP'UP)
- elder (for D2 and D3)
- meeting (Meeting team)
- communication (Communication team)
- foreign (Foreign student team)
- job (Job team)
- logistics (Logistics team)
- coordination (Coordination team)
- admin (Web team)

The status is an additional information on the users, granting them some new features on the web site when logged in:
- everyone will see the new button "Asbtract", whatever the status
- only persons with the status "job" and "coordination" [we can add other an status corresponding to another group supposed to find speakers if necessary] can see the button "Guests" with a form to add a new email address in the table `allowed_users`.
- only persons with the status "admin" (members of the web team) can see everything on the website. It includes:
-- the button "Admin" which lets you manage the database
-- in the form to add allowed email addresses in the section "Guests", a new field which lets you choose the status associated to the email address.

## Set the status of an user

The web team has to add in the table `allowed_users`:
- all the D1 (specifying their group, such as coordination, foreign, logistics...)
- all the D2 and D3 (specifying they are D2/D3)
- all the members of the STEP'UP administration (specifying they are in the administration)

In the "Admin" section, there is a link "Allow STEP'UP members to register" that runs the script `admin/step_up_members.php`. It contains all the 1st year PhD students with their group to automatically add them to the table `allowed_users`. Some of them didn't give their email addresses, so we'll need to add them by hand with the "Guests" section (we have to specify their status, so we can't let the coordination and job teams do it). We still need to add the D2/D3 and administration email addresses in this script. Right now, this script has been commented (except the part with the web team members). It has to be uncommented and ran again once the website is totally done to let people register.

When it's done, the teams in charge of the recruitment (coordination/job) will add the speakers' email addresses with the "Guests" section so they can register. Their status will be "guest" by default.

By using this status organization, if a team (or the administration of STEP'UP) is asking for a new feature on the website that only them are supposed to access, it will be easy to provide it.
