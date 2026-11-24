param([int]$Port = 8000)
$ErrorActionPreference = 'Stop'
Set-Location $PSScriptRoot
$phpCommand = Get-Command php -ErrorAction SilentlyContinue
$phpExe = if ($phpCommand) { $phpCommand.Source } else { 'D:/NiFaSoft Website/development-tools/php/php.exe' }
if (-not (Test-Path -LiteralPath $phpExe)) { throw 'PHP 8.3+ is required. Add php.exe to PATH.' }
if (-not (Test-Path '.env')) { throw 'Configure .env before starting.' }
if (-not (Test-Path 'public/build/manifest.json')) { throw 'Run npm install and npm run build first.' }
& $phpExe artisan serve --host=127.0.0.1 --port=$Port