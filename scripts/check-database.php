<?php
require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
if (config('database.default') !== 'mysql' || config('database.connections.mysql.database') !== 'nifasoft_web' || config('database.connections.mysql.prefix') !== 'nmms_') throw new RuntimeException('Unexpected database or prefix');
$pdo = Illuminate\Support\Facades\DB::connection()->getPdo();
$tables = $pdo->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);
$counts = [];
foreach ($tables as $table) {
if (str_starts_with($table, 'nmms_')) continue;
$quoted = chr(96).str_replace(chr(96), chr(96).chr(96), $table).chr(96);
$counts[$table] = (int) $pdo->query('SELECT COUNT(*) FROM '.$quoted)->fetchColumn();
}
$file = __DIR__.'/../storage/app/database-baseline.json';
if (($argv[1] ?? '') === 'before') {
file_put_contents($file, json_encode($counts, JSON_PRETTY_PRINT));
echo 'Recorded existing table row counts: '.count($counts).PHP_EOL;
} else {
if ($counts !== json_decode(file_get_contents($file), true)) throw new RuntimeException('Existing counts changed');
echo 'Verified unchanged existing table row counts: '.count($counts).PHP_EOL;
}