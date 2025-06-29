-- Update existing active bookings to completed status
-- Run this to allow users to make new bookings

UPDATE booking 
SET status_booking = 'Selesai' 
WHERE status_booking = 'Aktif' 
AND tanggal_selesai < CURDATE();

-- Update room status back to available for rooms with completed bookings
UPDATE kamar 
SET status = 'Kosong' 
WHERE id_kamar IN (
    SELECT DISTINCT id_kamar 
    FROM booking 
    WHERE status_booking = 'Selesai'
) 
AND status = 'Dipesan'; 