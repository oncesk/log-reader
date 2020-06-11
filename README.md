Log Reader
=================

Sometimes you need to reformat logs, filter and grouping. This tool will help you to do that

## Key features

 * formatting output
 * ready for piping, PHP generators help us to read => format => write logs one by one, it depends on php output buffer setting
 * sorting
 * filtering, regex is supporting
 * grouping items
 
## Installation

You need to have git and composer installed

 * ``git clone https://github.com/oncesk/log-reader.git``
 * ``cd log-reader && composer install``
 
## Features
 
#### Options

Please use ``-h`` flag to see all list of options
 
#### Formatting

You are available to set a schema for the logs and after that you can manipulate with date output

Use ``--schema`` option:

``./bin/log-reader --schema="path ip" file.log``

And now you are able to change format, lets swap positions for path and ip

``./bin/log-reader --schema="path ip" -o "{{ ip }} {{ path }}" resources/webserver.log``

Use ``--pipe`` option for pipe the data

#### Sorting

Add ``--sort-key=path --sort-order=desc`` for sorting items by path column and apply desc order

#### Filtering

 * ``--filter=home`` all items will be filtered according the filter value
 * ``--filter-regex="/home|contact/"`` filter according regular expression
 
#### Grouping

It is possible to group items by several columns. Count column will be available for formatting by the following pattern ``${column}_cnt``
Grouping is very similar to SQL behaviour
 
 * ``--group-by=path`` it will group all records by path column and count variable will be accessible ``{{ path_cnt }}``
 * ``--group-by=path --group-by=ip`` group items by path and ip

## Examples

Parse webserver logs

``php bin/parser.php resources/webserver.log`` 

Imagine that we have a log file with: path and ip ``/index 122.222.112.32``

Lets find how many times the index and contact pages were opened and find unique ip addresses

``./bin/log-reader -o "{{ path }} {{ path_cnt }} {{ ip }} {{ ip_cnt }}" --sort-key=path_cnt --sort-order=desc --group-by=path --group-by=ip ./resources/webserver.log``

## Testing

Unit tests:

``php vendor/bin/phpunit tests/Unit``

Integration tests:

``php vendor/bin/phpunit tests/Integration``

## TODO

 * need more time to cover all features, make code clean, rewrite some code fragments, do optimization
 * simplify few things and refactor
 * add ability to read remote logs
 * omit Record abstraction, use array instead
