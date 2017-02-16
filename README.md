# Introduction

This project generates invoices from selected products, which can possibly
have sales tax and/or import tax.

Please first read the [installation instructions](INSTALL.md) before
attempting to execute the package.


# Directory Structure

bin/            package executables. See *Script Execution* below.
composer.json   used by Composer
composer.lock   used by Composer
examples/       JSON files matching the project's input specifications
spec/           PHPSpec test files
src/            source code
vendor/         files automatically installed by Composer


# Script Execution

## Building Invoices

Based on your desired example JSON file from the [example subdirectory](examples/), 
run the following from the command line through Composer.  

For instance, to process `examples/input_1.json` and display its invoice:

`composer run-script app input_1.json`

This will:

1. parse the JSON file into Products
2. populate an Order with OrderItems containing the Products
3. output a nicely formatted Invoice


## Running PHPSpec Tests

[PHPSpec](http://www.phpspec.net/) is a BDD test suite in the style of RSpec. 

To execute all tests:

`bin/phpspec run`


To execute a specific test:

`bin/phpspec run spec/models/ProductSpec.php`


# Project Details

As specified:

Basic sales tax is applicable at a rate of 10% on all goods, except books, food, and medical products that are exempt. Import duty is an additional sales tax applicable on all imported goods at a rate of 5%, with no exemptions.

When I purchase items I receive a receipt which lists the name of all the items and their price (including tax), finishing with the total cost of the items, and the total amounts of sales taxes paid. The rounding rules for sales tax are that for a tax rate of n%, a shelf price of p contains (np/100 rounded up to the nearest 0.05) amount of sales tax.

Write an application that prints out the receipt details for these shopping baskets.

Input 1:
1 book at 12.49
1 music CD at 14.99
1 chocolate bar at 0.85

Input 2:
1 imported box of chocolates at 10.00
1 imported bottle of perfume at 47.50

Input 3:
1 imported bottle of perfume at 27.99
1 bottle of perfume at 18.99
1 packet of headache pills at 9.75
1 box of imported chocolates at 11.25

Output 1:
1 book : 12.49
1 music CD: 16.49
1 chocolate bar: 0.85

Sales Taxes: 1.50
Total: 29.83

Output 2:
1 imported box of chocolates: 10.50
1 imported bottle of perfume: 54.65

Sales Taxes: 7.65
Total: 65.15

Output 3:
1 imported bottle of perfume: 32.19
1 bottle of perfume: 20.89
1 packet of headache pills: 9.75
1 imported box of chocolates: 11.85

Sales Taxes: 6.70
Total: 74.68
