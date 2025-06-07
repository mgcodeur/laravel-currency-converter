<?php

namespace Mgcodeur\CurrencyConverter\Commands;

use Illuminate\Console\Command;

/**
 * Class CurrencyConverterCommand
 *
 * Command to install the laravel currency converter package.
 */
class CurrencyConverterCommand extends Command
{
    public $signature = 'currency-converter:install';

    public $description = 'Install the laravel currency converter package';

    /**
     * Handle the execution of the command.
     *
     * @return int The exit code of the command execution.
     */
    public function handle(): int
    {
        $this->comment('Publishing Laravel currency converter config file...');
        $this->callSilent('vendor:publish', ['--tag' => 'currency-converter-config']);
        $this->info('Laravel currency converter config file published successfully.');

        // TODO: Uncomment this when persistence feature is ready
        // $this->comment('Publishing laravel currency converter migrations...');
        // $this->callSilent('vendor:publish', ['--tag' => 'currency-converter-migrations']);
        // this->info('Laravel currency converter migrations published successfully.');
        $this->line("");

        echo "\033[1;35m";
        echo "─────────────────────────────────────────────────────────────────────────────\n";
        echo "\033[1;33m   ★  Thank you for installing laravel-currency-converter!  ★\n\033[1;35m";
        echo "─────────────────────────────────────────────────────────────────────────────\n";
        echo "\033[0m";
        echo "\033[1;37mIf you like this package, please give it a \033[1;33mstar\033[1;37m on GitHub :\n";
        echo "\033[1;36m👉 https://github.com/mgcodeur/laravel-currency-converter\n";
        echo "\033[0m";

        $this->line("");
        $this->line("");

        return self::SUCCESS;
    }
}
