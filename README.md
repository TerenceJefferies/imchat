imchat
======

imchat is a simple instant message chat system that uses AJAX and PHP to request and create chat messages. imchat is designed to be as visually customizable as possible, for that reason the script will not create any HTML or CSS for you, instead you should supply the script with the classnames you use when creating the markup. Alternitevelly you can use the pre-defined class names.

Implementation:

To implement IM Chat you must following a few steps:

1. Create a new MySQL database on your webserver, and import the SQL file supplied.
2. Upload the contents of the php folder to a suitable location on your webserver.
3. Amend the include sources in both poll.php and post.php to match your file structure.
4. Edit the database configuration variables in the ajax.php class. You should change the following:

- dbHost: To match the hostname of your mysql server
- dbUser: To match the username of the account to login with
- dbPassword: To match the password of the account to login with
- dbName: To match the name of the database to use

5. Upload the contents of the js folder to an appropriate location on your webserver
6. Include both jQuery.js (if not already included) and imchat.js in your markup
7. Create your markup (Refer to example on the basic structure, layout and operation of the markup. Or copy the example markup and edit for your needs.)
8. Run and enjoy