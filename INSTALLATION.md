# Installation Instructions

Take a look at the *System Requirements*, then follow 
*Installation Instructions* and *Initialization* to complete installation.

All following steps assume an OSX system, but should be generic enough 
for Linux users to follow.


# System Requirements

* \*nix system (OSX, Linux)
* PHP 7.x
 * Composer 1.2.x


# Installation

## OSX Installation with HomeBrew

On an OSX system, PHP and Composer can be installed 
via [HomeBrew](http://brew.sh/).

Install with:

`brew install homebrew/php/php70 homebrew/php/composer`

The executables `php` and `composer` will be available from `/usr/local/bin`.


## Linux Installation

PHP is most easily installed via your distribution's package manager.
Composer can be installed by following instructions via its 
[Download Page](https://getcomposer.org/download/).

*note*: use the --install-dir and --filename options to make `composer`
available as an executable script.


# Initialization

With PHP and Composer installed, finish dependency setup by running
Composer's initialization:

`composer install`
