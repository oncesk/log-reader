<?php

$file = $argv[1] ?? null;
if (!$file) {
    echo "Please, specify a log file!\n";
    exit(1);
} else if (!is_readable($file)) {
    echo "Error: No such file\n";
    exit(2);
}

echo "list of webpages with most page views ordered from most pages views to less page views\n";
system('php ' . __DIR__ . '/log-reader -o "{{ path }} {{ path_cnt }} visits" --sort-key=path_cnt --sort-order=desc --group-by=path --group-unique=ip --schema="path ip" ' . $file);
echo "\nlist of webpages with most unique page views also ordered\n";
system('php ' . __DIR__ . '/log-reader -o "{{ path }} {{ ip_unique }} unique views" --sort-key=ip_unique --sort-order=desc --group-by=path --group-unique=ip --schema="path ip" ' . $file);
