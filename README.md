# testAPI
API endpoint: https://jsonplaceholder.typicode.com/users

Here we use PHP with CURL to pull the user data from the API and display the data.

Setup:

§  We create cURL connection to pull the data

§  create a collection class object (in pure PHP) to hold all the users

§  create another User class object to hold each user

§  We convert all phone numbers to digits only, moving any extensions to a separate property

§  validate each email address (set new property, email_valid, to true or fasle based on valid or not) and make 

Finally:

§  We loop through users and export the data to a CSV file with the following headings:

                first name, last name, company name, email, phone, extension, city
