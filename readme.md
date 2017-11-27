#Payroll Calculator

## Environment Requirements
* PHP 7.0
* PHPUNIT 6.0

## Execution 
Run the following command from the root of the project to generate a file.

### Command
 ```php src/script/CreatePayrollScript.php {year} {filename}```
 
 ### Example Command
 ```php src/script/CreatePayrollScript.php 2015 samstestfile```
 
## TODO
* Add Symfony Console Component to provide better cli validation and ux
* Add localisation options
* Expand PHPunit coverage to include mocking of payroll objects
