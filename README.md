# Introduction

This is the take-home project for Socrata's frontend engineer application 
by Eric Malone (ejmalone@gmail.com).

Please first read the [installation instructions](INSTALLATION.md) before
attempting to execute the package.


# Directory Structure

bin/            package executables. See *Running Executable* below.
composer.json   used by Composer
composer.lock   used by Composer
examples/       JSON files conforming to the project's inputs
spec/           PHPSpec test files
src/            source code
vendor/         files automatically installed by Composer


# Running Executables

## Building Invoices

Based on your desired [example](examples/) JSON file, run the following from the
command line. For instance, to process `examples/input_1.json` for display:

`composer run-script runner input_1.json`

This will parse the JSON file, populate an Order with OrderItems containing
the Products from the JSON file, and output a nicely formatted Invoice.


## Running PHPSpec Tests

From the command line, to execute all tests:

`bin/phpspec run`


To execute a specific test, here is example syntax for the PHPSpec test against
the Product class:

`bin/phpspec run spec/models/ProductSpec.php`


# Project Details

From Stan Rawrysz:

PROBLEM ONE: SALES TAXES

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
