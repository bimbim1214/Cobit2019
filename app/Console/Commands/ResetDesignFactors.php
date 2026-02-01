<?php

namespace App\Console\Commands;

use App\Models\DesignFactor;
use App\Models\User;
use Illuminate\Console\Command;

class ResetDesignFactors extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'df:reset {email? : Email user yang akan direset (optional, jika kosong reset semua)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset Design Factors untuk user tertentu atau semua user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');

        if ($email) {
            // Reset untuk user tertentu
            $user = User::where('email', $email)->first();

            if (!$user) {
                $this->error("User dengan email '{$email}' tidak ditemukan!");
                return 1;
            }

            if (!$this->confirm("Apakah Anda yakin ingin mereset semua Design Factor untuk user '{$user->name}' ({$user->email})?")) {
                $this->info('Reset dibatalkan.');
                return 0;
            }

            $this->resetUserDesignFactors($user);
            $this->info("✅ Design Factors untuk user '{$user->name}' berhasil direset!");
        } else {
            // Reset untuk semua user
            if (!$this->confirm('⚠️  Apakah Anda yakin ingin mereset SEMUA Design Factor untuk SEMUA user?')) {
                $this->info('Reset dibatalkan.');
                return 0;
            }

            $users = User::whereHas('designFactors')->get();
            $count = 0;

            foreach ($users as $user) {
                $this->resetUserDesignFactors($user);
                $count++;
            }

            $this->info("✅ Design Factors untuk {$count} user berhasil direset!");
        }

        return 0;
    }

    /**
     * Reset design factors untuk user tertentu
     */
    private function resetUserDesignFactors(User $user)
    {
        $designFactors = DesignFactor::where('user_id', $user->id)->get();

        foreach ($designFactors as $df) {
            // Delete all items first
            $df->items()->delete();
            // Delete the design factor
            $df->delete();
        }
    }
}
