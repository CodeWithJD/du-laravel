<?php

// Laravel ka initialization
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Database connection
use Illuminate\Support\Facades\DB;

// Old passwords ko database se fetch karo
$users = DB::table('users')->select('id', 'password')->get();

// Iterate through each user and hash their password using Laravel's hashing mechanism
foreach ($users as $user) {
    $oldPassword = $user->password;
    $hashedPassword = bcrypt($oldPassword);

    // Update the hashed password in the database
    DB::table('users')->where('id', $user->id)->update(['password' => $hashedPassword]);

    // Display the old password, user ID, and its corresponding hash
    echo "User ID: $user->id, Old Password: $oldPassword, New Hash: $hashedPassword\n";
}

?>
