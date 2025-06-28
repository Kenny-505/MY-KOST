<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Convert any existing base64 string data to binary format
        $this->convertBase64ToBinary();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration is not reversible as we're converting data format
        // The HasImages trait now handles both formats automatically
    }

    /**
     * Convert base64 string data to binary format
     */
    private function convertBase64ToBinary(): void
    {
        $kamars = DB::table('kamar')->get();
        
        foreach ($kamars as $kamar) {
            $updates = [];
            
            for ($i = 1; $i <= 3; $i++) {
                $field = "foto_kamar$i";
                $data = $kamar->$field;
                
                if (!empty($data) && $this->isBase64String($data)) {
                    // Convert base64 string to binary
                    $binaryData = base64_decode($data);
                    if ($binaryData !== false) {
                        $updates[$field] = $binaryData;
                    }
                }
            }
            
            if (!empty($updates)) {
                DB::table('kamar')
                    ->where('id_kamar', $kamar->id_kamar)
                    ->update($updates);
            }
        }
    }

    /**
     * Check if string is a valid base64 encoded string
     */
    private function isBase64String($data): bool
    {
        if (!is_string($data) || empty($data)) {
            return false;
        }

        // Check if string contains only valid base64 characters
        if (!preg_match('/^[A-Za-z0-9+\/]*={0,2}$/', $data)) {
            return false;
        }

        // Try to decode
        $decoded = base64_decode($data, true);
        if ($decoded === false || strlen($decoded) < 10) {
            return false;
        }

        // Check for image signatures
        $signature = substr($decoded, 0, 8);
        return (strpos($signature, "\xFF\xD8\xFF") === 0 || // JPEG
                strpos($signature, "\x89PNG\r\n\x1a\n") === 0 || // PNG
                strpos($signature, "GIF87a") === 0 || // GIF87a
                strpos($signature, "GIF89a") === 0); // GIF89a
    }
}; 